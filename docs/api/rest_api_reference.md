# REST API reference


The complete reference (specification) of the REST API resources is found bundled with your software, or online:

REST API reference

Path to where you can find specification of the version you have:

`vendor/ezsystems/ezpublish-kernel/doc/specifications/rest/REST-API-V2.rst`

Online version for latest version:

`https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst`

## About the REST specification structure

Resources are grouped by chapters: [Content](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#content), [Content Types](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#content-types) and [User](https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/specifications/rest/REST-API-V2.rst#user-management). In each of those chapters, you will first get an overview, with a table crossing every resource with every applicable HTTP verb, and giving you a summary of the action.

Then throughout the chapter, grouped into sub-chapters, is the detailed documentation for every resource, with:

-   The resource string
-   The HTTP verb with override, if applicable
-   A description of what this resource does
-   Which headers are supported, and how to use them
-   Which error codes can occur
-   Most of the time, a request + response example
