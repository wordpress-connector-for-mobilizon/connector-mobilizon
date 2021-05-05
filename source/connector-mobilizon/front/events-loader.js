import { displayEvents, displayErrorMessage } from './events-displayer'
import * as GraphqlWrapper from './graphql-wrapper'

const NAME = '<wordpress-name>'

document.addEventListener('DOMContentLoaded', () => {
  const eventLists = document.getElementsByClassName(NAME + '_events-list')
  for (let list of eventLists) {
    const url = list.getAttribute('data-url') + '/api'
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
})
