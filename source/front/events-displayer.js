import Formatter from './formatter.js'
import {
  createAnchorElement,
  createContainerElement,
  createImageElement,
} from './html-creator.js'

export function clearEventsList(container) {
  const list = container.querySelector('ul')
  list.replaceChildren()
}

export function displayEvents({
  blockClassName,
  events,
  document,
  container,
  maxEventsCount,
}) {
  hideLoadingIndicator(container)

  const eventsCount = Math.min(maxEventsCount, events.length)
  const list = container.querySelector('ul')
  list.className = blockClassName + '__list'
  for (let i = 0; i < eventsCount; i++) {
    const li = document.createElement('li')
    li.className = blockClassName + '__event'
    li.style.lineHeight = '150%'
    li.style.marginTop = '20px'

    if (events[i].picture) {
      const pictureContainer = createContainerElement({
        document,
        className: blockClassName + '__picture',
      })
      const picture = createImageElement({
        document,
        alt: events[i].picture.alt ? events[i].picture.alt : '',
        src: events[i].picture.base64 ? events[i].picture.base64 : '',
      })
      pictureContainer.appendChild(picture)
      li.appendChild(pictureContainer)
    }

    const titleContainer = createContainerElement({
      document,
      className: blockClassName + '__title',
    })
    const title = createAnchorElement({
      document,
      text: events[i].title,
      url: events[i].url,
    })
    titleContainer.appendChild(title)
    li.appendChild(titleContainer)

    const dateContainer = createContainerElement({
      document,
      className: blockClassName + '__date',
    })
    const date = Formatter.formatDate({
      startDateFormatted: events[i].startDateFormatted,
      startTimeFormatted: events[i].startTimeFormatted,
      endDateFormatted: events[i].endDateFormatted,
      endTimeFormatted: events[i].endTimeFormatted,
    })
    const dateTextNode = document.createTextNode(date)
    dateContainer.appendChild(dateTextNode)
    li.appendChild(dateContainer)

    if (events[i].physicalAddress) {
      const location = Formatter.formatLocation({
        description: events[i].physicalAddress.description,
        locality: events[i].physicalAddress.locality,
      })
      if (location) {
        const locationContainer = createContainerElement({
          document,
          className: blockClassName + '__location',
        })
        const locationTextNode = document.createTextNode(location)
        locationContainer.appendChild(locationTextNode)
        li.appendChild(locationContainer)
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
