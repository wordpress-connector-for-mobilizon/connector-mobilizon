import { DateTimeWrapper } from './date-time-wrapper'
import * as GraphqlWrapper from './graphql-wrapper'
import * as HtmlCreator from './html-creator'

const NAME = '<wordpress-name>'

function displayEvents(data, list) {
  const maxEventsCount = list.getAttribute('data-maximum')
  const events = data.events ? data.events.elements : data.group.organizedEvents.elements
  const eventsCount = Math.min(maxEventsCount, events.length)
  for (let i = 0; i < eventsCount; i++) {
    const li = document.createElement('li')
    
    const a = HtmlCreator.createAnchorElement({ text: events[i].title, url: events[i].url })
    li.appendChild(a)

    const br = document.createElement('br')
    li.appendChild(br)

    const beginsOn = new DateTimeWrapper(events[i].beginsOn)
    const endsOn = new DateTimeWrapper(events[i].endsOn)
    let dateText = beginsOn.getShortDate()
    dateText += ' ' + beginsOn.get24Time()
    dateText += ' - '
    if (!beginsOn.equalsDate(endsOn)) {
      dateText += endsOn.getShortDate() + ' '
    }
    dateText += endsOn.get24Time()
    const textnode = document.createTextNode(dateText)
    li.appendChild(textnode)

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
