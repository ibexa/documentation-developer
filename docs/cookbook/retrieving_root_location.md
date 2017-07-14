1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [Cookbook](Cookbook_31429528.html)

# Retrieving root location 

Created by Dominika Kurek, last modified by Sarah Haïm-Lubczanski on May 19, 2016

# Description

Knowledge of the root location is important since it can be a starting point for API queries, or even links to home page, but as eZ Platform can be used [for multisite development](Multisite_31430389.html), the **root location can vary**.

By default, the root location ID is `2`, but as it can be easily be changed by configuration, **the best practice is to retrieve it dynamically**.

# Solution

## Retrieving root location ID

Root location ID can be retrieved easily from  [ConfigResolver](https://doc.ez.no/display/DEVELOPER/SiteAccess#SiteAccess-Configuration). The parameter name is `           content.tree_root.location_id         `.

**In a controller**

``` brush:
<?php
namespace Acme\TestBundle\Controller;

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

## Retrieving the root location

### From a template

Root location is exposed in the [global Twig helper](https://doc.ez.no/display/DEVELOPER/Design#Design-TwigHelper).

**Making a link to homepage**

``` brush:
<a href="{{ path( ezpublish.rootLocation ) }}" title="Link to homepage">Home page</a>
```

### From a controller

``` brush:
<?php
namespace Acme\TestBundle\Controller;

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

 

 

#### In this topic:

-   [Description](#Retrievingrootlocation-Description)
-   [Solution](#Retrievingrootlocation-Solution)
    -   [Retrieving root location ID](#Retrievingrootlocation-RetrievingrootlocationID)
    -   [Retrieving the root location](#Retrievingrootlocation-Retrievingtherootlocation)
        -   [From a template](#Retrievingrootlocation-Fromatemplate)
        -   [From a controller](#Retrievingrootlocation-Fromacontroller)






