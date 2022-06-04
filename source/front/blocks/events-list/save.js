const { __ } = wp.i18n

const NAME = '<wordpress-name>'

export default ({ attributes }) => {
  return (
    <ul
      className={NAME + '_events-list'}
      data-maximum={attributes.eventsCount}
      data-group-name={attributes.groupName}
    >
      <li style="display: none;">
        {__('The events could not be loaded!', '<wordpress-name>')}
      </li>
      <li style="display: none;">
        {__('The group could not be found!', '<wordpress-name>')}
      </li>
    </ul>
  )
}
