# Access control

eZ Commerce uses Policies to control access to some specific pages and functions.

## eZ Commerce policies

|Module|Function|Description|
|--- |--- |--- |
|`siso_policy`|`checkout`|Access the checkout process|
|`siso_policy`|`dashboard_view`|Access the Back Office cockpit|
|`siso_policy`|`forms_profile_edit`|Access the user profile|
|`siso_policy`|`lostorder_list`|Access the lost orders in the Back Office|
|`siso_policy`|`lostorder_manage`||
|`siso_policy`|`lostorder_process`||
|`siso_policy`|`quickorder`|Access the quick order|
|`siso_policy`|`read_basket`|See the basket|
|`siso_policy`|`write_basket`|Modify the basket (add, update, delete)|
|`siso_customercenter`|`approve`|Approve baskets in the customer center|
|`siso_customercenter`|`buy`|Buy as the customer center user|
|`siso_customercenter`|`view`|Access the customer center user management|

## Handling the access control

You can handle access to specific areas in th following places:

- In [forms](../forms/forms.md) you can add the Policy in the form configuration. 
- In controllers, if there is a defined route, you can add the Policy in the routing file:

``` yaml
siso_quick_order:
    pattern:  /quickorder
    defaults:
        _controller: SisoQuickOrderBundle:QuickOrder:quickOrder
        policy: siso_policy/quickorder
```

For a simple check if a user has a defined policy, this configuration is enough.
If you need more complex rules, e.g. to check the Section or check multiple Policies at once,
you need your own implementation in the controller.

!!! note

    When defining the policies, you must follow the `module/function` syntax.

### Access control mechanism

A central event listener checks the configuration from the routing file and Policies on every request.
If a user does not have the required Policy, `AccessDeniedException` is thrown and forwarded to the `ExceptionListener`.
Then the exception listener renders an access denied page.

`VerifyUserPoliciesRequestListener.php` listens to a `kernel.finish_request` event.
