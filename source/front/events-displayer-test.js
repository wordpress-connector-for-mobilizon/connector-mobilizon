import test from 'ava'
import { JSDOM } from 'jsdom'

import { displayEvents, displayErrorMessage } from './events-displayer.js'

let document

test.before(() => {
  const window = new JSDOM().window
  document = window.document
  window.SETTINGS = {
    locale: 'en-GB',
    timeZone: 'utc',
  }
})

test.beforeEach((t) => {
  t.context.container = document.createElement('div')

  const errorMessageGroupNotFound = document.createElement('div')
  errorMessageGroupNotFound.setAttribute('style', 'display: none;')
  t.context.container.appendChild(errorMessageGroupNotFound)
  const errorMessageGeneral = document.createElement('div')
  errorMessageGeneral.setAttribute('style', 'display: none;')
  t.context.container.appendChild(errorMessageGeneral)

  const list = document.createElement('ul')
  list.setAttribute('data-maximum', '2')
  const loadingMessage = document.createElement('li')
  list.appendChild(loadingMessage)
  t.context.container.appendChild(list)
})

// TODO
// eslint-disable-next-line ava/no-skip-test
test.skip('#displayEvents one event', (t) => {
  const container = t.context.container
  const data = {
    events: {
      elements: [
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
      ],
    },
  }
  displayEvents({ data, document, container })
  const list = container.children[2]
  t.is(list.children.length, 3)
  t.is(list.children[2].childNodes[0].tagName, 'A')
  t.is(list.children[2].childNodes[0].getAttribute('href'), 'b')
  t.is(list.children[2].childNodes[0].childNodes[0].nodeValue, 'a')
  t.is(list.children[2].childNodes[1].tagName, 'BR')
  t.is(list.children[2].childNodes[2].nodeValue, '15/04/2021 10:30 - 15:30')
  t.is(list.children[2].childNodes[3].tagName, 'BR')
  t.is(list.children[2].childNodes[4].nodeValue, 'c, d')
})

test('#displayErrorMessage no list entries shown', (t) => {
  const container = t.context.container
  const list = container.children[2]
  displayErrorMessage({ data: '', container })
  t.is(list.children.length, 0)
})

test('#displayErrorMessage error message display', (t) => {
  const container = t.context.container
  displayErrorMessage({ data: '', container })
  t.is(container.children[0].style.display, 'block')
  t.is(container.children[1].style.display, 'none')
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
  t.is(container.children[0].style.display, 'none')
  t.is(container.children[1].style.display, 'block')
})
