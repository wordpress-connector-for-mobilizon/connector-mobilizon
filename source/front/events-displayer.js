import Formatter from './formatter.js'
import { createAnchorElement, createImageElement } from './html-creator.js'

export function clearEventsList(container) {
  const list = container.querySelector('ul')
  list.replaceChildren()
}

export function displayEvents({ events, document, container, maxEventsCount }) {
  hideLoadingIndicator(container)

  const isShortOffsetNameShown =
    window.MOBILIZON_CONNECTOR.isShortOffsetNameShown || false // TODO remove
  const locale = window.MOBILIZON_CONNECTOR.locale
  const timeZone = window.MOBILIZON_CONNECTOR.timeZone

  const eventsCount = Math.min(maxEventsCount, events.length)
  const list = container.querySelector('ul')
  for (let i = 0; i < eventsCount; i++) {
    const li = document.createElement('li')
    li.style.lineHeight = '150%'
    li.style.marginTop = '20px'

    if (events[i].picture) {
      const img = createImageElement({
        document,
        alt: events[i].picture.alt ? events[i].picture.alt : '',
        src: events[i].picture.base64 ? events[i].picture.base64 : '',
      })
      img.style.display = 'block'
      img.style.maxWidth = '100%'
      li.appendChild(img)
    }

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
  if (Object.hasOwn(data, 'code') && data.code === 'group_not_found') {
    const message = container.querySelector('.group-not-found')
    message.style.display = 'block'
  } else {
    const message = container.querySelector('.general-error')
    message.style.display = 'block'
    console.error(data)
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

export function hideErrorMessages(container) {
  container.querySelector('.group-not-found').style.display = 'none'
  container.querySelector('.general-error').style.display = 'none'
}
