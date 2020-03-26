# Site Factory

Site Factory is site management User Interface, integrated to Admin UI, allowing you to configure files without editing:

- siteaccess configuration (replacing YML configuration)
- multisite configuration
- multisite management (creating sites, updating sites..

You can enable Site Factory after [clean installation](../getting_started/install_ez_enterprise.md). If you don't you will get an error message: "There is a design configuration error, and you will not be able to create a new site. Please update the configuration."

## Configure designs

First, add empty SA groups in `config/packages/ezplatform.yaml`:

```yaml
ezpublish:
    system:
        sf_group_1: []
        sf_group_2: []
        sf_group_3: []
```

Next, uncomment SA matcher `'@EzSystems\EzPlatformSiteFactory\SiteAccessMatcher': ~` in the same file and add `ezdesign` configuration:

```yaml
ezdesign:
    design_list:
        conference: [conference_template]
        roadshow: [roadshow_template]
```

Configure those designs for empty SA groups:

```yaml
ezpublish:
    system:
        sf_group_1:
            design: conference
        sf_group_2:
            design: roadshow
        sf_group_3:
            design: roadshow
```

## Add templates configuration

Finally, you need to add templates configuration in `vendor/ezsystems/ezplatform-site-factory/src/bundle/Resources/config/settings.yaml`:

```yaml
templates:
    ez_conference:
        siteaccess_group: sf_group_1
        name: Conference
        thumbnail: /assets/ezplatform/build/images/marker-icon.2273e3d8.png
    ez_conference2:
        siteaccess_group: sf_group_2
        name: RoadShow_1
        thumbnail: /assets/ezplatform/build/images/layers-2x.4f0283c6.png
    ez_conference3:
        siteaccess_group: sf_group_3
        name: RoadShow_2
        thumbnail: /assets/ezplatform/build/images/layers.a6137456.png
    ez_conference4:
        siteaccess_group: sf_group_3
        name: RoadShow_3
        thumbnail: /assets/ezplatform/build/images/layers.a6137456.png
```

Additionally, if you don't want to create templates in Site Factory package, you can create 
`config/packages/ez_platform_site_factory.yaml` and add them there.

w nim:
```yaml
ez_platform_site_factory:
    templates:
        ez_conference:
            siteaccess_group: sf_group_1
            name: Conference
            thumbnail: /assets/ezplatform/build/images/marker-icon.2273e3d8.png
        ez_conference2:
            siteaccess_group: sf_group_2
            name: RoadShow_1
            thumbnail: /assets/ezplatform/build/images/layers-2x.4f0283c6.png
```
        
## Wyłaczenie narzutu Site Factory - czym jest narzut SF

In `vendor/ezsystems/ezplatform-site-factory/src/bundle/Resources/config/services/site_factory.yaml`:

 - change `enabled: false` - nie ma
- if you used `ezplatform.siteaccess.match: '@EzSystems\EzPlatformSiteFactory\SiteAccessMatcher': ~` you need to remove it
- you need to have separate connection to database `config/packages/doctrine.yaml` - szczegoly
- you need to have separate cache poll `config/packages/cache.yaml` - szczegoly
- in `ezplatform.yaml` you need to add Site Factory matcher - in `ezplatform.siteaccess.siteaccess` add `'@EzSystems\EzPlatformSiteFactory\SiteAccessMatcher'` - przyklad kodu

Example of design configuration in`ezplatform.yaml`:

```yaml
ezdesign:
   design_list:
       conference: [conference_template]
       roadshow: [roadshow_template]
ezplatform:
   system:
       sf_group_1:
           design: conference
       sf_group_2:
           design: roadshow
       sf_group_3:
           design: roadshow
```

Next change template configuration in `settings.yaml`.
To to samo, co wyzej?

```yaml
templates:
   ez_conference:
       siteaccess_group: sf_group_1
       name: Conference
       thumbnail: /assets/ezplatform/build/images/marker-icon.2273e3d8.png
   ez_conference2:
       siteaccess_group: sf_group_2
       name: RoadShow_1
       thumbnail: /assets/ezplatform/build/images/layers-2x.4f0283c6.png
   ez_conference3:
       siteaccess_group: sf_group_3
       name: RoadShow_2
       thumbnail: /assets/ezplatform/build/images/layers.a6137456.png
```

### Define domains 

In `.env` file change line 2 to: `COMPOSE_FILE=doc/docker/base-dev.yml:doc/docker/multihost.yml`

Take a look into file `doc/docker/multihost.yml`. 
Here you can define your domains. 
To add a new domain you must add it in line 6 and under frontend and backend aliases - przyklad

Next you must edit your `etc/hosts` file gdzie? and add there this line:
`0.0.0.0 site.example.com admin.example.com test.example.com`.

Then you must run docker-compose up command in your terminal 

```bash
export COMPOSE_FILE="doc/docker/base-dev.yml:doc/docker/multihost.yml:doc/docker/selenium.yml"
docker-compose up
```       

Next, run following commands in the container:

```bash
composer ezplatform-install
export APP_ENV=behat
export APP_DEBUG=1
bin/ezbehat --mode=behat --profile=setup --suite=MapHost - uruchamia ten feature: https://github.com/ezsystems/BehatBundle/blob/master/features/setup/siteaccessMatcher/MapHost.feature
composer run post-install-cmd
w /etc/hosts:
0.0.0.0 site.example.com admin.example.com test.example.com www.admin.example.com
```

Sites should be visible under:

```bash
http://site.example.com:8080/
http://admin.example.com:8080/
http://localhost:8080/
http://test.example.com:8080/
```
