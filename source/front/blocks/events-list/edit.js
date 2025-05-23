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
const { useEffect } = wp.element
const { __ } = wp.i18n

const NAME = '<wordpress-name>'

export default ({ attributes, setAttributes }) => {
  let timer
  const blockProps = useBlockProps({
    className: NAME + '_events-list',
  })
  function reloadEventList(eventsCount, groupName) {
    if (timer) {
      clearTimeout(timer)
    }
    timer = setTimeout(async () => {
      const container = document.getElementById(blockProps.id)
      if (container) {
        hideErrorMessages(container)
        clearEventsList(container)
        showLoadingIndicator(container)
        let url = `/wp-json/connector-mobilizon/v1/events?eventsCount=${eventsCount}`
        let showMoreUrl = window.MOBILIZON_CONNECTOR.url
        if (groupName) {
          showMoreUrl += '/@' + groupName + '/events'
          url += `&groupName=${groupName}`
        }
        container.querySelector('a').href = showMoreUrl
        await fetch(url)
          .then((response) => response.text())
          .then((data) => {
            const events = JSON.parse(data)
            displayEvents({
              events,
              document,
              container,
              maxEventsCount: eventsCount,
            })
          })
          .catch((data) => {
            displayErrorMessage({ data, container })
          })
      }
    }, 500)
  }
  useEffect(() => {
    reloadEventList(attributes.eventsCount, attributes.groupName)
  }, [])
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
      <ul style={{ 'list-style-type': 'none', 'padding-left': 0 }}></ul>
      <a
        href=""
        target="_blank"
        style={{ display: 'inline-block', 'margin-top': '20px;' }}
      >
        {__('Show more events', '<wordpress-name>')}
      </a>
    </div>,
  ]
}
