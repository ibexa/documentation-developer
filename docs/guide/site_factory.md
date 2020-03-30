# Site Factory

Site Factory is site management User Interface, integrated with Admin UI.
 It allows you to configure sites without editing:

- SiteAccess configuration
- multisite configuration

After [clean installation](../getting_started/install_ez_enterprise.md) the Site Factory will be disabled.
This results in the following message on the **Site** tab:
"There is a design configuration error, and you will not be able to create a new site. Please update the configuration."
If you plan to use Site Factory you need to enable and configure it.

To enable or disable Site Factory, follow respectively:

- [Enable Site Factory section](#enable-site-factory)
- [Disable Site Factory section](#disable-site-factory)

## Enable Site Factory

To enable Site Factory you need to set `enabled` to `true` in `vendor/ezsystems/ezplatform-site-factory/src/bundle/Resources/config/settings.yaml`.

### Configure designs

Next, configure Site Factory by adding empty SiteAccess groups in `config/packages/ezplatform.yaml`:

```yaml
ezplatform:
    siteaccess:
        list: [site, pl, de]
        groups:
            site_group: [site, pl, de]
            sf_group_1: []
            sf_group_2: []
            sf_group_3: []
            
    system:
        sf_group_1:
    
        sf_group_2:
    
        sf_group_3:
```

Uncomment the `'@EzSystems\EzPlatformSiteFactory\SiteAccessMatcher': ~` SiteAccess matcher in `ezplatform.siteaccess.match`.
 
Add `ezdesign` configuration and configure designs for empty SiteAccess groups:

```yaml
ezplatform:

...

ezdesign:
    design_list:
        example_1: [example_1_template]
        example_2: [example_2_template]
        
ezpublish:
    system:
        sf_group_1:
            design: example_1
        sf_group_2:
            design: example_2
        sf_group_3:
            design: example_3
```

`ezdesign` defines templates for your sites, so remember to add them before continuing.

### Add templates configuration

Add thumbnails and names for your templates in `config/packages/ez_platform_site_factory.yaml`
It will connect SiteAccesses with the templates.

```yaml
ezplatform_site_factory:
    templates:
        ez_site1:
            siteaccess_group: sf_group_1
            name: example_site_1
            thumbnail: /assets/ezplatform/build/images/example-1-icon.png
        ez_site2:
            siteaccess_group: sf_group_2
            name: example_site_2
            thumbnail: https://example.thumbnail.com
```

You can check the results of your work in the Back Office by going to the **Site** tab.
There, you should be able to add a new site and choose a design for it.

### Define domains 

To be able to see your site online you need to define a domain for it.

In `.env` file change line 2 to: `COMPOSE_FILE=doc/docker/base-dev.yml:doc/docker/multihost.yml`

Take a look into the `doc/docker/multihost.yml` file. 
Here you will define your domains. 
To add a new domain you must add it in `command:` and under frontend and backend aliases as shown in the example below.

```yaml hl_lines="3 6 11"
services:
  web:
    command: /bin/bash -c "cd /var/www && cp -a doc/nginx/ez_params.d /etc/nginx && bin/vhost.sh --host-name=site.example.com --host-alias='admin.example.com test.example.com' --template-file=doc/nginx/vhost.template > /etc/nginx/conf.d/default.conf && nginx -g 'daemon off;'"
    networks:
      frontend:
        aliases:
          - site.example.com
          - admin.example.com
          - test.example.com
      backend:
        aliases:
          - site.example.com
          - admin.example.com
          - test.example.com

```

Next, you must define the domains in `etc/hosts`.

```bash
0.0.0.0 site.example.com admin.example.com test.example.com www.admin.example.com
```

Then run `docker-compose up`: 

```bash
export COMPOSE_FILE="doc/docker/base-dev.yml:doc/docker/multihost.yml"
docker-compose up
```       

Your sites should be now visible under:

```
http://site.example.com:8080/
http://admin.example.com:8080/
http://localhost:8080/
http://test.example.com:8080/
```

![Site Factory site list](img/site_factory_site_list.png)

## Disable Site Factory

Enabled Site Factory may cause following performance issues:

- Config Resolver will look for SiteAccesses in the database
- Site Factory matchers will be connected to the database in search for new SiteAccesses

You can disable Site Factory to boost Config Resolver performance.
Keep in mind that with disabled Site Factory you will not be able to add new sites.

1. In `vendor/ezsystems/ezplatform-site-factory/src/bundle/Resources/config/settings.yaml` change enabled to `false`
1. In `config/packages/ezplatform.yaml` comment the `ezplatform.siteaccess.match: '@EzSystems\EzPlatformSiteFactory\SiteAccessMatcher': ~` if it is uncommented.
1. Remove separate connection to database in `config/packages/doctrine.yaml`.
1. Remove separate cache pool in `config/packages/cache.yaml`.

The Site Factory should be disabled.

![Site Factory disabled](img/site_factory_disabled.png)
