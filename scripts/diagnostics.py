import obd
import logging
import requests
import time
import subprocess
import sys

# Configure logging
logging.basicConfig(filename='/var/log/diagnostics.log', level=logging.DEBUG)

# Define the correct port and baudrate
connection = obd.OBD("/dev/rfcomm0", baudrate=38400, fast=False)

url = "https://widefrontpack.ro/api/add-diagnostics"
headers = {
  'token': 'maresecrtetacesttoken'
}
files = []

def send_diagnostics():
    while True:
        try:
            # Get VIN
            vin_cmd = obd.commands.VIN
            vin_response = connection.query(vin_cmd)
            vin_string = vin_response.value.decode('utf-8')

            print(vin_string)
            # Get vehicle rpm
            rpm_cmd = obd.commands.RPM
            rpm_response = connection.query(rpm_cmd)
            rpm = int(rpm_response.value.magnitude)

            # Get vehicle speed in km/h
            speed_cmd = obd.commands.SPEED
            speed_response = connection.query(speed_cmd)
            speed = int(speed_response.value.to("km/h").magnitude)

            # Get fuel level
            fuel_level_cmd = obd.commands.FUEL_LEVEL
            fuel_level_response = connection.query(fuel_level_cmd)
            fuel_level = int(float(fuel_level_response.value.magnitude))

            # Get coolant temperature in Celsius
            coolant_temp_cmd = obd.commands.COOLANT_TEMP
            coolant_temp_response = connection.query(coolant_temp_cmd)
            coolant_temp = str(coolant_temp_response.value.magnitude)

            # Prepare the payload
            payload = {
                'vin': vin_string,
                'fuel_percentage': fuel_level,
                'speed': speed,
                'rpm': rpm,
                'coolant_temperature': coolant_temp
            }

            # Send the request
            response = requests.request("POST", url, headers=headers, data=payload, files=files)
            print(response.text)

            # Sleep for 1 second
            time.sleep(1)
        except Exception as e:
            logging.error(f"An error occurred: {e}")
            subprocess.Popen(["sudo", "/home/fyf/scripts/reset_rfcomm.sh"])
            subprocess.Popen(["sudo", "/home/fyf/scripts/check_rfcomm.sh"])
            time.sleep(10)
            subprocess.Popen(["sudo", "python3", "/home/fyf/scripts/diagnostics.py"])
            sys.exit(1)

send_diagnostics()