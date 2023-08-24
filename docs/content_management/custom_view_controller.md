## Creating a custom Controller that renders using the 'ibexa_content' view system

### Use case

Create a generic custom controller and route that will return HTML based on the locationId provided.
The HTML should vary based on the Content Type of the provided locationId.

**Use Case Constraints**
* Create a custom Controller and custom Response()
* Passing locationIds will return HTML based on the Content Type rules setup in 'location_view'
* Tag the response based on the location

#### config/packages/my_site_location_view.yaml

```
ibexa:
    system:
        # The siteaccess
        frontend_group:
            location_view:
                promo:
                    article:
                        template: '@ibexadesign/site2/article/article-promo.html.twig'
                        match:
                            Identifier\ContentType: [ article ]
                    landing_page:
                        template: '@ibexadesign/site2/landing_page/landing_page-promo.html.twig'
                        match:
                            Identifier\ContentType: [ landing_page ]

```


### Approach 1: Direct Template and View generation

```
<?php

// Authors: Mateusz Bieniek / David Sayre
// Rendering ibexa 'view' using PHP to capture html fragment

namespace App\Controller;

use Ibexa\Bundle\Core\Controller;
use Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuilder;
use Ibexa\Core\MVC\Symfony\View\Renderer\TemplateRenderer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Ibexa\Contracts\HttpCache\ResponseTagger\ResponseTagger;

class TestController extends Controller
{
    private ContentViewBuilder $contentViewBuilder;
    private TemplateRenderer $templateRenderer;
    private ResponseTagger $responseTagger;
    
    public function __construct(
        ContentViewBuilder $contentViewBuilder,
        TemplateRenderer $templateRenderer,
        ResponseTagger $responseTagger,
    )
    {
        $this->contentViewBuilder = $contentViewBuilder;
        $this->templateRenderer = $templateRenderer;
        $this->responseTagger = $responseTagger;
    }

    #[Route('/get_promo_ajax', name: 'get_promo_ajax')]
    public function test(Request $request): Response
    {
        $locationId = $request->query->get('locationId');
        
        // build view
        $contentView = $this->contentViewBuilder->buildView([
            'locationId' => $locationId,
            'viewType' => 'promo',
            '_controller' => 'ibexa_content:viewAction',
        ]);
        
        // generate the HTML using TemplateRenderer + ContentViewBuilder
        $viewHTML = $this->templateRenderer->render($contentView);
        
        // custom code changing $viewHTML as needed .. 
        
        // create a custom response
        $response = new Response();
        // tag the response using the View (additional tags could be added)
        $this->responseTagger->tag(contentView);
        // store the captures HTML in the response
        $response->setContent($viewHTML);
        
        // alter response() as needed for TTL or private/public ... 

        return $response;
    }
}
```

### Approach 2: Use Controller->forward()

```
<?php

// Authors: Douglas Hammond / David Sayre
// Rendering ibexa 'view' using PHP to capture html fragment

namespace App\Controller;

use Ibexa\Bundle\Core\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Ibexa\Contracts\HttpCache\ResponseTagger\ResponseTagger;

class TestController extends Controller
{
    private ResponseTagger $responseTagger;
    
    public function __construct(
        ResponseTagger $responseTagger,
    )
    {
        $this->responseTagger = $responseTagger;
    }

    #[Route('/get_promo_ajax', name: 'get_promo_ajax')]
    public function test(Request $request): Response
    {
        $locationId = $request->query->get('locationId');
        
        // generate HTML using forward()
        $viewResponse = $this->forward('ibexa_content:viewAction', [
            'locationId' => $locationId,
            'viewType' => 'promo'
        ]);
        $viewHTML = $viewResponse->getContent();
        
        // custom code changing $viewHTML as needed .. 
                
        // create a custom response
        $response = new Response();
        // tag the response using the View (additional tags could be added)
        $this->responseTagger->tag(contentView);
        // store the captures HTML in the response
        $response->setContent($viewHTML);
        
        // alter response() as needed for TTL or private/public ... 

        return $response;
    }
}
```
