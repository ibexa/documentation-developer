# Retrieving root Location

The root Location can be a starting point for API queries, or even links to home page.

By default, the root Location ID is `2`, but the best practice is to retrieve it dynamically.
This is because [[= product_name =]] can be used for [multisite development](multisite.md) and the root Location can vary.
The Location can also be changed by configuration.

### Retrieving root Location ID

Root location ID can be retrieved from [ConfigResolver](config_dynamic.md#configresolver).
The parameter name is `content.tree_root.location_id`.

``` php
<?php

namespace App\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;

class DefaultController extends Controller
{
    public function fooAction()
    {
        // ...
 
        $rootLocationId = $this->getConfigResolver()->getParameter( 'content.tree_root.location_id' );
 
        // ...
    }
}
```

### Retrieving the root Location

#### From template

Root Location is exposed in the [global Twig helper](content_rendering.md#twig-helper).

``` html+twig
<a href="{{ ez_path( ezplatform.rootLocation ) }}" title="Link to homepage">Home page</a>
```

#### From controller

``` php
<?php

namespace App\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller;

class DefaultController extends Controller
{
    public function fooAction()
    {
        // ...

        $rootLocation = $this->getRootLocation();

        // ...
    }
}
```
