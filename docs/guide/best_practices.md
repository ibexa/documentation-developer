# Best Practices

## Structuring a project

eZ Platform comes with default settings that will let you get started in a few minutes.

### The AppBundle

Most projects can use the provided `AppBundle`, in the `src` folder. It is enabled by default. The project's PHP code (controllers, event listeners, etc.) can be placed there. 

Reusable libraries should be packaged so that they can easily be managed using Composer.

### Templates

Project templates should go into `app/Resources/views`.

They can then be referenced in code without any prefix, for example `app/Resources/views/content/full.html.twig` can be referenced in Twig templates or PHP as `content/full.html.twig`.

### Assets

Project assets should go into the `web` folder.

They can be referenced as relative to the root, for example `web/js/script.js` can be referenced as `js/script.js` from templates.

All project assets are accessible through the `web/assets` path.

### Configuration

Configuration may go into `app/config`. However, service definitions from `AppBundle` should go into `src/AppBundle/Resources/config`.

### Project example

You can see an example of organizing a simple project in the [companion repository](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial) for the [eZ Enteprise Beginner tutorial](../tutorials/enterprise_beginner/ez_enterprise_beginner_tutorial_-_its_a_dogs_world.md)

### Versioning a project

The recommended method is to version the whole ezplatform repository. Per installation configuration should use `parameters.yml`.

### `anonymous_user_id`
When a user that is not logged in is accessing an eZ Platform installation, the request will be handled with the permissions of the anonymous user. You can select any user on your system to represent the anonymous user.
For instance, you can also create a separate anonymous user group per siteaccess. Then, you can create the new user, assign them to the new group and make all permissions depend on siteaccess.
Take care to give the correct permissions to the anonymous user since these permissions are available for all users on your site. 

You can set `anonymous_user_id` the following way:
``` yaml
# ezplatform.yml
    system:
        siteaccess_group:
            anonymous_user_id: 14
        siteaccess:
            anonymous_user_id: 15
```
