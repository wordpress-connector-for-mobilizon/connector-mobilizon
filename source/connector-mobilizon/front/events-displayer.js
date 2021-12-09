import Formatter from './formatter'
import { createAnchorElement } from './html-creator'

export function displayEvents({ data, document, list }) {
  const locale = list.getAttribute('data-locale')
  const maxEventsCount = list.getAttribute('data-maximum')
  const timeZone = list.getAttribute('data-time-zone')
  const isShortOffsetNameShown = list.hasAttribute(
    'data-is-short-offset-name-shown'
  )
  const events = data.events
    ? data.events.elements
    : data.group.organizedEvents.elements
  const eventsCount = Math.min(maxEventsCount, events.length)
  for (let i = 0; i < eventsCount; i++) {
    const li = document.createElement('li')

    const a = createAnchorElement({
      document,
      text: events[i].title,
      url: events[i].url,
    })
    li.appendChild(a)

    const br = document.createElement('br')
    li.appendChild(br)

    const date = Formatter.formatDate({
      locale,
      start: events[i].beginsOn,
      end: events[i].endsOn,
      timeZone,
      isShortOffsetNameShown,
    })
    const textnode = document.createTextNode(date)
    li.appendChild(textnode)

    if (events[i].physicalAddress) {
      const location = Formatter.formatLocation({
        description: events[i].physicalAddress.description,
        locality: events[i].physicalAddress.locality,
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

export function displayErrorMessage({ data, list }) {
  console.error(data)
  if (
    Object.prototype.hasOwnProperty.call(data, 'response') &&
    Object.prototype.hasOwnProperty.call(data.response, 'errors') &&
    data.response.errors.length > 0 &&
    Object.prototype.hasOwnProperty.call(data.response.errors[0], 'code') &&
    data.response.errors[0].code === 'group_not_found'
  ) {
    list.children[1].style.display = 'block'
  } else {
    list.children[0].style.display = 'block'
  }
}
