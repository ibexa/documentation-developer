---
description: Site Factory allows creating multiple sites (SiteAccesses) from the Back Office.
edition: experience
---

# Site Factory

Site Factory is a site management interface, integrated with the Back Office.
It enables you to configure new sites without editing [YAML-based SiteAccess configuration](multisite_configuration.md).

!!! note

    A SiteAccess that you define for a site by following the [configuration](multisite_configuration.md) 
    is always treated with higher priority than a SiteAccess created by using the Site Factory. 
    For example, if you define a French site within a YAML file,
    and then create a site that uses the `fr` path in Site Factory, matchers ignore the second site.

Site Factory is disabled by default after installation.

If you plan to use Site Factory, you need to enable and configure it.
To enable or disable Site Factory, follow respectively:

- [Enable Site Factory section](#enable-site-factory)
- [Disable Site Factory section](#disable-site-factory)

## Enable Site Factory

To enable Site Factory, set `ibexa_site_factory.enabled` to `true` in `config/packages/ibexa_site_factory.yaml`.

### Configure designs

Next, configure Site Factory by adding empty SiteAccess groups. At least one empty group is required.
The number of empty SiteAccess groups must be equal to the number of templates that you want to have when you create the new site.

In this example, you add two SiteAccess groups (`example_site_factory_group_1` and `example_site_factory_group_2`)
that correspond to the two templates (`site1` and `site2`) that you add in the next step.

Add the groups in `config/packages/ibexa.yaml`:

``` yaml
ibexa:
    siteaccess:
        list: [site]
        groups:
            site_group: [site]
            example_site_factory_group_1: []
            example_site_factory_group_2: []

    system:
        example_site_factory_group_1:
        example_site_factory_group_2:
```

Uncomment the SiteAccess matcher (`Ibexa\SiteFactory\SiteAccessMatcher`):

``` yaml
ibexa:
    siteaccess:
        match:
        '@Ibexa\SiteFactory\SiteAccessMatcher': ~
```

`ibexadesign` defines templates for your sites, so add them before continuing.
Next, add the configuration for `ibexadesign` on the same level as `ibexa`:

``` yaml
ibexa_design_engine:
    design_list:
        example_1: [example_1_template]
        example_2: [example_2_template]
```

Finally, configure designs for empty SiteAccess groups:

``` yaml
ibexa:
    system:
        example_site_factory_group_1:
            design: example_1
        example_site_factory_group_2:
            design: example_2
```

### Add site template configuration

Add thumbnails and names for your site templates in `config/packages/ibexa_site_factory.yaml`:

```yaml
ibexa_site_factory:
    templates:
        site1:
            siteaccess_group: example_site_factory_group_1
            name: example_site_1
            thumbnail: /path/to/image/example-thumbnail_1.png
        site2:
            siteaccess_group: example_site_factory_group_2
            name: example_site_2
            thumbnail: /path/to/image/example-thumbnail_2.png
```

You can check the results of your work in the Back Office by going to the **Site** tab and selecting the **List** icon.

There, you should be able to add a new site and choose a design for it.

### Define domains

To be able to see your site online, you need to define a domain for it.

!!! caution "Define domain for production environment"

    These steps are for `dev` environment only.
    If you want to define domains in production environment, you will need to configure Apache or Nginx by yourself.

In the `.env` file change line 2 to: `COMPOSE_FILE=doc/docker/base-dev.yml:doc/docker/multihost.yml`

Take a look into the `doc/docker/multihost.yml` file. Here you can define domains.
To add a new domain, add it in `command:` and under frontend and backend aliases as shown in the example below:

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

Next, you must define the domains in `etc/hosts`:

`0.0.0.0 site.example.com admin.example.com test.example.com www.admin.example.com`

Then, run `docker-compose up`:

```bash
export COMPOSE_FILE="doc/docker/base-dev.yml:doc/docker/multihost.yml"
docker-compose up
```       

Your sites should be now visible under:

- `http://site.example.com:8080/`
- `http://admin.example.com:8080/`
- `http://localhost:8080/`
- `http://test.example.com:8080/`

![Site Factory enabled](site_factory_site_list.png "Site Factory enabled")

### Define site directory

You can adjust the place where the directory of the new site is created (Location with ID 2 by default).
To do it, go to `config/packages/ibexa_site_factory.yaml`, and add the following parameter:

``` yaml
ibexa:
    system:
        default:
            site_factory:
                sites_location_id: 42
```

Now, all new directories are created under "Ibexa DXP".

### Provide access

The Site Factory is set up, now you can provide sufficient permissions to the Users.

Set the below Policies to allow Users to:

- `site/view` - enter the Site Factory interface
- `site/create` - create sites
- `site/edit` - edit sites
- `site/change_status` - change status of the public accesses to `Live` or `Offline`
- `site/delete` - delete sites

For full documentation on how Permissions work and how to set them up, see [the Permissions section](permissions.md).

To learn how to use Site Factory, see [User documentation.]([[= user_doc =]]/site_organization/site_factory/)

## Disable Site Factory

Enabled Site Factory may cause following performance issues:

- [ConfigResolver](dynamic_configuration.md#configresolver) looks for SiteAccesses in the database
- Site Factory matchers are connected to the database in search for new SiteAccesses

You can disable Site Factory to boost ConfigResolver performance.
Keep in mind that with disabled Site Factory you are unable to add new sites or use existing ones.

1\. In `config/packages/ibexa_site_factory.yaml` change `enabled` to `false`.

2\. In `config/packages/ibexa.yaml` comment the `ibexa.siteaccess.match: '@Ibexa\SiteFactory\SiteAccessMatcher': ~` if it is uncommented.

3\. Remove separate connection to database in `config/packages/doctrine.yaml`.

``` yaml
doctrine:
    dbal:
        connections:
            ...
            # This connection is dedicated for SiteFactory to avoid known issues
            site_factory:
```

4\. Remove separate cache pool in `config/packages/cache.yaml`.

``` yaml
framework:
    cache:
        ...
        pools:
            # This pool should be used only by SiteFactory bundle
            site_factory_pool:
```

The Site Factory should be disabled.
