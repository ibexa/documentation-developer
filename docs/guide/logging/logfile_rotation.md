---
description: Configure rotation of log files to minimize disk space usage.
---

# Logfile rotation

You can set up automatic rotation of logfiles to avoid overfilling the disk space.

The `logrotate` utility is a standard tool in Linux systems. It is run by `cron.daily` once a day at 6:25 am (on Ubuntu systems).

To configure logfile rotation for shop logs, create a new configuration file in `/etc/logrotate.d/silver-eshop`:

```
<your-project>/var/log/prod.log <your-project>/var/log/silver.eshop.log <your-project>/var/log/prod-siso.eshop.erp.log {
    su www-data www-data
    daily
    size 50M
    rotate 30
    missingok
    create 674 devel devel
    compress
}
```

If the logfiles grow very quickly, you can run `logrotate` once per hour by putting it in `cron.hourly` (it will run at 17 minutes past every hour):

``` bash
mv /etc/cron.daily/logrotate /etc/cron.hourly
```
