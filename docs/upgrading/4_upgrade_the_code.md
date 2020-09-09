# 4. Upgrade your code

!!! note "Full list of deprecations"

    If you encounter any issue during the upgrade,
    see [eZ Platform v3.0 deprecations](../releases/ez_platform_v3.0_deprecations.md#template-organization)
    for details of all required changes to your code.

## Third-party dependencies

Because eZ Platform v3 is based on Symfony 5, you need to make sure all additional third-party dependencies
that your project uses have been adapted to Symfony 5.
    
## Automatic code refactoring - non-essential step

To simplify the process of adapting your code to Symfony 5, you can use [Rector, a reconstructor tool](https://github.com/rectorphp/rector)
that will automatically refactor your Symfony and PHPunit code.

To properly refactor your code, you might need to run the Rector `process` command for each Symfony version from 4.0 to 5.0 in turn:

`vendor/bin/rector process src --set symfony40`

You can find all the available sets in [the Rector repository](https://github.com/rectorphp/rector/tree/v0.7.65/config/set). 
Keep in mind that after automatic refactoring finishes there might be some code chunks that you need to fix manually.
