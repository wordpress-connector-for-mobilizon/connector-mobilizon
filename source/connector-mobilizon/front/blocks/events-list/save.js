const { __ } = wp.i18n

const NAME = '<wordpress-name>'

const URL = 'https://mobilizon.fr' // TODO
const LOCALE = 'en-GB' // TODO
const TIMEZONE = 'Europe/Rome' // TODO
const isShortOffsetNameShown = true // eslint-disable-line no-unused-vars

export default ({ attributes }) => {
  return (
    <ul
      className={NAME + '_events-list'}
      data-url={URL}
      data-locale={LOCALE}
      data-maximum={attributes.eventsCount}
      data-group-name={attributes.groupName}
      data-time-zone={TIMEZONE}
    >
      <li style="display: none;">
        {__('The events could not be loaded!', '<wordpress-name>')}
      </li>
    </ul>
  )
}
