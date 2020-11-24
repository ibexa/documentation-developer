# Required crontab tasks [[% include 'snippets/commerce_badge.md' %]]

## Remove the translation and navigation caches

The shop collects changes regarding translations (textmodules) and navigation.
If there are changes (e.g. performed in the backend) the cache will be refreshed.   

``` 
# Checks for changes and refresh cache
*/5 * * * * cd '/var/www/my_project' && /usr/bin/php bin/console silversolutions:cache:refresh --env=prod
```

## Send lost orders to the ERP

Lost orders can be re-sent using a command-line tool. We recommend running this tool e.g. every 5 minutes.

``` 
# resends lost orders every 5 minutes
*/5 * * * * cd '/var/www/my_project' && /usr/bin/php bin/console silversolutions:lostorder:process --env=prod
```

## Use job-queue-system

See [JMSJobQueueBundle documentation](http://jmsyst.com/bundles/JMSJobQueueBundle/master/installation)
for more information

If you can't use the suggested `supervisord` configuration, you can [set up a cron job.](https://github.com/schmittjoh/JMSJobQueueBundle/issues/205)

## Calculate statistical data for active sessions

The dashboard uses statistical data about sessions recorded in a database table.
This command line will refresh the data every 5 minutes. 

!!! note

    This feature is available only if sessions are handled in the database.

``` 
*/5 * * * * cd /var/www/my_project &&  /usr/bin/php bin/console silversolutions:sessions write_stat --env=prod
```
