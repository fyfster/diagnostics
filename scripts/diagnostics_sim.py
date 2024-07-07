import requests
import random
import time

# url = "https://widefrontpack.ro/api/add-diagnostics"
url = "http://localhost/diagnostics/api/add-diagnostics"

while True:
  payload = {
      'vin': 'JMZKEN92600235146',
      'fuel_percentage': str(random.randint(10, 100)),
      'speed': str(random.randint(0, 150)),
      'rpm': str(random.choice(range(100, 4001, 100))),
      'coolant_temperature': str(random.randint(-20, 70))
  }
  files = []
  headers = {
    'token': 'maresecrtetacesttoken'
  }

  response = requests.request("POST", url, headers=headers, data=payload, files=files)

  print(response.text)
  time.sleep(3)