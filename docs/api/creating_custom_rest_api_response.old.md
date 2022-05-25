# Creating custom REST API response based on Accept header

Customized REST API response can be used in many situations, both for headless and more traditional setups. REST responses can be enriched in a clean way and limit client-to-server round trips.

To do this you can take advantage of [[= product_name =]]'s [HATEOAS-based](https://en.wikipedia.org/wiki/HATEOAS) REST API and extend it with custom Content Types for your own needs. In this section you will add comments count to `Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo` responses.

## Implementation of dedicated Visitor

## Overriding response type

## Configuration

## Fetching the modified response
TODO: It's hard to see the customization compared to the default response
TODO: `"commentsCount": null` looks like a bad example. Maybe something more generic? Like adding System URL Alias to Location?

After following all the steps you should see an example of the modified API response below. As you see `media-type` is correctly interpreted and `commentsCount` is also appended (it's `null` as you did not provide any logic to fetch it).
Please note that you should set a proper `Accept` header value. For this example: `application/my.api.VersionList+json`.

```json
{
    "VersionList": {
        "_media-type": "application\/my.api.VersionList+json",
        "_href": "\/api\/ezp\/v2\/content\/objects\/1\/versions",
        "VersionItem": [
            {
                "Version": {
                    "_media-type": "application\/my.api.Version+json",
                    "_href": "\/api\/ezp\/v2\/content\/objects\/1\/versions\/9"
                },
                "VersionInfo": {
                    "id": 506,
                    "versionNo": 9,
                    "status": "PUBLISHED",
                    "modificationDate": "2015-11-30T14:10:46+01:00",
                    "Creator": {
                        "_media-type": "application\/my.api.User+json",
                        "_href": "\/api\/ezp\/v2\/user\/users\/14"
                    },
                    "creationDate": "2015-11-30T14:10:45+01:00",
                    "initialLanguageCode": "eng-GB",
                    "languageCodes": "eng-GB",
                    "VersionTranslationInfo": {
                        "_media-type": "application\/my.api.VersionTranslationInfo+json",
                        "Language": [
                            {
                                "languageCode": "eng-GB"
                            }
                        ]
                    },
                    "names": {
                        "value": [
                            {
                                "_languageCode": "eng-GB",
                                "#text": "Ibexa Platform"
                            }
                        ]
                    },
                    "Content": {
                        "_media-type": "application\/my.api.ContentInfo+json",
                        "_href": "\/api\/ezp\/v2\/content\/objects\/1"
                    },
                    "commentsCount": null
                }
            }
        ]
    }
}
```

!!! tip

    You can test your response by using JavaScript/AJAX example code, see [testing the API](rest_api_guide.old.md#testing-the-api).
