# 4.5. Update Online Editor

## RichText

Deprecated code related to the RichText Field Type has been removed from `ezpublish-kernel`.

If your code still relies on the `eZ\Publish\Core\FieldType\RichText` namespace, you need to rewrite it
to use `EzSystems\EzPlatformRichText\eZ\RichText` instead.

## Extra buttons

Configuring custom Online Editor buttons with `ezrichtext.alloy_editor.extra_buttons` is deprecated.

If you added custom buttons in this way, you need to rewrite your code to use
`ezplatform.system.<siteacces>.fieldtypes.ezrichtext.toolbars.<toolbar_identifier>.buttons` instead.
