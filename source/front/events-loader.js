import { displayEvents, displayErrorMessage } from './events-displayer.js'
import * as GraphqlWrapper from './graphql-wrapper.js'

const NAME = '<wordpress-name>'
const URL_SUFFIX = '/api'

document.addEventListener('DOMContentLoaded', loadEventLists)

export function loadEventLists() {
  const eventLists = document.getElementsByClassName(NAME + '_events-list')
  for (const list of eventLists) {
    loadEventList(list)
  }
}

function loadEventList(list) {
  const url = SETTINGS.url + URL_SUFFIX
  const limit = parseInt(list.getAttribute('data-maximum'))
  const groupName = list.getAttribute('data-group-name')
  if (groupName) {
    GraphqlWrapper.getUpcomingEventsByGroupName({ url, limit, groupName })
      .then((data) => displayEvents({ data, document, list }))
      .catch((data) => displayErrorMessage({ data, list }))
  } else {
    GraphqlWrapper.getUpcomingEvents({ url, limit })
      .then((data) => displayEvents({ data, document, list }))
      .catch((data) => displayErrorMessage({ data, list }))
  }
}
