/* eslint-disable @wordpress/i18n-ellipsis */
import { loadEventList } from '../../events-loader.js'
import {
  showLoadingIndicator,
  hideLoadingIndicator
} from '../../events-displayer.js'

const { InspectorControls, useBlockProps } = wp.blockEditor
const { PanelBody } = wp.components
const { useEffect } = wp.element
const { __ } = wp.i18n

const NAME = '<wordpress-name>'

let timer

export default ({ attributes, setAttributes }) => {
  const blockProps = useBlockProps({
    className: NAME + '_events-list',
    'data-maximum': attributes.eventsCount,
    'data-group-name': attributes.groupName,
  })
  function reloadEventList() {
    if (timer) {
      clearTimeout(timer)
    }
    timer = setTimeout(() => {
      const container = document.getElementById(blockProps.id)
      if (container) {
        // loadEventList(container)
        // TODO use API instead
        
        // TODO not using newest values yet
        showLoadingIndicator(container)
        const eventsCount = attributes.eventsCount
        const groupName = attributes.groupName
        let url = `/wp-json/connector-mobilizon/v1/events?eventsCount=${eventsCount}`
        if (groupName) {
          url += `&groupName=${groupName}`
        }
        fetch(url)
          .then((response) => response.text()) // TODO also handle response.ok being false
          .then((data) => {
            console.log(data) // TODO handle
          })
          .finally(() => {
            hideLoadingIndicator(container)
          })
      }
    }, 500)
  }
  useEffect(() => {
    reloadEventList()
  }, [])
  function updateEventsCount(event) {
    let newValue = Number(event.target.value)
    if (newValue < 1) newValue = 1
    setAttributes({ eventsCount: newValue })
    reloadEventList()
  }
  function updateGroupName(event) {
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
