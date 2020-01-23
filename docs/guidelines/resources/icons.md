# Icons

We provide visual context with icons, we want to emphasize the most important interactions. Our objective is to enhance usability.

##<div class="mgt-2 header-line">Use</div>
<div class="mgt-minus-4 mgb-5">When using icons add this code below, specify the selected icon `svg identifier` and if needed customize your CSS accordingly:</div>


[[code_example {html}
<svg class="ez-icon">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#publish"></use>
</svg>
code_example]]

###<div class="mgt-2">Small icons</div>
<div class="mgt-minus-3 mgb-5">Add class `ez-icon--small` to modify an icon to its smallest size.</div>
[[code_example {html}
<svg class="ez-icon ez-icon--small">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#publish"></use>
</svg>
code_example]]

###<div class="mgt-2">Small-Medium icons</div>
<div class="mgt-minus-3 mgb-5">Add class `ez-icon--small-medium` to modify an icon to its second smallest size.</div>
[[code_example {html}
<svg class="ez-icon ez-icon--small-medium">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#publish"></use>
</svg>
code_example]]

###<div class="mgt-2">Medium icons</div>
<div class="mgt-minus-3 mgb-5">Add class `ez-icon--medium` to modify an icon to its medium size.</div>
[[code_example {html}
<svg class="ez-icon ez-icon--medium">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#publish"></use>
</svg>
code_example]]

###<div class="mgt-2">Large icons</div>
<div class="mgt-minus-3 mgb-5">Add class `ez-icon--large` to modify an icon to its large size.</div>
[[code_example {html}
<svg class="ez-icon ez-icon--large">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#publish"></use>
</svg>
code_example]]

###<div class="mgt-2">Extra Large icons</div>
<div class="mgt-minus-3 mgb-5">Add class `ez-icon--extra-large` to modify an icon to its largest size.</div>
[[code_example {html}
<svg class="ez-icon ez-icon--extra-large">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#publish"></use>
</svg>
code_example]]

###<div class="mgt-2">Colored icons - dark</div>
<div class="mgt-minus-3 mgb-5">Add class `ez-icon--dark` to modify the color fill of an icon to the Sass variable defined for white, `$ez-black`.</div>
<div class="ez-guidelines-icons__colored">
[[code_example {html}
<svg class="ez-icon ez-icon--medium ez-icon--dark ez-icon-content-draft">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#content-draft"></use>
</svg>
</button>
code_example]]
</div>

###<div class="mgt-2">Colored icons - white</div>
<div class="mgt-minus-3 mgb-5">Add class `ez-icon--light` to modify the color fill of an icon to the Sass variable defined for white, `$ez-white`.</div>
<div class="ez-guidelines-icons__colored">
[[code_example {html}
<button type="button" class="btn btn-primary">
    <svg class="ez-icon ez-icon--medium ez-icon--light ez-icon-create">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#create"></use>
    </svg>
    <span>Create</span>
</button>
code_example]]
</div>

!!! note
    We have used here a button as an example. If you want to dig more into buttons check [Buttons](../components/buttons.md) component.

###<div class="mgt-2">Colored icons - secondary</div>
<div class="mgt-minus-3 mgb-5">Add class `ez-icon--secondary` to modify the color fill of an icon to the Sass variable defined for secondary color, `$ez-color-secondary`.</div>
[[code_example {html}
<svg class="ez-icon ez-icon--secondary">
    <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#publish"></use>
</svg>
code_example]]

##<div class="mgt-5">Icon set</div>
<div class="mgt-minus-4">Here you can find all SVG icons our CMS uses classified by categories:</div>

