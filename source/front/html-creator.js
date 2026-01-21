export function createAnchorElement({ document, text, url }) {
  const a = document.createElement('a')
  a.setAttribute('href', url)
  a.setAttribute('target', '_blank')
  a.innerHTML = text
  return a
}

export function createContainerElement({ document, className }) {
  const div = document.createElement('div')
  div.className = className
  return div
}

export function createImageElement({ document, alt, src }) {
  const img = document.createElement('img')
  img.setAttribute('alt', alt)
  img.setAttribute('src', src)
  return img
}
