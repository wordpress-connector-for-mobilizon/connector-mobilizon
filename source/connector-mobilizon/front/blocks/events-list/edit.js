const { InspectorControls } = wp.blockEditor
const { PanelBody } = wp.components
const { __ } = wp.i18n

export default ({ attributes, setAttributes }) => {
  function updateEventsCount(event) {
    let newValue = Number(event.target.value)
    if (newValue < 1) newValue = 1
    setAttributes({ eventsCount: newValue })
  }
  function updateGroupName(event) {
    setAttributes({ groupName: event.target.value })
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
    <ul>
      {[...Array(attributes.eventsCount)].map((_, i) => (
        <li className="busterCards" key={i}>
          {__('Event', '<wordpress-name>')} {i}
        </li>
      ))}
    </ul>,
  ]
}
