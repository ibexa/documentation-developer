# eZ Platform v1.7.0 LTS


**The v1.7.0 release of eZ Platform and eZ Platform Enterprise Edition is available as of December 15, 2016.**

**<https://ezplatform.com/Blog/Long-Term-Support-is-Here>**

LTS Info

eZ Platform Enterprise Edition v1.7.0 is the first version of the 2017 Long Term Support ("LTS") release which will be maintained and supported until December 2019.

As of v1.7.0, PHP requirements have been updated to remove PHP 5.5, leaving PHP 5.6 and 7.0 as supported PHP versions.

With the LTS release, the [new product naming](http://ez.no/Blog/eZ-Announces-Name-Changes-to-Product-Portfolio) takes effect: "eZ Platform" for the Open Source edition, and "eZ Platform Enterprise Edition" for subscribers.


## Notable Changes Since v1.6.0

### eZ Platform (Open Source)

-   **i18n! Internationalization of the eZ Platform** User Interface is now possible. The new system selects the language to use based on the browser settings of the end user. The system makes it possible to create translations for eZ Platform UI. Studio internationalization, as well as translations ready to use will be shipped in further releases. Community members are more than welcome to contribute to the translation process.
    ![](i18n.png)

<!-- -->

-   **Universal Discovery Widget** ("UDW") provides a range of small improvements. The most noticeable one is the preview of content which is more usable and also provides a way to get a full preview of the content object.

![](udwre.png)

-   The Admin Panel now provides a way to get a very clean **digest view of Content Types** configured in the system, with the ability to clearly get access to properties and field definitions.

![](contenttypeviews.png)

-   The online editor also brings a range of improvements that improve the editorial experience. The most noticeable one is to offer the possibility to switch from Headings to Paragraph styles for the same element.

 

##### Notable technical improvements:

-   Search:
    -   Solr Search Engine: Plugins, extend the Solr index with custom data on Content, Translation and Location block level ([EZP-26368](https://jira.ez.no/browse/EZP-26368))
        -   For when you need to extend the index with additional data not applicable for FieldType custom fields feature
        -   *[See Solr Bundle documentation for more info ](https://doc.ibexa.co/en/2.5/guide/search/solr/)*
    -   Solr Search Engine: Support for FieldRelation on location search ([EZP-26756](http://jira.ez.no/browse/EZP-26756))
    -   Legacy Search Engine: Improve word boundaries detection ([EZP-26499](http://jira.ez.no/browse/EZP-26499))
    -   ezplatform:reindex added, a generic command for reindexing search index on the SiteAccess configured search engine ([EZP-26098](http://jira.ez.no/browse/EZP-26098))
-   Extensibility:
    -    QueryType's now support using alias when being used as service so you can define several services with same  QueryType class ([EZP-26628](http://jira.ez.no/browse/EZP-26628))
        -    Example: Generic location child QueryType being reused several times for specific services for article or blog post listings 
-   API:
    -   New method:` Location->getSortClauses()` to get sort clauses based on what kind of sorting has been set on the Location ([EZP-26528](http://jira.ez.no/browse/EZP-26528))
    -   Add Content Version archives limit by configuration & enforce on publish ([EZP-23281](http://jira.ez.no/browse/EZP-23281))
-   Debug:
    -   ez-support-tools:dump-info command now able to dump system info in several formats, and default is now json ([EZP-26549](http://jira.ez.no/browse/EZP-26549))
        -   *Making it more useful for attaching system info when reporting issues*
    -   Add SiteAccess collector to debug toolbar ([EZP-26375](http://jira.ez.no/browse/EZP-26375))
    -   Make IO exceptions more user friendly ([EZP-26683](http://jira.ez.no/browse/EZP-26683))
    -   Make it possible to retrieve original exception when repo-&gt;commit() fails ([EZP-26407](http://jira.ez.no/browse/EZP-26407))

 

*For more fixes and improvements scroll down for full change log.*

### eZ Platform Enterprise Edition (with Studio)

-   You can now use our eZ Personalization service to create highly personalized landing pages. The Studio **Personalization Block** available out of the box lets the editor simply create a block that will render a list of content items personalized to each and every visitor. The interface lets the editor decide which of the Personalization scenarios configured in the eZ Personalization back end should be used, as well as the template to be used for rendering.

![](personalizationblock.png)

-   You can now take advantage of the **Date-Based Publishing** feature – when editing a draft, instead of publishing the content immediately you can select the date and time at which it will be automatically published. All your content scheduled to be published are accessible in a dedicated widget on the dashboard.

![](future_publication_window.png)

-   Create forms in your Landing Page using the **Form Builder**. A special Form Block allows you to add forms with different types of fields to the Landing Page. This system has been designed to be extended, so that you can create your own form fields. The system also provide an interface to access the data that has been collected, and download it as CSV files.

![](form-builder-1.png)

Submitted results can be previewed in the UI or downloaded in a CSV file, and a designated person will be notified of submissions by email.

### Updated Demo Sites

The Enterprise demo site has been significantly improved featuring a new **Product Content Type** that is used to show products in the Tasteful Planet demo. The product we used are meals that, in a non-demo ideal world, would be available to order and consume. This ordering part is not in the demo, nevertheless, the content looks really yummy... Other improvements includes the good setup of all content type field categories and the demonstration of basic SEO field types. Demo content itself has also been upgraded with more content to better demonstrate the capabilities.

![](productcontenttype.png)

 

### Installation

[Installation Guide](https://doc.ibexa.co/en/latest/getting_started/install_ez_platform)

[Technical Requirements](https://doc.ibexa.co/en/latest/getting_started/requirements)

### Download

#### eZ Platform

- Download at [eZPlatform.com](http://ezplatform.com/#download)

#### eZ Enterprise

- [Customers: eZ Enterprise subscription (BUL License)](https://support.ez.no/Downloads)
- Partners: Test & Trial software access (TTL License)

If you would like to become familiar with the products, [request a demo](https://www.ibexa.co/forms/request-a-demo).

### Updating

To update the product, follow the [updating guide](https://doc.ibexa.co/en/latest/updating/updating/).
