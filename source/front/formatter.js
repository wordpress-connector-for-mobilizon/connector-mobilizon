export default class Formatter {
  static escapeHTML(input) {
    const div = document.createElement('div')
    div.appendChild(document.createTextNode(input))
    return div.innerHTML
  }

  static formatDate({
    startDateFormatted,
    startTimeFormatted,
    endDateFormatted,
    endTimeFormatted,
  }) {
    let dateText = startDateFormatted
    dateText += ' ' + startTimeFormatted
    if (endDateFormatted) {
      if (startDateFormatted !== endDateFormatted) {
        dateText += ' - '
        dateText += endDateFormatted + ' '
      } else {
        dateText += ' - '
      }
      dateText += endTimeFormatted
    }
    return dateText
  }

  static formatLocation({ description, locality }) {
    let location = ''
    if (description && description.trim()) {
      location += description.trim()
    }
    if (location && locality) {
      location += ', '
    }
    if (locality) {
      location += locality
    }
    return location
  }
}
