import { DateTimeWrapper } from './date-time-wrapper';
import * as GraphqlWrapper from './graphql-wrapper'
import * as HtmlCreator from './html-creator'

const NAME = '<wordpress-name>';

function displayEvents(data, lists) {
  for (let list of lists) {
    const maxEventsCount = list.getAttribute('data-maximum')
    const events = data.events.elements
    const eventsCount = Math.min(maxEventsCount, events.length)
    for (let i = 0; i < eventsCount; i++) {
      const li = document.createElement('li')
      
      const a = HtmlCreator.createAnchorElement({ text: events[i].title, url: events[i].url });
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
      const textnode = document.createTextNode(dateText);
      li.appendChild(textnode)

      list.appendChild(li)
    }
  }
}

function displayErrorMessage(data, lists) {
  console.error(data)
  for (let list of lists) {
    for (let i = 0; i < list.children.length; i++) {
      list.children[i].style.display = 'block'
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const eventLists = document.getElementsByClassName(NAME + '_events-list');
  if (eventLists.length) {
    // Currently, the URL is the same for all widgets, so just take the first one.
    const url = eventLists[0].getAttribute('data-url') + '/api';

    let maxEventsCount = 0
    for (let list of eventLists) {
      maxEventsCount = Math.max(maxEventsCount, list.getAttribute('data-maximum'))
    }

    GraphqlWrapper.getEvents({ url, limit: maxEventsCount })
      .then((data) => displayEvents(data, eventLists))
      .catch((data) => displayErrorMessage(data, eventLists))
  }
})
