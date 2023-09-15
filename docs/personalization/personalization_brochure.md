# Personalization

## What is Personalization

Personalization engine is a cloud-based service that tracks and analyzes customer behaviors and delivers optimized, user-tailored content, and information.

The engine uses artificial intelligence and machine learning modelling to learn and create behavioral patterns and generate recommendations ready to be presented on one or more websites hosted by the Ibexa DXP instance.

## Availability

Personalization service is available in all supported Ibexa DXP versions and editions.

Pricing is based on the number of Personalization API events.

To enable recommendation engine, request access to the service by [creating an account](https://doc.ibexa.co/projects/userguide/en/master/personalization/enable_personalization/#request-access-to-the-server).

After setting up an account and receiving credentials, pass them to your administrator who will configure Personalization service in your Ibexa DXP instance.

Now, you can start collecting data and boost your business.

## How does Personalization work?


![How it works](how_perso_works.png)


Personalization with tracking scripts, monitors  individual sessions from user’s behavior and interest data through events (clicks, viewed articles, pages, purchases) and demographic data (location, industry, occupation).

Next, collects data and computes models thanks to complex algorithms. 

Personalization is SiteAcces-aware, it means it can serve on multiple sites with different customer IDs and deliver recommendations for each site (for example, if you host multi language site).

Use Twig extension to add a tracking script and implement it into your site configuration.

## Capabilities

### Models

Models are statistics-based and perform calculations based on data from content, users and events.

They work in the background and update on regular time intervals to ensure best and accurate recommendations. Personalization service includes a few predefined models according to your needs and agreements between your organization and Ibexa.

If you need more customized models, contact customer support.

Includes the following model types:

- popularity models - based on trends, Top clicked, Top purchased, algorithm recommends trending content 

- collaborative models - generate predictions by analyzing user behavior and their interactions with target items, compares to other users behavior with similar browsing behavior

- editorial models - returns items, products from the manually prepared list

- B2B models - returns items clicked or bought by a segment group of a company

![Structure](categories.png)


### Scenarios

Scenarios are sequences of events. You can use scenarios to determine how and when render particular content to your customers. Each scenario can include also subscenarios used for granular personalized rendering of content.

### Segments

Use segments to get content targeted at particular user groups. Segments calculate models based on the segment attribute factor. Assign users to different recommendation groups and create advanced logic with operators to get best segmentation for your audience.

![Segments](perso_segment_group_or.png)

![Recommendations](recommendations.png)


### REST API

Personalization includes interface as API that you can use to interact with stored data and to send requests and export data from the service.

For more information see documentation for API operations available for Personalization:

[Tracking API](https://doc.ibexa.co/en/latest/personalization/api_reference/tracking_api/)

[Content API](https://doc.ibexa.co/en/latest/personalization/api_reference/content_api/)

[Recommendation API])Ibexa Documentation)https://doc.ibexa.co/en/latest/personalization/api_reference/recommendation_api/)

[User API](https://doc.ibexa.co/en/latest/personalization/api_reference/user_api/)

## Benefits

### Web design and content development

Create websites with content targeted at your customers. Deliver your visitors relevant content and build trust in your brand.

### Reduce clutter and improve customer retention

Help users find content of their interest quicker

use words to appeal to individual customers, as well as segments

Enrich customer data by integrating Ibexa Personalization with other systems such as ERP, CRMs.

Track user’s scenarios and develop strategies that match your strategies and improve engagement


### Satisfy customer expectations

Personalization engine shows customers products relevant to their interests, builds a feeling of connection and understanding

### Increase customer engagement

Targeted and customized content considerably improves engagement by delivering content that fits your visitors interests and anticipates their needs. This creates a bound between your brand and users who spend more time on your website, and are more likely to come back to your services. A kind of loyalty is created.

### Improve customer experience

Stand out from other companies by provided well-suited content and make a space for your customers where they feel known and valued and treated exceptional. Build trust and a bond with visitors, who are more likely to come back.

### Increase average order value 

Apply collaborative models with predictive analysis and find out what motivates users to put extra items into their carts. Start building predictions of their behaviors and suggest items, products your visitors are willing to buy.

![Dashboard](perso_dashboard_revenue.png)


### Measure your return and boost conversion rates 

Connect Personalization engine with your eCommerce shop, focus on the revenue generated by recommendations. Track what recommendations are shown to your visitors and analyze conversion rates. Effectively evaluate quality of recommendations and compare with your KPIs.

## Use cases

[eCommerce](https://doc.ibexa.co/projects/userguide/en/latest/personalization/use_cases/#ecommerce)

[Content publishing](https://doc.ibexa.co/projects/userguide/en/latest/personalization/use_cases/#content-publishing)

[Multiple website hosting](https://doc.ibexa.co/projects/userguide/en/latest/personalization/use_cases/#multiple-website-hosting)