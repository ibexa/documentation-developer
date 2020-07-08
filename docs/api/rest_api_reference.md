# REST API reference


The complete REST API reference resources can be found:

  - Bundled with your software version: 
  
   `vendor/ezsystems/ezpublish-kernel/doc/specifications/rest/REST-API-V2.rst`
  
  - [Online with latest API version](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/doc/specifications/rest/REST-API-V2.rst)

## About the REST specification structure

Resources are grouped by chapters: [Content](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/doc/specifications/rest/REST-API-V2.rst#content), [Content Types](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/doc/specifications/rest/REST-API-V2.rst#content-types) and [User](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.5/doc/specifications/rest/REST-API-V2.rst#user-management). In each of those chapters, you will first get an overview, with a table crossing every resource with every applicable HTTP verb, giving you a summary of the action.

Then throughout the chapter, the detailed documentation for every resource is grouped into sub-chapters:

-   The resource string
-   The HTTP verb with override, if applicable
-   A description of what this resource does
-   Which headers are supported, and how to use them
-   Which error codes can occur
-   Most of the time, a request and response example
