export function formatUTCToTimeZone(
  utcDate: string,
  timeZone: string = 'Asia/Kolkata',
  locale: string = 'en-US'
): string {
  const formatter = new Intl.DateTimeFormat(locale, {
    timeZone,
    year: 'numeric',
    month: 'short',
    day: '2-digit',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
  });

  return formatter.format(new Date(utcDate));
}