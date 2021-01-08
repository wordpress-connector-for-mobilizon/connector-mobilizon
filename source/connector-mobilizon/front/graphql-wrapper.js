import { request, gql } from 'graphql-request'

export function getEvents({ url, limit }) {  
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
