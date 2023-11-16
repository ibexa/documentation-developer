---
description: Upload created bundle extension to Packagist.
---

# Upload bundle to Packagist

The following section explains how to upload created bundle  on the [packagist.org](https://packagist.org/) website.

1\. Go to the Packagist website and click **Submit**.

![Submit package](packagist_submit.png)

2\. Provide the repository URL to your package, for example:

`https://github.com/acme/example-3rd-party-extension`


!!! note
    When you add a new feature, you need to create a tag.


3\. To create a new tag, in GitHub, go to **Tags** section, and click **Create a new release**.

![New tag](new_tag.png)

4\. Link your bundle repository with Packagist.

Make sure the repository is set to public.
Each time you add a new feature to your bundle, you need to also add a new tag.

5\. Click the **Check** button to verify the bundle completeness.

In `composer.json` in the `repositories` indicate the type and bundle URL:

```json
"repositories": {
        "ibexa": {
            "type": "composer",
            "url": "https://updates.ibexa.co"
        },
        "acme/currency-exchange-rate":{
            "type": "vcs",
            "url": "https://github.com/acmee/example-3rd-party-extension"
        }
    }
```

Any change in repository immediately affects the other bundle so you can see the changes.