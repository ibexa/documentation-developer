---
description: To authenticate REST API communication you can use session (default), JWT, basic, OAuth and client certificate (SSL) authentication.
month_change: false
---

# REST API authentication

This page refers to [REST API reference](rest_api_reference/rest_api_reference.html), where you can find detailed information about
REST API resources and endpoints.



!!! caution "SiteAccess login"

    The anonymous user is used to perform authentification requests.
    Therefore, the "Anonymous" role must have `user/login` permission on the SiteAccess that matches the REST domain or is passed through the [`X-Siteaccess` header](rest_requests.md#siteaccess).


## OAuth

TODO: Oauth is the only authentication method. Add an example showing the whole flow.

For more information, see [OAuth 2.0 protocol for authorization](https://oauth.net/2/).
