import { DateTime } from 'luxon';

export class DateTimeWrapper {

  constructor(text) {
    this.dateTime = DateTime.fromISO(text)
  }

  getShortDate() {
    return this.dateTime.toLocaleString(DateTime.DATE_SHORT)
  }

  get24Time() {
    return this.dateTime.toLocaleString(DateTime.TIME_24_SIMPLE)
  }

  equalsDate(other) {
    return this.dateTime &&
      other.dateTime &&
      this.dateTime.day === other.dateTime.day &&
      this.dateTime.month === other.dateTime.month &&
      this.dateTime.year === other.dateTime.year
  }
}
