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
  t.context.list = document.createElement('ul')
  t.context.list.setAttribute('data-maximum', '2')
  const listElement = document.createElement('li')
  listElement.setAttribute('style', 'display: none;')
  t.context.list.appendChild(listElement)
  const listElement2 = document.createElement('li')
  listElement2.setAttribute('style', 'display: none;')
  t.context.list.appendChild(listElement2)
})

// TODO
// eslint-disable-next-line ava/no-skip-test
test.skip('#displayEvents one event', (t) => {
  const list = t.context.list
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
  displayEvents({ data, document, list })
  t.is(list.children.length, 3)
  t.is(list.children[2].childNodes[0].tagName, 'A')
  t.is(list.children[2].childNodes[0].getAttribute('href'), 'b')
  t.is(list.children[2].childNodes[0].childNodes[0].nodeValue, 'a')
  t.is(list.children[2].childNodes[1].tagName, 'BR')
  t.is(list.children[2].childNodes[2].nodeValue, '15/04/2021 10:30 - 15:30')
  t.is(list.children[2].childNodes[3].tagName, 'BR')
  t.is(list.children[2].childNodes[4].nodeValue, 'c, d')
})

test('#displayErrorMessage no children added', (t) => {
  const list = t.context.list
  displayErrorMessage({ data: '', list })
  t.is(list.children.length, 2)
})

test('#displayErrorMessage error message display', (t) => {
  const list = t.context.list
  displayErrorMessage({ data: '', list })
  t.is(list.children[0].style.display, 'block')
  t.is(list.children[1].style.display, 'none')
})

test('#displayErrorMessage group not found error message display', (t) => {
  const list = t.context.list
  const data = {
    response: {
      errors: [
        {
          code: 'group_not_found',
        },
      ],
    },
  }
  displayErrorMessage({ data, list })
  t.is(list.children[0].style.display, 'none')
  t.is(list.children[1].style.display, 'block')
})
