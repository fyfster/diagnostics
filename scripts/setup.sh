ssh fyf@fyf.local 'mkdir -p ~/scripts'

scp cron.py fyf@fyf.local:~/scripts/

scp diagnostics.py fyf@fyf.local:~/scripts/

scp setup_raspberry.sh fyf@fyf.local:~/scripts/

scp check_rfcomm.sh fyf@fyf.local:~/scripts/

scp reset_rfcomm.sh fyf@fyf.local:~/scripts/

scp run_diagnostics.sh fyf@fyf.local:~/scripts/

scp sakis3g fyf@fyf.local:~/scripts/

ssh fyf@fyf.local 'sudo /home/fyf/scripts/setup_raspberry.sh'

ssh fyf@fyf.local 'sudo python3 ~/scripts/cron.py'
