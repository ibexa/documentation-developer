---
month_change: false
description: Search options available for Action Configuration search
---

# Action Configuration search reference

You search for AI action configurations over the REST API, with the
[`POST /ai/actions`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Connector-AI/operation/ibexa.rest.ai.action.list.post) request.

The request payload takes the following search options:

| Option | Description |
|---|---|
| `query` | Returns action configurations with a name that starts with the given string, or with exactly this identifier |
| `action_type_identifier` | Returns action configurations of the given action type, for example `alt_text_generation` |
| `enabled` | Returns enabled (`true`) or disabled (`false`) action configurations |
| `limit` | Maximum number of action configurations to return |
| `page` | Number of the page of results to return, starting from 1 |

Results are sorted by action configuration ID, in descending order.

## Example

``` json
{
    "ActionConfigurationListInput": {
        "query": "alt",
        "action_type_identifier": "alt_text_generation",
        "enabled": true,
        "limit": 10,
        "page": 1
    }
}
```
