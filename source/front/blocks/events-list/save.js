/* eslint-disable @wordpress/i18n-ellipsis */
const { __ } = wp.i18n

const NAME = '<wordpress-name>'

export default ({ attributes }) => {
  return (
    <div
      className={NAME + '_events-list'}
      data-maximum={attributes.eventsCount}
      data-group-name={attributes.groupName}
    >
      <div style="display: none;">
        {__('The events could not be loaded!', '<wordpress-name>')}
      </div>
      <div style="display: none;">
        {__('The group could not be found!', '<wordpress-name>')}
      </div>
      <ul>
        <li>{__('Loading...', '<wordpress-name>')}</li>
      </ul>
    </div>
  )
}
