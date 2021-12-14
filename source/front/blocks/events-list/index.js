import edit from './edit'
import save from './save'

const { registerBlockType } = wp.blocks
const { __ } = wp.i18n

const NAME = '<wordpress-name>'

registerBlockType(NAME + '/events-list', {
  title: __('Events List', '<wordpress-name>'),
  description: __(
    'A list of the upcoming events of the connected Mobilizon instance.',
    '<wordpress-name>'
  ),
  icon: 'list-view',
  category: 'widgets',
  attributes: {
    eventsCount: {
      type: 'number',
      default: 3,
    },
    groupName: {
      type: 'string',
    },
  },
  supports: {
    html: false,
  },
  edit,
  save,
})