###<div class="mgt-2 header-line">General</div>
<div class="wrapper-samples mgt-minus-3">
    <div class="icon-box">
        <svg class="ez-icon ez-icon-about-info">
            <use xlink:href="../../ez-icons.svg#about-info"></use>
        </svg>
        <p class="icon-label">about-info</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-about">
            <use xlink:href="../../ez-icons.svg#about"></use>
        </svg>
        <p class="icon-label">about</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-airtime">
            <use xlink:href="../../ez-icons.svg#airtime"></use>
        </svg>
        <p class="icon-label">airtime</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-approved">
            <use xlink:href="../../ez-icons.svg#approved"></use>
        </svg>
        <p class="icon-label">approved</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-archive-restore">
            <use xlink:href="../../ez-icons.svg#archive-restore"></use>
        </svg>
        <p class="icon-label">archive-restore</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-assign-section">
            <use xlink:href="../../ez-icons.svg#assign-section"></use>
        </svg>
        <p class="icon-label">assign-section</p>
    </div>
     <div class="icon-box">
        <svg class="ez-icon ez-icon-assign-user">
            <use xlink:href="../../ez-icons.svg#assign-user"></use>
        </svg>
        <p class="icon-label">assign-user</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-author">
            <use xlink:href="../../ez-icons.svg#author"></use>
        </svg>
        <p class="icon-label">author</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-back">
            <use xlink:href="../../ez-icons.svg#back"></use>
        </svg>
        <p class="icon-label">back</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-back-current-date">
            <use xlink:href="../../ez-icons.svg#back-current-date"></use>
        </svg>
        <p class="icon-label">back-current-date</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-banner">
            <use xlink:href="../../ez-icons.svg#banner"></use>
        </svg>
        <p class="icon-label">banner</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-block-add">
            <use xlink:href="../../ez-icons.svg#block-add"></use>
        </svg>
        <p class="icon-label">block-add</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-block-invisible">
            <use xlink:href="../../ez-icons.svg#block-invisible"></use>
        </svg>
        <p class="icon-label">block-invisible</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-block-visible-recurring">
            <use xlink:href="../../ez-icons.svg#block-visible-recurring"></use>
        </svg>
        <p class="icon-label">block-visible-recurring</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-block-visible">
            <use xlink:href="../../ez-icons.svg#block-visible"></use>
        </svg>
        <p class="icon-label">block-visible</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-bookmark-active">
            <use xlink:href="../../ez-icons.svg#bookmark-active"></use>
        </svg>
        <p class="icon-label">bookmark-active</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-bookmark-manager">
            <use xlink:href="../../ez-icons.svg#bookmark-manager"></use>
        </svg>
        <p class="icon-label">bookmark-manager</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-bookmark">
            <use xlink:href="../../ez-icons.svg#bookmark"></use>
        </svg>
        <p class="icon-label">bookmark</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-browse">
            <use xlink:href="../../ez-icons.svg#browse"></use>
        </svg>
        <p class="icon-label">browse</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-bubbles">
            <use xlink:href="../../ez-icons.svg#bubbles"></use>
        </svg>
        <p class="icon-label">bubbles</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-caret-back">
            <use xlink:href="../../ez-icons.svg#caret-back"></use>
        </svg>
        <p class="icon-label">caret-back</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-caret-down">
            <use xlink:href="../../ez-icons.svg#caret-down"></use>
        </svg>
        <p class="icon-label">caret-down</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-caret-next">
            <use xlink:href="../../ez-icons.svg#caret-next"></use>
        </svg>
        <p class="icon-label">caret-next</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-caret-up">
            <use xlink:href="../../ez-icons.svg#caret-up"></use>
        </svg>
        <p class="icon-label">caret-up</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-category">
            <use xlink:href="../../ez-icons.svg#category"></use>
        </svg>
        <p class="icon-label">category</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-checkmark">
            <use xlink:href="../../ez-icons.svg#checkmark"></use>
        </svg>
        <p class="icon-label">checkmark</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-circle-caret-down">
            <use xlink:href="../../ez-icons.svg#circle-caret-down"></use>
        </svg>
        <p class="icon-label">circle-caret-down</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-circle-caret-left">
            <use xlink:href="../../ez-icons.svg#circle-caret-left"></use>
        </svg>
        <p class="icon-label">circle-caret-left</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-circle-caret-right">
            <use xlink:href="../../ez-icons.svg#circle-caret-right"></use>
        </svg>
        <p class="icon-label">circle-caret-right</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-circle-caret-up">
            <use xlink:href="../../ez-icons.svg#circle-caret-up"></use>
        </svg>
        <p class="icon-label">circle-caret-up</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-circle-close">
            <use xlink:href="../../ez-icons.svg#circle-close"></use>
        </svg>
        <p class="icon-label">circle-close</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-circle-create">
            <use xlink:href="../../ez-icons.svg#circle-create"></use>
        </svg>
        <p class="icon-label">circle-create</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-clipboard">
            <use xlink:href="../../ez-icons.svg#clipboard"></use>
        </svg>
        <p class="icon-label">clipboard</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-comment">
            <use xlink:href="../../ez-icons.svg#comment"></use>
        </svg>
        <p class="icon-label">comment</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-content-draft">
            <use xlink:href="../../ez-icons.svg#content-draft"></use>
        </svg>
        <p class="icon-label">content-draft</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-content-tree">
            <use xlink:href="../../ez-icons.svg#content-tree"></use>
        </svg>
        <p class="icon-label">content-tree</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-content-type">
            <use xlink:href="../../ez-icons.svg#content-type"></use>
        </svg>
        <p class="icon-label">content-type</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-copy">
            <use xlink:href="../../ez-icons.svg#copy"></use>
        </svg>
        <p class="icon-label">copy</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-copy-subtree">
            <use xlink:href="../../ez-icons.svg#copy-subtree"></use>
        </svg>
        <p class="icon-label">copy-subtree</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-create-content">
            <use xlink:href="../../ez-icons.svg#create-content"></use>
        </svg>
        <p class="icon-label">create-content</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-create">
            <use xlink:href="../../ez-icons.svg#create"></use>
        </svg>
        <p class="icon-label">create</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-dashboard">
            <use xlink:href="../../ez-icons.svg#dashboard"></use>
        </svg>
        <p class="icon-label">dashboard</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-discard">
            <use xlink:href="../../ez-icons.svg#discard"></use>
        </svg>
        <p class="icon-label">discard</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-download">
            <use xlink:href="../../ez-icons.svg#download"></use>
        </svg>
        <p class="icon-label">download</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-drag">
            <use xlink:href="../../ez-icons.svg#drag"></use>
        </svg>
        <p class="icon-label">drag</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-edit">
            <use xlink:href="../../ez-icons.svg#edit"></use>
        </svg>
        <p class="icon-label">edit</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-embed">
            <use xlink:href="../../ez-icons.svg#embed"></use>
        </svg>
        <p class="icon-label">embed</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-error">
            <use xlink:href="../../ez-icons.svg#error"></use>
        </svg>
        <p class="icon-label">error</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-fields">
            <use xlink:href="../../ez-icons.svg#fields"></use>
        </svg>
        <p class="icon-label">fields</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-file-text">
            <use xlink:href="../../ez-icons.svg#file-text"></use>
        </svg>
        <p class="icon-label">file-text</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-file-video">
            <use xlink:href="../../ez-icons.svg#file-video"></use>
        </svg>
        <p class="icon-label">file-video</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-file">
            <use xlink:href="../../ez-icons.svg#file"></use>
        </svg>
        <p class="icon-label">file</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-filters">
            <use xlink:href="../../ez-icons.svg#filters"></use>
        </svg>
        <p class="icon-label">filters</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-focus">
            <use xlink:href="../../ez-icons.svg#focus"></use>
        </svg>
        <p class="icon-label">focus</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-folder-empty">
            <use xlink:href="../../ez-icons.svg#folder-empty"></use>
        </svg>
        <p class="icon-label">folder-empty</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-folder">
            <use xlink:href="../../ez-icons.svg#folder"></use>
        </svg>
        <p class="icon-label">folder</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-form-data">
            <use xlink:href="../../ez-icons.svg#form-data"></use>
        </svg>
        <p class="icon-label">form-data</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-form">
            <use xlink:href="../../ez-icons.svg#form"></use>
        </svg>
        <p class="icon-label">form</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-future-publication">
            <use xlink:href="../../ez-icons.svg#future-publication"></use>
        </svg>
        <p class="icon-label">future-publication</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-history">
            <use xlink:href="../../ez-icons.svg#history"></use>
        </svg>
        <p class="icon-label">history</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-home-page">
            <use xlink:href="../../ez-icons.svg#home-page"></use>
        </svg>
        <p class="icon-label">home-page</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-information">
            <use xlink:href="../../ez-icons.svg#information"></use>
        </svg>
        <p class="icon-label">information</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-keyword">
            <use xlink:href="../../ez-icons.svg#keyword"></use>
        </svg>
        <p class="icon-label">keyword</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-landing_page">
            <use xlink:href="../../ez-icons.svg#landing_page"></use>
        </svg>
        <p class="icon-label">landing_page</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-landingpage-add">
            <use xlink:href="../../ez-icons.svg#landingpage-add"></use>
        </svg>
        <p class="icon-label">landingpage-add</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-landingpage-preview">
            <use xlink:href="../../ez-icons.svg#landingpage-preview"></use>
        </svg>
        <p class="icon-label">landingpage-preview</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-languages-add">
            <use xlink:href="../../ez-icons.svg#languages-add"></use>
        </svg>
        <p class="icon-label">languages-add</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-languages">
            <use xlink:href="../../ez-icons.svg#languages"></use>
        </svg>
        <p class="icon-label">languages</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-layout-switch">
            <use xlink:href="../../ez-icons.svg#layout-switch"></use>
        </svg>
        <p class="icon-label">layout-switch</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-lock-unlock">
            <use xlink:href="../../ez-icons.svg#lock-unlock"></use>
        </svg>
        <p class="icon-label">lock-unlock</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-lock">
            <use xlink:href="../../ez-icons.svg#lock"></use>
        </svg>
        <p class="icon-label">lock</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-logout">
            <use xlink:href="../../ez-icons.svg#logout"></use>
        </svg>
        <p class="icon-label">logout</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-maform">
            <use xlink:href="../../ez-icons.svg#maform"></use>
        </svg>
        <p class="icon-label">maform</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-merge">
            <use xlink:href="../../ez-icons.svg#merge"></use>
        </svg>
        <p class="icon-label">merge</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-move">
            <use xlink:href="../../ez-icons.svg#move"></use>
        </svg>
        <p class="icon-label">move</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-notice">
            <use xlink:href="../../ez-icons.svg#notice"></use>
        </svg>
        <p class="icon-label">notice</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-object-state">
            <use xlink:href="../../ez-icons.svg#object-state"></use>
        </svg>
        <p class="icon-label">object-state</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-open-newtab">
            <use xlink:href="../../ez-icons.svg#open-newtab"></use>
        </svg>
        <p class="icon-label">open-newtab</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-open-sametab">
            <use xlink:href="../../ez-icons.svg#open-sametab"></use>
        </svg>
        <p class="icon-label">open-sametab</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-options">
            <use xlink:href="../../ez-icons.svg#options"></use>
        </svg>
        <p class="icon-label">options</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-panels">
            <use xlink:href="../../ez-icons.svg#panels"></use>
        </svg>
        <p class="icon-label">panels</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-pdf-file">
            <use xlink:href="../../ez-icons.svg#pdf-file"></use>
        </svg>
        <p class="icon-label">pdf-file</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-personalize-block">
            <use xlink:href="../../ez-icons.svg#personalize-block"></use>
        </svg>
        <p class="icon-label">personalize-block</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-personalize-content">
            <use xlink:href="../../ez-icons.svg#personalize-content"></use>
        </svg>
        <p class="icon-label">personalize-content</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-personalize">
            <use xlink:href="../../ez-icons.svg#personalize"></use>
        </svg>
        <p class="icon-label">personalize</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-pin-unpin">
            <use xlink:href="../../ez-icons.svg#pin-unpin"></use>
        </svg>
        <p class="icon-label">pin-unpin</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-pin">
            <use xlink:href="../../ez-icons.svg#pin"></use>
        </svg>
        <p class="icon-label">pin</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-portfolio">
            <use xlink:href="../../ez-icons.svg#portfolio"></use>
        </svg>
        <p class="icon-label">portfolio</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-previewed">
            <use xlink:href="../../ez-icons.svg#previewed"></use>
        </svg>
        <p class="icon-label">previewed</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-profile">
            <use xlink:href="../../ez-icons.svg#profile"></use>
        </svg>
        <p class="icon-label">profile</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-publish-later-cancel">
            <use xlink:href="../../ez-icons.svg#publish-later-cancel"></use>
        </svg>
        <p class="icon-label">publish-later-cancel</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-publish-later">
            <use xlink:href="../../ez-icons.svg#publish-later"></use>
        </svg>
        <p class="icon-label">publish-later</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-publish">
            <use xlink:href="../../ez-icons.svg#publish"></use>
        </svg>
        <p class="icon-label">publish</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-refresh">
            <use xlink:href="../../ez-icons.svg#refresh"></use>
        </svg>
        <p class="icon-label">refresh</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-rejected">
            <use xlink:href="../../ez-icons.svg#rejected"></use>
        </svg>
        <p class="icon-label">rejected</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-relations">
            <use xlink:href="../../ez-icons.svg#relations"></use>
        </svg>
        <p class="icon-label">relations</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-restore-parent">
            <use xlink:href="../../ez-icons.svg#restore-parent"></use>
        </svg>
        <p class="icon-label">restore-parent</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-restore">
            <use xlink:href="../../ez-icons.svg#restore"></use>
        </svg>
        <p class="icon-label">restore</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-review">
            <use xlink:href="../../ez-icons.svg#review"></use>
        </svg>
        <p class="icon-label">review</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-roles">
            <use xlink:href="../../ez-icons.svg#roles"></use>
        </svg>
        <p class="icon-label">roles</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-rss">
            <use xlink:href="../../ez-icons.svg#rss"></use>
        </svg>
        <p class="icon-label">rss</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-save">
            <use xlink:href="../../ez-icons.svg#save"></use>
        </svg>
        <p class="icon-label">save</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-schedule">
            <use xlink:href="../../ez-icons.svg#schedule"></use>
        </svg>
        <p class="icon-label">schedule</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-search">
            <use xlink:href="../../ez-icons.svg#search"></use>
        </svg>
        <p class="icon-label">search</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-sections">
            <use xlink:href="../../ez-icons.svg#sections"></use>
        </svg>
        <p class="icon-label">sections</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-settings-block">
            <use xlink:href="../../ez-icons.svg#settings-block"></use>
        </svg>
        <p class="icon-label">settings-block</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-settings-config">
            <use xlink:href="../../ez-icons.svg#settings-config"></use>
        </svg>
        <p class="icon-label">settings-config</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-spinner">
            <use xlink:href="../../ez-icons.svg#spinner"></use>
        </svg>
        <p class="icon-label">spinner</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-stats">
            <use xlink:href="../../ez-icons.svg#stats"></use>
        </svg>
        <p class="icon-label">stats</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-swap">
            <use xlink:href="../../ez-icons.svg#swap"></use>
        </svg>
        <p class="icon-label">swap</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-system-information">
            <use xlink:href="../../ez-icons.svg#system-information"></use>
        </svg>
        <p class="icon-label">system-information</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-tags">
            <use xlink:href="../../ez-icons.svg#tags"></use>
        </svg>
        <p class="icon-label">tags</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-tastes">
            <use xlink:href="../../ez-icons.svg#tastes"></use>
        </svg>
        <p class="icon-label">tastes</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-timeline">
            <use xlink:href="../../ez-icons.svg#timeline"></use>
        </svg>
        <p class="icon-label">timeline</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-trash-empty">
            <use xlink:href="../../ez-icons.svg#trash-empty"></use>
        </svg>
        <p class="icon-label">trash-empty</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-trash-notrashed">
            <use xlink:href="../../ez-icons.svg#trash-notrashed"></use>
        </svg>
        <p class="icon-label">trash-notrashed</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-trash-send">
            <use xlink:href="../../ez-icons.svg#trash-send"></use>
        </svg>
        <p class="icon-label">trash-send</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-trash">
            <use xlink:href="../../ez-icons.svg#trash"></use>
        </svg>
        <p class="icon-label">trash</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-unarchive">
            <use xlink:href="../../ez-icons.svg#unarchive"></use>
        </svg>
        <p class="icon-label">unarchive</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-unpublish-hide">
            <use xlink:href="../../ez-icons.svg#unpublish-hide"></use>
        </svg>
        <p class="icon-label">unpublish-hide</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-unpublish-reveal">
            <use xlink:href="../../ez-icons.svg#unpublish-reveal"></use>
        </svg>
        <p class="icon-label">unpublish-reveal</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-upload">
            <use xlink:href="../../ez-icons.svg#upload"></use>
        </svg>
        <p class="icon-label">upload</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-user">
            <use xlink:href="../../ez-icons.svg#user"></use>
        </svg>
        <p class="icon-label">user</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-user_group">
            <use xlink:href="../../ez-icons.svg#user_group"></use>
        </svg>
        <p class="icon-label">user_group</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-users-personalization">
            <use xlink:href="../../ez-icons.svg#users-personalization"></use>
        </svg>
        <p class="icon-label">users-personalization</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-users-select">
            <use xlink:href="../../ez-icons.svg#users-select"></use>
        </svg>
        <p class="icon-label">users-select</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-versions">
            <use xlink:href="../../ez-icons.svg#versions"></use>
        </svg>
        <p class="icon-label">versions</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-view-custom">
            <use xlink:href="../../ez-icons.svg#view-custom"></use>
        </svg>
        <p class="icon-label">view-custom</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-view-desktop">
            <use xlink:href="../../ez-icons.svg#view-desktop"></use>
        </svg>
        <p class="icon-label">view-desktop</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-view-grid">
            <use xlink:href="../../ez-icons.svg#view-grid"></use>
        </svg>
        <p class="icon-label">view-grid</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-view-hide">
            <use xlink:href="../../ez-icons.svg#view-hide"></use>
        </svg>
        <p class="icon-label">view-hide</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-view-list">
            <use xlink:href="../../ez-icons.svg#view-list"></use>
        </svg>
        <p class="icon-label">view-list</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-view-mobile">
            <use xlink:href="../../ez-icons.svg#view-mobile"></use>
        </svg>
        <p class="icon-label">view-mobile</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-view-tablet">
            <use xlink:href="../../ez-icons.svg#view-tablet"></use>
        </svg>
        <p class="icon-label">view-tablet</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-view">
            <use xlink:href="../../ez-icons.svg#view"></use>
        </svg>
        <p class="icon-label">view</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-wand">
            <use xlink:href="../../ez-icons.svg#wand"></use>
        </svg>
        <p class="icon-label">wand</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-warning">
            <use xlink:href="../../ez-icons.svg#warning"></use>
        </svg>
        <p class="icon-label">warning</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-workflow">
            <use xlink:href="../../ez-icons.svg#workflow"></use>
        </svg>
        <p class="icon-label">workflow</p>
    </div>
