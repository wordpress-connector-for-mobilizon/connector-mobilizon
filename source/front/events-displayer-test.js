import test from 'ava'
import browserEnv from 'browser-env'

import {
  displayEvents,
  displayErrorMessage,
  hideErrorMessages,
  showLoadingIndicator,
} from './events-displayer.js'

test.before(() => {
  browserEnv()
  window.MOBILIZON_CONNECTOR = {
    locale: 'en-GB',
    timeZone: 'utc',
  }
})

test.beforeEach((t) => {
  t.context.container = document.createElement('div')

  const errorMessageGeneral = document.createElement('div')
  errorMessageGeneral.setAttribute('class', 'general-error')
  errorMessageGeneral.setAttribute('style', 'display: none;')
  t.context.container.appendChild(errorMessageGeneral)

  const errorMessageGroupNotFound = document.createElement('div')
  errorMessageGroupNotFound.setAttribute('class', 'group-not-found')
  errorMessageGroupNotFound.setAttribute('style', 'display: none;')
  t.context.container.appendChild(errorMessageGroupNotFound)

  const loadingIndicator = document.createElement('div')
  loadingIndicator.setAttribute('class', 'loading-indicator')
  loadingIndicator.setAttribute('style', 'display: none;')
  t.context.container.appendChild(loadingIndicator)

  const list = document.createElement('ul')
  t.context.container.appendChild(list)
})

test('#displayEvents one event', (t) => {
  const events = [
    {
      title: 'a',
      url: 'b',
      beginsOn: '2021-04-15T10:30:00Z',
      endsOn: '2021-04-15T15:30:00Z',
      physicalAddress: {
        description: 'c',
        locality: 'd',
      },
    },
  ]
  const container = t.context.container
  displayEvents({ events, document, container, maxEventsCount: 2 })
  const list = container.querySelector('ul')
  t.is(list.children[0].childNodes[0].tagName, 'A')
  t.is(list.children[0].childNodes[0].getAttribute('href'), 'b')
  t.is(list.children[0].childNodes[0].childNodes[0].nodeValue, 'a')
  t.is(list.children[0].childNodes[1].tagName, 'BR')
  t.is(list.children[0].childNodes[2].nodeValue, '15/04/2021 10:30 - 15:30')
  t.is(list.children[0].childNodes[3].tagName, 'BR')
  t.is(list.children[0].childNodes[4].nodeValue, 'c, d')
})

test('#displayErrorMessage no list entries shown', (t) => {
  const container = t.context.container
  displayErrorMessage({ data: '', container })
  const list = container.querySelector('ul')
  t.is(list.children.length, 0)
})

test('#displayErrorMessage general error message display', (t) => {
  const container = t.context.container
  displayErrorMessage({ data: '', container })
  t.is(container.querySelector('.general-error').style.display, 'block')
  t.is(container.querySelector('.group-not-found').style.display, 'none')
  t.is(container.querySelector('.loading-indicator').style.display, 'none')
})

test('#displayErrorMessage group not found error message display', (t) => {
  const container = t.context.container
  const data = {
    response: {
      errors: [
        {
          code: 'group_not_found',
        },
      ],
    },
  }
  displayErrorMessage({ data, container })
  t.is(container.querySelector('.general-error').style.display, 'none')
  t.is(container.querySelector('.group-not-found').style.display, 'block')
  t.is(container.querySelector('.loading-indicator').style.display, 'none')
})

test('#showLoadingIndicator remove events', (t) => {
  const container = t.context.container
  const loadingIndicator = container.querySelector('.loading-indicator')
  t.is(loadingIndicator.style.display, 'none')
  showLoadingIndicator(container)
  t.is(loadingIndicator.style.display, 'block')
})

test('#hideErrorMessages remove events', (t) => {
  const container = t.context.container
  const generalErrorMessage = container.querySelector('.general-error')
  const groupNotFoundErrorMessage = container.querySelector('.group-not-found')
  generalErrorMessage.style.display = 'block'
  groupNotFoundErrorMessage.style.display = 'block'
  t.is(generalErrorMessage.style.display, 'block')
  t.is(groupNotFoundErrorMessage.style.display, 'block')
  hideErrorMessages(container)
  t.is(generalErrorMessage.style.display, 'none')
  t.is(groupNotFoundErrorMessage.style.display, 'none')
})
