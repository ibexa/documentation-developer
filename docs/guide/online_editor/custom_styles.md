# Online Editor: Custom Styles

Since eZ Platform v2.3, it is possible to allow Editors to apply custom styling for their text written in the Online Editor. The feature depends on [the Alloy Editor styles feature](https://alloyeditor.com/docs/features/styles.html) and appears on the toolbar after selecting a portion of the edited text.

Please note that eZ Platform by default does not ship any Custom Styles as their implementation is very custom and project dependent.

The system distinguishes two kinds of Custom Styles: block and inline ones. Inline ones apply to the selected portion of text only, while the block ones apply to the whole paragraph.

## AdminUI configuration

The sample configuration is as follows:

**app/config/ezplatform.yml**

```yaml
ezpublish:
    system:
        admin_group:
            fieldtypes:
                ezrichtext:
                    custom_styles: [highlighted_block, highlighted_word]

    ezrichtext:
        custom_styles:
            highlighted_word:
                template: '@ezdesign/field_type/ezrichtext/custom_style/highlighted_word.html.twig'
                inline: true
            highlighted_block:
                template: '@ezdesign/field_type/ezrichtext/custom_style/highlighted_block.html.twig'
                inline: false
```

As it can be seen above, the system expects two kinds of configuration:
- a global list of Custom Styles, defined under the node `ezpublish.ezrichtext.custom_styles`,
- a list of enabled Custom Styles for a given Admin SiteAccess or Admin SiteAccess group, located under the node `ezpublish.system.<scope>.fieldtypes.ezrichtext.custom_styles`
  please note that defining this list for a front site SiteAccess currently has no effect on rendering of a front site.

As a reminder - please make sure to place proper portions of this configuration into existing one, keeping in mind that indentation matters.

## Translation

Labels that appear for each Custom Style in the Online Editor need to be translated using Symfony translations system. The translation domain is called `custom_tags`. For the given example, it can be achieved by creating the `app/Resources/translations/custom_tags.en.yml` file with the following contents:
```yaml
ezrichtext.custom_styles.highlighted_block.label: Highlighted block
ezrichtext.custom_styles.highlighted_word.label: Highlighted word
```

## Front-end rendering

The `template` key, of the above sample configuration, for each Custom Style allows to render the given styled text on a front-end site. While it can be arbitrary template path understood by Twig, _it is recommended to use eZ Design Engine as in the above sample configuration_.

Assuming the default Standard Design configuration with the Standard theme, the templates defined by the above configuration need to be placed respectively in:
- `app/Resources/views/themes/standard/field_type/ezrichtext/custom_style/highlighted_word.html.twig`
with the source code, e.g.:
```twig
<span class="ezstyle-{{ name }}">{% spaceless %}{{ content|raw }}{% endspaceless %}</span>

```
- `app/Resources/views/themes/standard/field_type/ezrichtext/custom_style/highlighted_block.html.twig`
with the source code, e.g.:
```twig
<div class="{% if align is defined %}align-{{ align }}{% endif %} ezstyle-{{ name }}">{% spaceless %}{{ content|raw }}{% endspaceless %}</div>
```

## AdminUI View mode of Content

These templates also are used when rendering View mode of a Content in the AdminUI. Using eZ Design in this case gives a possibilty to make separate views for frontend and AdminUI interface.
To use different templates when rendering Content View in the AdminUI, the templates just need to be placed in

```
app/Resources/views/themes/admin/field_type/ezrichtext/custom_style/highlighted_word.html.twig
```
and
```
app/Resources/views/themes/admin/field_type/ezrichtext/custom_style/highlighted_block.html.twig
```
directories respectively (assuming Admin SiteAccess uses Admin design with `admin` theme).
