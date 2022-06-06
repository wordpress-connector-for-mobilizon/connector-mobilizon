/* eslint-disable @wordpress/i18n-ellipsis */
const { useBlockProps } = wp.blockEditor
const { __ } = wp.i18n

const NAME = '<wordpress-name>'

export default ({ attributes }) => {
  const blockProps = useBlockProps.save({
    className: NAME + '_events-list',
  })
  return (
    <div
      data-maximum={attributes.eventsCount}
      data-group-name={attributes.groupName}
      {...blockProps}
    >
      <div className="general-error" style={{ display: 'none' }}>
        {__('The events could not be loaded!', '<wordpress-name>')}
      </div>
      <div className="group-not-found" style={{ display: 'none' }}>
        {__('The group could not be found!', '<wordpress-name>')}
      </div>
      <div className="loading-indicator" style={{ display: 'none' }}>
        {__('Loading...', '<wordpress-name>')}
      </div>
      <ul></ul>
    </div>
  )
}
