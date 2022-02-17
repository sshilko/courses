# Date & time adder
# @see https://docs.python.org/3/library/datetime.html#strftime-strptime-behavior
#
# When used with the strptime() method, the %p directive only affects the output hour field if the %I directive is # used to parse the hour.

import datetime

def add_time(start:str, duration:str, dayofweek:str = "") -> str:
  
  if len(dayofweek) > 0:
    for i in range(7):
      start_day = datetime.datetime.strptime(start, '%I:%M %p') + datetime.timedelta(days=i)
      if (str(start_day.strftime('%A')).lower() == dayofweek.lower()):
        break;
  else:
    start_day = datetime.datetime.strptime(start, '%I:%M %p')

  datetime_duration = duration.split(':')
  datetime_delta    = datetime.timedelta(hours=int(datetime_duration[0]), minutes=int(datetime_duration[1]))

  end_day = start_day + datetime_delta

  response = end_day.strftime('%I:%M %p').lstrip('0')

  #NOT 24h difference, but just DAY difference
  fulldays_diff = (end_day.date() - start_day.date()).days
  if len(dayofweek) > 0:
    response += end_day.strftime(', %A')

  if start_day.day + 1 == end_day.day:
    response += " (next day)"
  elif fulldays_diff > 1:
    response += " (" + str(fulldays_diff) + " days later)"

  return response