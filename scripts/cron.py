import os
from crontab import CronTab

def create_cron_job():
    os.system('chmod +x /home/fyf/scripts/run_diagnostics.sh')
    os.system('chmod +x /home/fyf/scripts/check_rfcomm.sh')
    
    os.system('touch /var/log/crontab.log')
    os.system('sudo chown fyf:fyf /var/log/crontab.log')
    os.system('chmod 664 /var/log/crontab.log')

    os.system('touch /var/log/rfcomm_check.log')
    os.system('sudo chown fyf:fyf /var/log/rfcomm_check.log')
    os.system('chmod 664 /var/log/rfcomm_check.log')

    cron = CronTab(user='fyf')

    job1 = cron.new(command='sudo /bin/bash /home/fyf/scripts/run_diagnostics.sh > /var/log/crontab.log 2>&1')
    job1.minute.every('@reboot')

    job2 = cron.new(command='sudo /bin/bash /home/fyf/scripts/check_rfcomm.sh')
    job2.minute.every(1)

    cron.write()


create_cron_job()