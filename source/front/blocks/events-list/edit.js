/* eslint-disable @wordpress/i18n-ellipsis */
import { loadEventList } from '../../events-loader.js'

const { InspectorControls, useBlockProps } = wp.blockEditor
const { useEffect } = wp.element
const { PanelBody } = wp.components
const { __ } = wp.i18n

const NAME = '<wordpress-name>'

export default ({ attributes, setAttributes }) => {
  const blockProps = useBlockProps({
    className: NAME + '_events-list',
    'data-maximum': attributes.eventsCount,
    'data-group-name': attributes.groupName,
  })
  useEffect(() => {
    reloadEventList()
  }, [])
  function reloadEventList() {
    const container = document.getElementById(blockProps.id)
    if (container) {
      loadEventList(container)
    }
  }
  function updateEventsCount(event) {
    let newValue = Number(event.target.value)
    if (newValue < 1) newValue = 1
    setAttributes({ eventsCount: newValue })
    reloadEventList()
  }
  function updateGroupName(event) {
    setAttributes({ groupName: event.target.value })
    reloadEventList()
  }
  return [
    <InspectorControls>
      <PanelBody title={__('Events List Settings', '<wordpress-name>')}>
        <label
          className="components-base-control__label"
          htmlFor="<wordpress-name>_events-count"
        >
          {__('Number of events to show', '<wordpress-name>')}
        </label>
        <input
          className="components-text-control__input"
          type="number"
          value={attributes.eventsCount}
          onChange={updateEventsCount}
          id="<wordpress-name>_events-count"
        />
        <label
          className="components-base-control__label"
          htmlFor="<wordpress-name>_group-name"
        >
          {__('Group name (optional)', '<wordpress-name>')}
        </label>
        <input
          className="components-text-control__input"
          type="text"
          value={attributes.groupName}
          onChange={updateGroupName}
          id="<wordpress-name>_group-name"
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
