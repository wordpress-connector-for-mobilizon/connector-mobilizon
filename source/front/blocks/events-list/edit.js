/* eslint-disable jsx-a11y/anchor-is-valid */
/* eslint-disable @wordpress/i18n-ellipsis */
import {
  clearEventsList,
  displayErrorMessage,
  displayEvents,
  hideErrorMessages,
  showLoadingIndicator,
} from '../../events-displayer.js'

const { InspectorControls, useBlockProps } = wp.blockEditor
const { Panel, PanelBody } = wp.components
const { useEffect, useRef, useState } = wp.element
const { __, sprintf } = wp.i18n

const NAME = '<wordpress-name>'

export default ({ attributes, setAttributes }) => {
  const [groups, setGroups] = useState([])
  const [showMoreUrl, setShowMoreUrl] = useState('')

  const timerRef = useRef(null)

  const blockProps = useBlockProps({
    className: NAME + '_events-list',
  })

  function reloadEventList(eventsCount, groupName) {
    if (timerRef.current) {
      clearTimeout(timerRef.current)
    }
    timerRef.current = setTimeout(async () => {
      const container = document.getElementById(blockProps.id)
      if (!container) {
        return
      }

      hideErrorMessages(container)
      clearEventsList(container)
      showLoadingIndicator(container)

      if (groupName) {
        const groupNames = groupName.split(',').map((name) => name.trim())
        const updatedGroups = groupNames.map((name) => ({
          name,
          url: `${window.MOBILIZON_CONNECTOR.url}/@${name}/events`,
        }))
        setGroups(updatedGroups)
      } else {
        setGroups([])
      }
      setShowMoreUrl(window.MOBILIZON_CONNECTOR.url)

      try {
        const data = await fetchEvents(eventsCount, groupName)
        const events = JSON.parse(data)
        displayEvents({
          blockClassName: NAME + '_events-list',
          events,
          document,
          container,
          maxEventsCount: eventsCount,
        })
      } catch (error) {
        let message = ''
        try {
          message = JSON.parse(error)
        } catch ($e) {
          message = 'Parsing the error message failed.'
        }
        displayErrorMessage({ data: message, container })
      }
    }, 500)
  }

  useEffect(() => {
    reloadEventList(attributes.eventsCount, attributes.groupName)
  }, [])

  async function fetchEvents(eventsCount, groupName) {
    let url = `/wp-json/connector-mobilizon/v1/events?eventsCount=${eventsCount}`
    if (groupName) {
      url += `&groupName=${groupName}`
    }
    const response = await fetch(url)
    if (!response.ok) {
      const data = await response.text()
      throw new Error(data)
    }
    return response.text()
  }

  function updateEventsCount(event) {
    let newValue = Number(event.target.value)
    if (newValue < 1) {
      newValue = 1
    }
    setAttributes({ eventsCount: newValue })
    reloadEventList(newValue, attributes.groupName)
  }

  function updateGroupName(event) {
    const newValue = event.target.value
    setAttributes({ groupName: newValue })
    reloadEventList(attributes.eventsCount, newValue)
  }

  return [
    <InspectorControls>
      <Panel>
        <PanelBody title={__('Events List Settings', '<wordpress-name>')}>
          <label
            className="components-base-control__label"
            htmlFor={NAME + '_events-count'}
          >
            {__('Number of events to show', '<wordpress-name>')}
          </label>
          <input
            className="components-text-control__input"
            type="number"
            value={attributes.eventsCount}
            onChange={updateEventsCount}
            id={NAME + '_events-count'}
          />
          <label
            className="components-base-control__label"
            htmlFor={NAME + '_group-name'}
            style={{ paddingTop: '24px' }}
          >
            {__('Group name (optional)', '<wordpress-name>')}
          </label>
          <input
            className="components-text-control__input"
            type="text"
            value={attributes.groupName}
            onChange={updateGroupName}
            id={NAME + '_group-name'}
          />
          <p className="components-base-control__help">
            {__(
              'Use comma-separated names for multiple groups.',
              '<wordpress-name>',
            )}
          </p>
        </PanelBody>
      </Panel>
    </InspectorControls>,
    <div {...blockProps}>
      <div className="general-error" style={{ display: 'none' }}>
        {__('The events could not be loaded!', '<wordpress-name>')}
      </div>
      <div className="group-not-found" style={{ display: 'none' }}>
        {__('The group could not be found!', '<wordpress-name>')}
      </div>
      <div className="loading-indicator" style={{ display: 'none' }}>
        {__('Loading...', '<wordpress-name>')}
      </div>
      <ul style={{ listStyleType: 'none', paddingLeft: 0 }}></ul>
      <div className={NAME + '_events-list__more-section'}>
        {groups.length ? (
          groups.map((group) => (
            <a
              key={group.name}
              href={group.url}
              target="_blank"
              rel="noopener noreferrer"
              style={{ display: 'inline-block', marginTop: '20px' }}
            >
              {sprintf(
                // translators: %s: a group name
                __('Show more events of %s', '<wordpress-name>'),
                group.name,
              )}
            </a>
          ))
        ) : (
          <a
            href={showMoreUrl}
            target="_blank"
            rel="noopener noreferrer"
            style={{ display: 'inline-block', marginTop: '20px' }}
          >
            {__('Show more events', '<wordpress-name>')}
          </a>
        )}
      </div>
    </div>,
  ]
}
