# Newsletter interface

eZ Commerce provides a common interface for newsletter providers: `Siso\Bundle\NewsletterBundle\Api\NewsletterInterface`. If another newsletter provider is used, the following methods have to be implemented.

## subscribeNewsletter/unsubscribeNewsletter

The `subscribeNewsletter` and `unsubscribeNewsletter` methods subscribe or unsubscribe to/from a newsletter with given `$params`.
You can pass to the method any data that is, for example, posted from a form.
If `$customerProfileData` is provided, attributes from `$customerProfileData` are used to (un)subscribe to/from the newsletter
otherwise the required attributes must be specified in `$params`.

Returns a list with the newsletter IDs and whether the action was successful (true/false).

## updateNewsletter

The `updateNewsletter` method updates newsletter details with given `$params`.
The implementation of this method must dispatch `UpdateNewsletterEvent`.

Returns a list with the newsletter IDs and whether the action was successful (true/false).

## updateUserEmail

The `updateUserEmail` method updates newsletter user's email address.

Returns a list with the newsletter IDs and whether the action was successful (true/false).

## getEmail

The `getEmail` method returns the email address.

If `CustomerProfileData` is provided, the email from `SesUser` is used.
If `CustomerProfileData` is not provided, the email from `$params` is used.

## doesUserExistInNewsletter

The `doesUserExistInNewsletter` method returns true if a user exists in the newsletter provider.
This method checks if the user is known to the newsletter provider, but does not evaluate the status
(if the user subscribes to the newsletter).

The goal of this method is to find out if a user exists in the DB of the newsletter provider (active/inactive),
because even if the user is inactive, they probably already confirmed their email address in the past
(e.g. through the double opt-in process).

## doesUserSubscribeNewsletter

The `doesUserSubscribeNewsletter` method reads the user newsletter status - whether the user subscribes to the newsletter - from the provider.
If `$customerProfileData` is given, attributes from `$customerProfileData` are used to check the newsletter status,
otherwise the required attributes must be specified in `$params`.

Returns a list with the newsletter IDs and whether the action was successful (true/false).

## doesUserSubscribeAtLeastOneNewsletter

The `doesUserSubscribeAtLeastOneNewsletter` method returns true if the user subscribes to at least one newsletter.
No call to API is done. Instead the result of one of the methods above should be passed as parameter.

## getSubscribedNewsletterIds

The `getSubscribedNewsletterIds` method returns a list of newsletter IDs that a user subscribes to.
No call to API is done. Instead the result of one of the methods above should be passed as parameter.
