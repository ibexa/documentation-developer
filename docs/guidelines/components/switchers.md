# Switchers
We list here all the switchers that eZ Platform uses.

##<div class="mgt-3 header-line">Switcher</div>
<div class="ez-guidelines-switcher">
<p class="mgt-minus-3 mgb-3">We created `switcher` as a SASS @mixin function (check [`ezplatform-admin-ui/src/bundle/Resources/public/scss/_mixins.scss`](https://github.com/ezsystems/ezplatform-admin-ui/blob/v1.5.7/src/bundle/Resources/public/scss/_mixins.scss)).</p>
<p  class="mgb-5">Specify its size in the @mixin function: `@include checkbox-switcher($size);` in the corresponding `.scss` stylesheet. By default its size is set to 2rem.</p>
<div class="ez-guidelines-switcher">
[[code_example {html}
<div class="ez-data-source">
    <label class="ez-data-source__label">
        <input class="ez-data-source__input" type="checkbox">
        <span class="ez-data-source__indicator"></span>
    </label>
</div>
code_example]]
</div>

##<div class="mgt-3 header-line">Switcher with icons</div>
####<div>**Primary color**</div>
<div class="ez-guidelines-switcher-icons ez-guidelines-switcher-icons--primary">
[[code_example {html}
<label class="ez-checkbox-icon ez-page-info-bar-switcher is-checked">
    <svg class="ez-icon ez-icon--view">
        <use xlink:href="../../ez-icons.svg#view"></use>
    </svg>
    <svg class="ez-icon ez-icon--view-hide">
        <use xlink:href="../../ez-icons.svg#edit"></use>
    </svg>
    <input class="ez-checkbox-icon__checkbox" type="checkbox">
</label>
code_example]]
</div>

####<div class="mgt-5">**Secondary color**</div>
<div class="ez-guidelines-switcher-icons">
[[code_example {html}
<label class="ez-checkbox-icon is-checked">
    <svg class="ez-icon ez-icon--view">
        <use xlink:href="../../ez-icons.svg#view"></use>
    </svg>
    <svg class="ez-icon ez-icon--view-hide">
        <use xlink:href="../../ez-icons.svg#view-hide"></use>
    </svg>
    <input class="ez-checkbox-icon__checkbox" type="checkbox">
</label>
code_example]]
</div>

!!! note
    When using switchers with icons don't forget to add the corresponding `JS` script linked to the actions you want to trigger.

##<div class="mgt-3 header-line">Preview switcher</div>
<div class="ez-guidelines-switcher-preview">
[[code_example {html}
<div class="ez-preview-switcher">
    <button class="ez-preview-switcher__action ez-preview-switcher__action--selected">
        <svg class="ez-icon">
            <use xlink:href="../../ez-icons.svg#view-desktop"></use>
        </svg>
    </button>
    <button class="ez-preview-switcher__action">
        <svg class="ez-icon">
            <use xlink:href="../../ez-icons.svg#view-tablet"></use>
        </svg>
    </button>
    <button class="ez-preview-switcher__action">
        <svg class="ez-icon">
            <use xlink:href="../../ez-icons.svg#view-mobile"></use>
        </svg>
    </button>
</div>
code_example]]
</div>
