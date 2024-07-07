import obd
import logging
import requests
import time
import subprocess
import sys

ODOMETER_PID = bytes.fromhex("01A6") 

def odometer_decoder(messages):
    msg = messages[0]
    if not msg.data:
        return None
    data_hex = msg.data.hex()
    odometer_km = int(data_hex, 16)
    return odometer_km

# Configure logging
filename = f'/var/log/diagnostics.log'
logging.basicConfig(filename=filename, level=logging.DEBUG,
                    format='%(asctime)s %(message)s', datefmt='%m/%d/%Y %I:%M:%S %p')

# Create a custom OBD command
odometer_command = obd.OBDCommand(
    name="ODOMETER",       # Name of the command
    desc="Odometer Reading",  # Description
    command=ODOMETER_PID,       # Custom PID
    _bytes=2,
    decoder=odometer_decoder, # Decoder function
    fast=False                # Whether the command should be sent as fast as possible
)

# Define the correct port and baudrate
connection = obd.OBD("/dev/rfcomm0", baudrate=38400, fast=False)

# Add the custom command to the connection
connection.supported_commands.add(odometer_command)

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

            # Get engine load
            engine_load_cmd = obd.commands.ENGINE_LOAD
            engine_load_response = connection.query(engine_load_cmd)
            engine_load = str(engine_load_response.value.magnitude)

            # Get engine fuel rate
            fuel_rate_cmd = obd.commands.FUEL_RATE
            fuel_rate_response = connection.query(fuel_rate_cmd)
            fuel_rate = str(fuel_rate_response.value.magnitude)

            # Get DTCs errors
            dtc_cmd = obd.commands.GET_DTC
            dtc_response = connection.query(dtc_cmd)
            dtc = dtc_response.value

            # Get EGR error
            egr_cmd = obd.commands.EGR_ERROR
            egr_response = connection.query(egr_cmd)
            egr = egr_response.value


            # Get odometer value (total km of car)
            odometer_response = connection.query(odometer_command)

            # Prepare the payload
            payload = {
                'vin': vin_string,
                'fuel_percentage': fuel_level,
                'speed': speed,
                'rpm': rpm,
                'coolant_temperature': coolant_temp,
                'engine_load': engine_load,
                'fuel_rate': fuel_rate,
                'dtc': dtc,
                'egr': egr,
                'odometer': odometer_response.value
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