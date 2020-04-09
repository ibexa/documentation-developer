# Badges

We use badges to signify important information for users in the UI.

##<div class="mgt-3 header-line">Badge with icon</div>

###<div class="mgt-minus-2"></div>
**<div class="mgt-minus-5 mgb-3">Badge with icon</div>**
[[code_example {html wrap='div' class='ez-guidelines-badges mgt-3'}
<span class="badge badge-warning ez-badge">
    <svg class="ez-icon ez-icon--small">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#warning"></use>
    </svg>
    Development
</span>
code_example]]

###<div class="mgt-minus-2"></div>
**<div class="mgb-3">Contextual variations</div>**
[[code_example {html wrap='div' class='ez-guidelines-badges ez-guidelines-badges--sample mgt-3'}
<span class="badge badge-info ez-badge">GPL</span>
<span class="badge badge-warning ez-badge">
    <svg class="ez-icon ez-icon--small">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#warning"></use>
    </svg>
    Development
</span>
<span class="badge badge-danger ez-badge">
    <svg class="ez-icon ez-icon--small">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#warning"></use>
    </svg>
    Trial
</span>
code_example]]

##<div class="mgt-3 header-line">Small badges</div>

###<div class="mgt-minus-2"></div>
**<div class="mgt-minus-5 mgb-3">Small badges</div>**
[[code_example {html wrap='div' class='ez-guidelines-badges'}
<span class="badge badge-secondary ez-badge ez-badge--small">Draft</span>
code_example]]

###<div class="mgt-minus-2"></div>
**<div class="mgb-3">Contextual variations</div>**
[[code_example {html wrap='div' class='ez-guidelines-badges'}
<span class="badge badge-secondary ez-badge ez-badge--small">Draft</span>
<span class="badge badge-secondary ez-badge ez-badge--small">Quick review</span>
<span class="badge badge-secondary ez-badge ez-badge--small">Publish</span>
<span class="badge badge-warning ez-badge ez-badge--small">VIEWING</span>
code_example]]

###<div class="mgt-minus-2"></div>
**<div class="mgb-3">Contextual variations - Editing view specific case</div>**
[[code_example {html wrap='div' class='ez-guidelines-badges--sample-contextual'}
<div class="ez-details-items">
<span class="ez-details-items__connector">Editing:</span>
<span class="ez-badge ez-badge--small ez-details-items__pill ez-details-items__pill--content-type">
    <svg class="ez-icon ez-icon--small">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#article"></use>
    </svg>
    Article
</span>
<span class="ez-details-items__connector ez-details-items__connector--small">in</span>
<span class="ez-badge ez-badge--small ez-details-items__pill ez-details-items__pill--language">English (United Kingdom)</span>
<span class="ez-details-items__connector ez-details-items__connector--small">under</span>
<span class="ez-badge ez-badge--small ez-details-items__pill ez-details-items__pill--location">Home</span>
</div>
code_example]]
