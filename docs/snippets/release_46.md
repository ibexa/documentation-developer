[[% if version is not defined %]]
    [[% set version = '' %]]
[[% endif %]]

To learn more about all the included changes, see the full release change logs:

- [[[= product_name_headless =]] [[= version =]]](https://github.com/ibexa/headless/releases/tag/[[= version =]])
- [[[= product_name_exp =]] [[= version =]]](https://github.com/ibexa/experience/releases/tag/[[= version =]])
- [[[= product_name_com =]] [[= version =]]](https://github.com/ibexa/commerce/releases/tag/[[= version =]])

To update your application, see the [update instructions](../update_and_migration/from_4.6/update_from_4.6.md#[[= version_to_anchor(version) =]]).
