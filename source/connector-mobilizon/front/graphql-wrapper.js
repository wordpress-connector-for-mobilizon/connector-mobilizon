import { request, gql } from 'graphql-request'
import { DateTimeWrapper } from './date-time-wrapper'

export function getUpcomingEvents({ url, limit }) {
  const query = gql`
  query {
    events(limit:${limit}) {
      elements {
        id,
        title,
        url,
        beginsOn,
        endsOn
      },
      total
    }
  }
  `
  return request(url, query)
}

export function getUpcomingEventsByGroupName({ url, limit, groupName }) {
  const afterDatetime = DateTimeWrapper.getCurrentDatetimeAsString();
  const query = gql`
  query {
    group(preferredUsername:"${groupName}") {
      organizedEvents(afterDatetime:"${afterDatetime}", limit:${limit}) {
        elements {
          id,
          title,
          url,
          beginsOn,
          endsOn
        },
        total
      }
    }
  }
  `
  return request(url, query)
}
