1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)

# Docker Tools 

Created by Dominika Kurek, last modified by André Rømcke on Jul 13, 2016

Beta

Instructions and Tools *(docker images, Dockerfile, .env file, docker-compose files, scripts, etc.)* described on this page are currently in Beta for community testing & contribution, and might change without notice.

 

> Docker allows you to package an application with all of its dependencies into a standardized unit for software development. – Docker.com

Using Docker images, we can package up all the executables, dependencies, and files required to run eZ Platform. We're in the process of preparing images for public use, and you can follow along on related epic tracking this  [![](https://jira.ez.no/images/icons/issuetypes/epic.png)EZP-25665](https://jira.ez.no/browse/EZP-25665?src=confmacro) - Docker-Tools / deployment M1 - beta Closed

*What is described on this page has gone through several iterations to try to become as simple as possible. It uses plain Docker and Docker Compose to avoid having to learn anything specific with these tools, and it uses official docker images to take advantage of continued innovation by Docker Inc. and the ecosystem. We will expand on these tools as both images, and Docker itself, matures. *

If you would like to join our efforts *(development, documentation, feedback, and/or testing)*, [sign up](http://ez-community-on-slack.herokuapp.com/) for our [Community Slack](http://ezcommunity.slack.com) and join the conversation in the **\#docker-tools** channel.

### Demo usage

Project use

For usage with your own project based on eZ Platform or eZ Enterprise starting with v1.4.0 you'll find documentation for project use in `doc/docker-compose/README.md`.

What follows below is instructions for setting up a simple single-server instance of eZ Platform demo using Docker. This is here shown on your own machine, however using [Docker Machine](https://docs.docker.com/machine/) you may point this to a variety of servers and services.

Note: For running Docker in production you'll need to handle a few more things we are not covering here yet, some of which are:

-   Handling persistence, both database and web/var files
-   Ideally also scale out to offer redundancy, and for that use memcached/redis and Varnish in front
-   Handle health of containers and configure setup if something goes down
-   ...

INTERNAL Work in progress, need to move entrypoint so it can be loaded.

First place the two files below in a empty folder:

**.env**

``` brush:
SYMFONY_ENV=prod
SYMFONY_DEBUG=0
DATABASE_USER=ezp
DATABASE_PASSWORD=SetYourOwnPassword
DATABASE_NAME=ezp
```

**docker-compose.yml**

``` brush:
version: '2'

services:
  app:
    image: ezsystems/ezplatform-demo:latest
    depends_on:
     - db
    environment:
     - SYMFONY_ENV
     - SYMFONY_DEBUG
     - DATABASE_USER
     - DATABASE_PASSWORD
     - DATABASE_NAME
     - DATABASE_HOST=db

  web:
    image: nginx:stable
    volumes_from:
     - app:ro
    ports:
     - "8080:80"
    environment:
     - SYMFONY_ENV
     - MAX_BODY_SIZE=20
     - FASTCGI_PASS=app:9000
     - TIMEOUT=190
     - DOCKER0NET
    command: /bin/bash -c "cd /var/www && cp -a doc/nginx/ez_params.d /etc/nginx && bin/vhost.sh --template-file=doc/nginx/vhost.template > /etc/nginx/conf.d/default.conf && nginx -g 'daemon off;'"

  db:
    image: mariadb:10.0
    #volumes:
    # - ./entrypoint/mysql:/docker-entrypoint-initdb.d/:ro
    environment:
     - MYSQL_RANDOM_ROOT_PASSWORD=1
     - MYSQL_USER=$DATABASE_USER
     - MYSQL_PASSWORD=$DATABASE_PASSWORD
     - MYSQL_DATABASE=$DATABASE_NAME
     - TERM=dumb
 
```

 

Then execute:

``` brush:
# If you have used same terminal for testing docker already, then first: unset COMPOSE_FILE SYMFONY_ENV SYMFONY_DEBUG
 
docker-compose up -d --force-recreate

docker-compose exec --user www-data app /bin/sh -c "php /scripts/wait_for_db.php; php app/console ezplatform:install demo"
```

App should now be up on localhost:8080

 
 

### Known issues

Incomplete list of known bugs:

|                                                                |                                                                                                                                   |
|----------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------|
| Key                                                            | Summary                                                                                                                           |
| [EZP-25869](https://jira.ez.no/browse/EZP-25869?src=confmacro) | [Docker containers has extremely slow IO on Mac/Windows under development use](https://jira.ez.no/browse/EZP-25869?src=confmacro) |
| [EZP-26286](https://jira.ez.no/browse/EZP-26286?src=confmacro) | [\[Insight\] YAML files should not contain syntax error](https://jira.ez.no/browse/EZP-26286?src=confmacro)                       |

 [2 issues](https://jira.ez.no/secure/IssueNavigator.jspa?reset=true&jqlQuery=component%3D%22Deployment+%3E+Docker+Containers%22+AND+issuetype%3DBug+AND+Resolution+is+Empty+ORDER+BY+priority+++&src=confmacro "View all matching issues in JIRA.")

 

#### Related:

-   Documentation:
    -   ~~[Installation Using Docker](Installation-Using-Docker_32113397.html)~~
-   Docker images:
    -   [ezsystems/php](https://hub.docker.com/r/ezsystems/php/)
    -   ezsystems/ezplatform-demo

 

![](attachments/32113421/32113469.png)






