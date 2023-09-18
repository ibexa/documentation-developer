# Upload bundle to Packagist

1\. Go to the Packagist website. Click submit.
1\. Provide the repository url to your package.

1\. When you add a new feature, you need to create a tag. 
In PHPStorm or other PHP IntelliJ editor, go to commits, Log and create a new tag.
Then a new version will be published on packagist.

1\. Link repo with packagist.
Make sure your repository is set to public.
Each time you add a new feature to your bundle, you need to also add a new tag.
New version will be released on Packagist.

1\. Click the **Check** button to verify the completeness of the bundle.

In `composer.json` in the repositories

```json
 "repositories": [
    { 
        "type": "composer", 
        "url": "https://updates.ibexa.co" 
    }
```

Indicate the type for path
and url - bundle name
Any change in repository immediately affects the other bundle so you can see the changes.