</div>

###<div class="mgt-3 header-line">Content types</div>
<div class="wrapper-samples mgt-minus-3">
    <div class="icon-box">
        <svg class="ez-icon ez-icon-about">
            <use xlink:href="../../ez-icons.svg#about"></use>
        </svg>
        <p class="icon-label">about</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-article">
            <use xlink:href="../../ez-icons.svg#article"></use>
        </svg>
        <p class="icon-label">article</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-blog-post">
            <use xlink:href="../../ez-icons.svg#blog_post"></use>
        </svg>
        <p class="icon-label">blog_post</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-blog">
            <use xlink:href="../../ez-icons.svg#blog"></use>
        </svg>
        <p class="icon-label">blog</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-contentlist">
            <use xlink:href="../../ez-icons.svg#contentlist"></use>
        </svg>
        <p class="icon-label">contentlist</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-folder">
            <use xlink:href="../../ez-icons.svg#folder"></use>
        </svg>
        <p class="icon-label">folder</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-gallery">
            <use xlink:href="../../ez-icons.svg#gallery"></use>
        </svg>
        <p class="icon-label">gallery</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-image">
            <use xlink:href="../../ez-icons.svg#image"></use>
        </svg>
        <p class="icon-label">image</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-landing_page">
            <use xlink:href="../../ez-icons.svg#landing_page"></use>
        </svg>
        <p class="icon-label">landing_page</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-media">
            <use xlink:href="../../ez-icons.svg#media"></use>
        </svg>
        <p class="icon-label">media</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-news">
            <use xlink:href="../../ez-icons.svg#news"></use>
        </svg>
        <p class="icon-label">news</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-place">
            <use xlink:href="../../ez-icons.svg#place"></use>
        </svg>
        <p class="icon-label">place</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-places">
            <use xlink:href="../../ez-icons.svg#places"></use>
        </svg>
        <p class="icon-label">places</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-product_list">
            <use xlink:href="../../ez-icons.svg#product_list"></use>
        </svg>
        <p class="icon-label">product_list</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-product">
            <use xlink:href="../../ez-icons.svg#product"></use>
        </svg>
        <p class="icon-label">product</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-wiki-file">
            <use xlink:href="../../ez-icons.svg#wiki-file"></use>
        </svg>
        <p class="icon-label">wiki-file</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-wiki">
            <use xlink:href="../../ez-icons.svg#wiki"></use>
        </svg>
        <p class="icon-label">wiki</p>
    </div>
