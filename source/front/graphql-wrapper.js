import SessionCache from './session-cache.js'
import { request } from 'graphql-request'
import DateTimeWrapper from './date-time-wrapper.js'

export function getUpcomingEvents({ url, limit }) {
  const query = `
    query ($limit: Int) {
      events(limit: $limit) {
        elements {
          id,
          title,
          url,
          beginsOn,
          endsOn,
          physicalAddress {
            description,
            locality
          }
        },
        total
      }
    }
  `
  const dataInCache = SessionCache.get(sessionStorage, {
    url,
    query,
    variables: { limit },
  })
  if (dataInCache !== null) {
    return Promise.resolve(dataInCache)
  }
  return request(url, query, { limit }).then((data) => {
    SessionCache.add(sessionStorage, { url, query, variables: { limit } }, data)
    return Promise.resolve(data)
  })
}

export function getUpcomingEventsByGroupName({ url, limit, groupName }) {
  const query = `
    query ($afterDatetime: DateTime, $groupName: String, $limit: Int) {
      group(preferredUsername: $groupName) {
        organizedEvents(afterDatetime: $afterDatetime, limit: $limit) {
          elements {
            id,
            title,
            url,
            beginsOn,
            endsOn,
            physicalAddress {
              description,
              locality
            }
          },
          total
        }
      }
    }
  `
  const afterDatetime = DateTimeWrapper.getCurrentDatetimeAsString()
  const dataInCache = SessionCache.get(sessionStorage, {
    url,
    query,
    variables: { afterDatetime, groupName, limit },
  })
  if (dataInCache !== null) {
    return Promise.resolve(dataInCache)
  }
  return request(url, query, { afterDatetime, groupName, limit }).then(
    (data) => {
      SessionCache.add(
        sessionStorage,
        { url, query, variables: { afterDatetime, groupName, limit } },
        data
      )
      return Promise.resolve(data)
    }
  )
}
