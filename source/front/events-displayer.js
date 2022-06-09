import Formatter from './formatter.js'
import { createAnchorElement } from './html-creator.js'

export function clearEventsList(container) {
  const list = container.querySelector('ul')
  list.replaceChildren()
}

export function displayEvents({ data, document, container }) {
  hideLoadingIndicator(container)

  const isShortOffsetNameShown =
    window.MOBILIZON_CONNECTOR.isShortOffsetNameShown
  const locale = window.MOBILIZON_CONNECTOR.locale
  const maxEventsCount = container.getAttribute('data-maximum')
  const timeZone = window.MOBILIZON_CONNECTOR.timeZone

  const events = data.events
    ? data.events.elements
    : data.group.organizedEvents.elements
  const eventsCount = Math.min(maxEventsCount, events.length)
  const list = container.querySelector('ul')
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

export function displayErrorMessage({ data, container }) {
  hideLoadingIndicator(container)
  console.error(data)
  if (
    Object.prototype.hasOwnProperty.call(data, 'response') &&
    Object.prototype.hasOwnProperty.call(data.response, 'errors') &&
    data.response.errors.length > 0 &&
    Object.prototype.hasOwnProperty.call(data.response.errors[0], 'code') &&
    data.response.errors[0].code === 'group_not_found'
  ) {
    const message = container.querySelector('.group-not-found')
    message.style.display = 'block'
  } else {
    const message = container.querySelector('.general-error')
    message.style.display = 'block'
  }
}

export function showLoadingIndicator(container) {
  const indicator = container.querySelector('.loading-indicator')
  indicator.style.display = 'block'
}

function hideLoadingIndicator(container) {
  const indicator = container.querySelector('.loading-indicator')
  indicator.style.display = 'none'
}
