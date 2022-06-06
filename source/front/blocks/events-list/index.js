import edit from './edit.js'
import save from './save.js'

const { registerBlockType } = wp.blocks
const { __ } = wp.i18n

const NAME = '<wordpress-name>'

registerBlockType(NAME + '/events-list', {
  apiVersion: 2,
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