</div>

###<div class="mgt-3 header-line">Rich Text Editor</div>
<div class="wrapper-samples mgt-minus-3">
    <div class="icon-box">
        <svg class="ez-icon ez-icon-align-center">
            <use xlink:href="../../ez-icons.svg#align-center"></use>
        </svg>
        <p class="icon-label">align-center</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-align-justify">
            <use xlink:href="../../ez-icons.svg#align-justify"></use>
        </svg>
        <p class="icon-label">align-justify</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-align-left">
            <use xlink:href="../../ez-icons.svg#align-left"></use>
        </svg>
        <p class="icon-label">align-left</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-align-right">
            <use xlink:href="../../ez-icons.svg#align-right"></use>
        </svg>
        <p class="icon-label">align-right</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-bold">
            <use xlink:href="../../ez-icons.svg#bold"></use>
        </svg>
        <p class="icon-label">bold</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-custom_tags">
            <use xlink:href="../../ez-icons.svg#custom_tags"></use>
        </svg>
        <p class="icon-label">custom_tags</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-h1">
            <use xlink:href="../../ez-icons.svg#h1"></use>
        </svg>
        <p class="icon-label">h1</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-h2">
            <use xlink:href="../../ez-icons.svg#h2"></use>
        </svg>
        <p class="icon-label">h2</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-h3">
            <use xlink:href="../../ez-icons.svg#h3"></use>
        </svg>
        <p class="icon-label">h3</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-h4">
            <use xlink:href="../../ez-icons.svg#h4"></use>
        </svg>
        <p class="icon-label">h4</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-h5">
            <use xlink:href="../../ez-icons.svg#h5"></use>
        </svg>
        <p class="icon-label">h5</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-h6">
            <use xlink:href="../../ez-icons.svg#h6"></use>
        </svg>
        <p class="icon-label">h6</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-image-center">
            <use xlink:href="../../ez-icons.svg#image-center"></use>
        </svg>
        <p class="icon-label">image-center</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-image-left">
            <use xlink:href="../../ez-icons.svg#image-left"></use>
        </svg>
        <p class="icon-label">image-left</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-image-right">
            <use xlink:href="../../ez-icons.svg#image-right"></use>
        </svg>
        <p class="icon-label">image-right</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-italic">
            <use xlink:href="../../ez-icons.svg#italic"></use>
        </svg>
        <p class="icon-label">italic</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-link-anchor">
            <use xlink:href="../../ez-icons.svg#link-anchor"></use>
        </svg>
        <p class="icon-label">link-anchor</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-link-remove">
            <use xlink:href="../../ez-icons.svg#link-remove"></use>
        </svg>
        <p class="icon-label">link-remove</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-link">
            <use xlink:href="../../ez-icons.svg#link"></use>
        </svg>
        <p class="icon-label">link</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-list-numbered">
            <use xlink:href="../../ez-icons.svg#list-numbered"></use>
        </svg>
        <p class="icon-label">list-numbered</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-list">
            <use xlink:href="../../ez-icons.svg#list"></use>
        </svg>
        <p class="icon-label">list</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-paragraph-add">
            <use xlink:href="../../ez-icons.svg#paragraph-add"></use>
        </svg>
        <p class="icon-label">paragraph-add</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-paragraph">
            <use xlink:href="../../ez-icons.svg#paragraph"></use>
        </svg>
        <p class="icon-label">paragraph</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-quote">
            <use xlink:href="../../ez-icons.svg#quote"></use>
        </svg>
        <p class="icon-label">quote</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-strikethrough">
            <use xlink:href="../../ez-icons.svg#strikethrough"></use>
        </svg>
        <p class="icon-label">strikethrough</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-subscript">
            <use xlink:href="../../ez-icons.svg#subscript"></use>
        </svg>
        <p class="icon-label">subscript</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-superscript">
            <use xlink:href="../../ez-icons.svg#superscript"></use>
        </svg>
        <p class="icon-label">superscript</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-table-add">
            <use xlink:href="../../ez-icons.svg#table-add"></use>
        </svg>
        <p class="icon-label">table-add</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-table-cell">
            <use xlink:href="../../ez-icons.svg#table-cell"></use>
        </svg>
        <p class="icon-label">table-cell</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-table-column">
            <use xlink:href="../../ez-icons.svg#table-column"></use>
        </svg>
        <p class="icon-label">table-column</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-table-row">
            <use xlink:href="../../ez-icons.svg#table-row"></use>
        </svg>
        <p class="icon-label">table-row</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-tag">
            <use xlink:href="../../ez-icons.svg#tag"></use>
        </svg>
        <p class="icon-label">tag</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-twitter">
            <use xlink:href="../../ez-icons.svg#twitter"></use>
        </svg>
        <p class="icon-label">twitter</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-underscore">
            <use xlink:href="../../ez-icons.svg#underscore"></use>
        </svg>
        <p class="icon-label">underscore</p>
    </div>
