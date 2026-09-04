---
description: Create route to to enable binary and media files download.
---

# Binary and Media download

You can restrict files stored in BinaryFile or Media fields to certain user roles.
These files aren't publicly downloadable from disk, and are instead served by a route that runs the necessary checks.
This route is automatically generated as the `url` property for those field values.

## REST API: `uri` property

The `uri` property of Binary fields in REST contains a valid download URL, prefixed with the same host as the REST Request.

For [more information about REST API see the documentation](rest_api_usage.md).
