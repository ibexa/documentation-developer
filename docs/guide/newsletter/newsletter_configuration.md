# Newsletter configuration

General newsletter configuration is located in `newsletter.yml`:

``` yaml
parameters:
    # you can disable the newsletter module here
    siso_newsletter.default.newsletter_active: true
    # enable if you want to support several newsletter topics
    siso_newsletter.default.support_several_newsletters: false
    # if enabled, user will be unsubscribed from all newsletters (topics) at once
    siso_newsletter.default.unsubscribe_globally: true
    # if enabled also logged in users will see the newsletter box
    siso_newsletter.default.display_newsletter_box_for_logged_in_users: true
```

Related routes:

``` yaml
siso_newsletter_subscribe:
    path:     /newsletter/subscribe
    defaults:
        _controller: SisoNewsletterBundle:Newsletter:subscribeNewsletter
        breadcrumb_path: siso_newsletter_subscribe
        breadcrumb_names: subscribe newsletter

siso_newsletter_unsubscribe:
    path:     /newsletter/unsubscribe
    defaults:
        _controller: SisoNewsletterBundle:Newsletter:unsubscribeNewsletter
        breadcrumb_path: siso_newsletter_unsubscribe
        breadcrumb_names: common.unsubscribe_newsletter

siso_newsletter_update:
    path:     /newsletter/update
    defaults:
        _controller: SisoNewsletterBundle:Newsletter:updateNewsletter
        breadcrumb_path: silversolutionsCustomerDetail/siso_newsletter_update
        breadcrumb_names: My profile/common.update_newsletter

siso_newsletter_doi:
    path:     /newsletter/doi
    defaults:
        _controller: SisoNewsletterBundle:Newsletter:doubleOptInNewsletter
        breadcrumb_path: silversolutionsCustomerDetail/siso_newsletter_subscribe
        breadcrumb_names: My profile/subscribe newsletter
```
