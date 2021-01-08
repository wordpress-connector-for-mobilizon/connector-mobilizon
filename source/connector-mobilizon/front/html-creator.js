export function createAnchorElement({ text, url }) {
  const a = document.createElement('a')
  a.setAttribute('href', url)
  a.setAttribute('target', '_blank')
  a.innerHTML = text
  return a
}
