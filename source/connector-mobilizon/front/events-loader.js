import Formatter from './formatter'
import * as GraphqlWrapper from './graphql-wrapper'
import { createAnchorElement } from './html-creator'

const NAME = '<wordpress-name>'

function displayEvents(data, list) {
  const locale = list.getAttribute('data-locale')
  const maxEventsCount = list.getAttribute('data-maximum')
  const events = data.events ? data.events.elements : data.group.organizedEvents.elements
  const eventsCount = Math.min(maxEventsCount, events.length)
  for (let i = 0; i < eventsCount; i++) {
    const li = document.createElement('li')
    
    const a = createAnchorElement({ document, text: events[i].title, url: events[i].url })
    li.appendChild(a)

    const br = document.createElement('br')
    li.appendChild(br)

    const date = Formatter.formatDate({ locale, start: events[i].beginsOn, end: events[i].endsOn })
    const textnode = document.createTextNode(date)
    li.appendChild(textnode)

    if (events[i].physicalAddress) {
      const location = Formatter.formatLocation({
        description: events[i].physicalAddress.description,
        locality: events[i].physicalAddress.locality
      })
      if (location) {
        const brBeforeLocation = document.createElement('br')
        li.appendChild(brBeforeLocation)

        const textnodeLocation = document.createTextNode(location)
        li.appendChild(textnodeLocation)
      }
    }

    list.appendChild(li)
  }
}

function displayErrorMessage(data, list) {
  console.error(data)
  for (let i = 0; i < list.children.length; i++) {
    list.children[i].style.display = 'block'
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const eventLists = document.getElementsByClassName(NAME + '_events-list')
  for (let list of eventLists) {
    const url = list.getAttribute('data-url') + '/api'
    const limit = parseInt(list.getAttribute('data-maximum'))
    const groupName = list.getAttribute('data-group-name')
    if (groupName) {
      GraphqlWrapper.getUpcomingEventsByGroupName({ url, limit, groupName })
        .then((data) => displayEvents(data, list))
        .catch((data) => displayErrorMessage(data, list))
    } else {
      GraphqlWrapper.getUpcomingEvents({ url, limit })
        .then((data) => displayEvents(data, list))
        .catch((data) => displayErrorMessage(data, list))
    }
  }
})
