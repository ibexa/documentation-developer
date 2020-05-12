# Site Factory

!!! enterprise

    Site Factory is a site management User Interface, integrated with Admin UI.
    It enables you to configure sites without editing:
    
    - SiteAccess configuration
    - multisite configuration
    
    After [clean installation](../getting_started/install_ez_enterprise.md) the Site Factory will be disabled.
    If you are not working on a clean installation, follow [Upgrading eZ Platform to v3](../updating/upgrading_to_v3.md#site-factory).
    This results in the following message on the **Site** tab:
    "There is a design configuration error, and you will not be able to create a new site. Please update the configuration."
    If you plan to use Site Factory you need to enable and configure it.
    
    To enable or disable Site Factory, follow respectively:
    
    - [Enable Site Factory section](#enable-site-factory)
    - [Disable Site Factory section](#disable-site-factory)
    
    ## Enable Site Factory
    
    To enable Site Factory you need to set `enabled` to `true` in `config/packages/ezplatform_site_factory.yaml`.
    
    ### Configure designs
    
    Next, configure Site Factory by adding empty SiteAccess groups, only one empty group is mandatory.
    The number of empty SiteAccess groups must be equal to a number of templates that you want to have when you create the new site.
    
    In this example, you add two SiteAccess groups (`example_site_factory_group_1` and `example_site_factory_group_2`) that correspond to the two templates (`ez_site1` and `ez_site2`) that you will add in the next step.
    Under these groups you configure all the settings that do not expose the UI, e.g. the Content view.
    
    Add groups in `config/packages/ezplatform.yaml`:
    
    ```yaml
    ezplatform:
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
    
    Uncomment the SiteAccess matcher by removing the comment from `EzSystems\EzPlatformSiteFactory\SiteAccessMatcher` matcher under:
    
    ```yaml
    ezplatform:
        siteaccess:
            match:
                # '@EzSystems\EzPlatformSiteFactory\SiteAccessMatcher': ~
    ```
     
    `ezdesign` defines templates for your sites, so add them before continuing.
    Next, add the configuration for `ezdesign` on the same level as `ezplatform`:
    
    ```yaml
    ezdesign:
        design_list:
            example_1: [example_1_template]
            example_2: [example_2_template]
    ```

    Finally, configure designs for empty SiteAccess groups:
    
    ```
    ezplatform:
        system:
            example_site_factory_group_1:
                design: example_1
            example_site_factory_group_2:
                design: example_2
    ```
    
    ### Add templates configuration
    
    Add thumbnails and names for your templates in `config/packages/ezplatform_site_factory.yaml`
    It will connect SiteAccesses with the templates.
    
    ```yaml
    ez_platform_site_factory:
        templates:
            ez_site1:
                siteaccess_group: example_site_factory_group_1
                name: example_site_1
                thumbnail: /path/to/image/example-thumbnail_1.png
            ez_site2:
                siteaccess_group: example_site_factory_group_2
                name: example_site_2
                thumbnail: /path/to/image/example-thumbnail_2.png
    ```
    
    You can check the results of your work in the Back Office by going to the **Site** tab.
    There, you should be able to add a new site and choose a design for it.
    
    ### Define domains 
    
    To be able to see your site online you need to define a domain for it.
    
    !!! caution "Define domain for production environment"
    
        These steps are for `dev` environment only.
        If you want to define domains in production environment, you will need to configure Apache or Nginx by yourself.
    
    In the `.env` file change line 2 to: `COMPOSE_FILE=doc/docker/base-dev.yml:doc/docker/multihost.yml`
    
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
    
    Then, run `docker-compose up`: 
    
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
    
    ![Site Factory enabled](img/site_factory_site_list.png "Site Factory enabled")
    
    ### Define site directory
        
     You can adjust the place where the directory of the new site will be created.
     By default the Location for the site directories is defined in bundle configuration `src/bundle/Resources/config/default_settings.yaml`:
     
     ``` yaml
     parameters:
         ezsettings.default.site_factory.sites_location_id: 2
     ```
    
    To change it to e.g. eZ Platform, go to `config/packages/ezplatform_site_factory.yaml`, and add the following parameter:
    
    ``` yaml
    parameters:
        ezsettings.default.site_factory.sites_location_id: 42
    ```
    
    Now, all new directories will be created under eZ Platform.
    
    ### Provide access
    
    The Site Factory is set up, now you can provide sufficient permissions to the Users.
    
    Set the below Policies to allow Users to:
    
    - `site/view` - enter the Site Factory interface
    - `site/create` - create sites
    - `site/edit` - edit sites
    - `site/change_status` - change status of the public accesses to `Live` or `Offline`
    - `site/delete` - delete sites

    For full documentation on how Permissions work and how to set them up, see [the Permissions section](permissions.md).
    
    ## Disable Site Factory
    
    Enabled Site Factory may cause following performance issues:
    
    - Config Resolver will look for SiteAccesses in the database
    - Site Factory matchers will be connected to the database in search for new SiteAccesses
    
    You can disable Site Factory to boost Config Resolver performance.
    Keep in mind that with disabled Site Factory you will not be able to add new sites or use existing ones.
    
    1\. In `config/packages/ezplatform_site_factory.yaml` change enabled to `false`.

    2\. In `config/packages/ezplatform.yaml` comment the `ezplatform.siteaccess.match: '@EzSystems\EzPlatformSiteFactory\SiteAccessMatcher': ~` if it is uncommented.

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
    
    ![Site Factory disabled](img/site_factory_disabled.png "Site Factory disabled")
