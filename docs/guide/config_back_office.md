# Back Office configuration

## Copy subtree limit

Copying large subtrees can cause performance issues, so you can limit the number of Content items
that can be copied at once using `ezsystems.platformui.application_config.copy_subtree.limit`
in `parameters.yml`.

The default value is `100`. You can set it to `-1` for no limit,
or to `0` to completely disable copying subtrees.
