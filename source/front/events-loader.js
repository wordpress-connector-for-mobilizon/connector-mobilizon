import { displayEvents, displayErrorMessage } from './events-displayer.js'
import * as GraphqlWrapper from './graphql-wrapper.js'

const NAME = '<wordpress-name>'
const URL_SUFFIX = '/api'

document.addEventListener('DOMContentLoaded', loadEventLists)

function loadEventLists() {
  const eventLists = document.getElementsByClassName(NAME + '_events-list')
  for (const list of eventLists) {
    loadEventList(list)
  }
}

export function loadEventList(container) {
  const url = SETTINGS.url + URL_SUFFIX
  const limit = parseInt(container.getAttribute('data-maximum'))
  const groupName = container.getAttribute('data-group-name')
  if (groupName) {
    GraphqlWrapper.getUpcomingEventsByGroupName({ url, limit, groupName })
      .then((data) => displayEvents({ data, document, container }))
      .catch((data) => displayErrorMessage({ data, container }))
  } else {
    GraphqlWrapper.getUpcomingEvents({ url, limit })
      .then((data) => displayEvents({ data, document, container }))
      .catch((data) => displayErrorMessage({ data, container }))
  }
}
