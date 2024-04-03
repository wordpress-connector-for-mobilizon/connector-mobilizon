/* eslint-disable @wordpress/i18n-ellipsis */
import {
  clearEventsList,
  displayErrorMessage,
  displayEvents,
  hideErrorMessages,
  showLoadingIndicator,
} from '../../events-displayer.js'

const { InspectorControls, useBlockProps } = wp.blockEditor
const { PanelBody } = wp.components
const { useEffect } = wp.element
const { __ } = wp.i18n

const NAME = '<wordpress-name>'

let timer

export default ({ attributes, setAttributes }) => {
  const { eventsCount, groupName } = attributes
  const blockProps = useBlockProps({
    className: NAME + '_events-list',
  })
  function reloadEventList() {
    if (timer) {
      clearTimeout(timer)
    }
    timer = setTimeout(() => {
      const container = document.getElementById(blockProps.id)
      if (container) {
        // TODO not using newest values yet, can get out of sync
        hideErrorMessages(container)
        clearEventsList(container)
        showLoadingIndicator(container)
        let url = `/wp-json/connector-mobilizon/v1/events?eventsCount=${eventsCount}`
        if (groupName) {
          url += `&groupName=${groupName}`
        }
        fetch(url)
          .then((response) => response.text()) // TODO also handle response.ok being false
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
    reloadEventList()
  }, [])
  function updateEventsCount(event) {
    // console.log('new value: ', event.target.value) // TODO
    let newValue = Number(event.target.value)
    if (newValue < 1) newValue = 1
    setAttributes({ eventsCount: newValue })
    reloadEventList()
  }
  function updateGroupName(event) {
    // console.log('new value: ', event.target.value) // TODO
    // TODO not triggered on pasting only
    setAttributes({ groupName: event.target.value })
    reloadEventList()
  }
  return [
    <InspectorControls>
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
          value={eventsCount}
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
          value={groupName}
          onChange={updateGroupName}
          id={NAME + '_group-name'}
        />
      </PanelBody>
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
    </div>,
  ]
}