</div>

###<div class="mgt-3 header-line">Form Builder</div>
<div class="wrapper-samples mgt-minus-3 mgb-5">
    <div class="icon-box">
        <svg class="ez-icon ez-icon-button">
            <use xlink:href="../../ez-icons.svg#button"></use>
        </svg>
        <p class="icon-label">button</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-captcha">
            <use xlink:href="../../ez-icons.svg#captcha"></use>
        </svg>
        <p class="icon-label">captcha</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-checkbox-multiple">
            <use xlink:href="../../ez-icons.svg#checkbox-multiple"></use>
        </svg>
        <p class="icon-label">checkbox-multiple</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-checkbox">
            <use xlink:href="../../ez-icons.svg#checkbox"></use>
        </svg>
        <p class="icon-label">checkbox</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-date">
            <use xlink:href="../../ez-icons.svg#date"></use>
        </svg>
        <p class="icon-label">date</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-dropdown">
            <use xlink:href="../../ez-icons.svg#dropdown"></use>
        </svg>
        <p class="icon-label">dropdown</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-input-hidden">
            <use xlink:href="../../ez-icons.svg#input-hidden"></use>
        </svg>
        <p class="icon-label">input-hidden</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-input-line-multiple">
            <use xlink:href="../../ez-icons.svg#input-line-multiple"></use>
        </svg>
        <p class="icon-label">input-line-multiple</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-input-line">
            <use xlink:href="../../ez-icons.svg#input-line"></use>
        </svg>
        <p class="icon-label">input-line</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-input-number">
            <use xlink:href="../../ez-icons.svg#input-number"></use>
        </svg>
        <p class="icon-label">input-number</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-radio-button-multiple">
            <use xlink:href="../../ez-icons.svg#radio-button-multiple"></use>
        </svg>
        <p class="icon-label">radio-button-multiple</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-radio-button">
            <use xlink:href="../../ez-icons.svg#radio-button"></use>
        </svg>
        <p class="icon-label">radio-button</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-rate">
            <use xlink:href="../../ez-icons.svg#rate"></use>
        </svg>
        <p class="icon-label">rate</p>
    </div>
