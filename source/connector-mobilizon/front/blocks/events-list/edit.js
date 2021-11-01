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
  return ([
    <InspectorControls>
      <PanelBody title={ __('Events List Settings', '<wordpress-name>') }>
        <label className="components-base-control__label">{ __('Number of events to show', '<wordpress-name>') }</label>
        <input className="components-text-control__input" type="number" value={ attributes.eventsCount } onChange={ updateEventsCount } />
        <label className="components-base-control__label">{ __('Group name (optional)', '<wordpress-name>') }</label>
        <input className="components-text-control__input" type="text" value={ attributes.groupName } onChange={ updateGroupName } />
      </PanelBody>
    </InspectorControls>,
    <ul>
      { [...Array(attributes.eventsCount)].map((_, i) => <li className="busterCards" key={ i }>{ __('Event', '<wordpress-name>') } { i }</li>) }
    </ul>
  ])
}
