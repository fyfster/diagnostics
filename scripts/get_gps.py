import gps

# Connect to the gpsd service
session = gps.gps(mode=gps.WATCH_ENABLE)

while True:
    try:
        report = session.next()
        #print(report)
        if report['class'] == 'TPV':  # Time-Position-Velocity report
            if hasattr(report, 'lat') and hasattr(report, 'lon'):
                print(f"Latitude: {report.lat}, Longitude: {report.lon}")
            if hasattr(report, 'mode') and report.mode == 1:
                print("No fix (searching for satellites)")
    except KeyError:
        pass
    except KeyboardInterrupt:
        print("User interrupted, exiting...")
        break
    except StopIteration:
        print("GPSD has stopped.")
        break