</div>

###<div class="mgt-3 header-line">eCommerce</div>
<div class="wrapper-samples mgt-minus-3 mgb-5">
    <div class="icon-box">
        <svg class="ez-icon ez-icon-b2b">
            <use xlink:href="../../ez-icons.svg#b2b"></use>
        </svg>
        <p class="icon-label">b2b</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-bestseller">
            <use xlink:href="../../ez-icons.svg#bestseller"></use>
        </svg>
        <p class="icon-label">bestseller</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-cart-upload">
            <use xlink:href="../../ez-icons.svg#cart-upload"></use>
        </svg>
        <p class="icon-label">cart-upload</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-cart-wishlist">
            <use xlink:href="../../ez-icons.svg#cart-wishlist"></use>
        </svg>
        <p class="icon-label">cart-wishlist</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-cart">
            <use xlink:href="../../ez-icons.svg#cart"></use>
        </svg>
        <p class="icon-label">cart</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-catalog">
            <use xlink:href="../../ez-icons.svg#catalog"></use>
        </svg>
        <p class="icon-label">catalog</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-components">
            <use xlink:href="../../ez-icons.svg#components"></use>
        </svg>
        <p class="icon-label">components</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-core">
            <use xlink:href="../../ez-icons.svg#core"></use>
        </svg>
        <p class="icon-label">core</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-customer">
            <use xlink:href="../../ez-icons.svg#customer"></use>
        </svg>
        <p class="icon-label">customer</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-erp">
            <use xlink:href="../../ez-icons.svg#erp"></use>
        </svg>
        <p class="icon-label">erp</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-mail">
            <use xlink:href="../../ez-icons.svg#mail"></use>
        </svg>
        <p class="icon-label">mail</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-newsletter">
            <use xlink:href="../../ez-icons.svg#newsletter"></use>
        </svg>
        <p class="icon-label">newsletter</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-order-management">
            <use xlink:href="../../ez-icons.svg#order-management"></use>
        </svg>
        <p class="icon-label">order-management</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-price">
            <use xlink:href="../../ez-icons.svg#price"></use>
        </svg>
        <p class="icon-label">price</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-rate-review">
            <use xlink:href="../../ez-icons.svg#rate-review"></use>
        </svg>
        <p class="icon-label">rate-review</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-server">
            <use xlink:href="../../ez-icons.svg#server"></use>
        </svg>
        <p class="icon-label">server</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-slider-lastviewed">
            <use xlink:href="../../ez-icons.svg#slider-lastviewed"></use>
        </svg>
        <p class="icon-label">slider-lastviewed</p>
    </div>
    <div class="icon-box">
        <svg class="ez-icon ez-icon-slider">
            <use xlink:href="../../ez-icons.svg#slider"></use>
        </svg>
        <p class="icon-label">slider</p>
    </div>
</div>

!!! note

    Following our design principles and philosophy, expandable and flexible, we provide a few more icons than the ones we are using so that you and your team have the option of customizing your eZ Platform CMS.
