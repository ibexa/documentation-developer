# Tabs

We use Tabs component to offer structured views of information to users.

###<div class="mgt-1">Standard tabs</div>
<div class="mgt-2 ez-guidelines-tabs">
[[code_example {html}
<ul class="nav nav-tabs ez-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#ez-tab-location-view-content" role="tab" aria-controls="ez-tab-location-view-content" aria-expanded="1">View</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#ez-tab-location-view-details" role="tab" aria-controls="ez-tab-location-view-details" aria-expanded="1">Details</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#ez-tab-location-view-versions" role="tab" aria-controls="ez-tab-location-view-versions" aria-expanded="1">Versions</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#ez-tab-location-view-locations" role="tab" aria-controls="ez-tab-location-view-locations" aria-expanded="1">Locations</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#ez-tab-location-view-relations" role="tab" aria-controls="ez-tab-location-view-relations" aria-expanded="1">Relations</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#ez-tab-location-view-translations" role="tab" aria-controls="ez-tab-location-view-translations" aria-expanded="1">Translations</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#ez-tab-location-view-urls" role="tab" aria-controls="ez-tab-location-view-urls" aria-expanded="1">URL</a>
    </li>
</ul>
code_example]]
</div>

!!! note
    Standard tabs component will have a darker background, `ez-header`, in the application that will enhance active tab's color contrast.

###<div class="mgt-1">My dashboard tabs</div>
<div class="mgt-2 ez-guidelines-tabs ez-guidelines-tabs--dashboard">
[[code_example {html}
<ul class="nav nav-tabs ez-tabs" role="tablist" id="ez-tab-list-dashboard-my">
    <li class="nav-item">
        <a class="nav-link active" id="ez-tab-label-dashboard-my" data-toggle="tab" href="#ez-tab-dashboard-my-my-drafts" role="tab" aria-controls="ez-tab-dashboard-my-my-drafts" aria-expanded="1">Drafts</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="ez-tab-label-dashboard-my" data-toggle="tab" href="#ez-tab-dashboard-my-my-scheduled" role="tab" aria-controls="ez-tab-dashboard-my-my-scheduled" aria-expanded>My scheduled</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="ez-tab-label-dashboard-my" data-toggle="tab" href="#ez-tab-dashboard-my-my-content" role="tab" aria-controls="ez-tab-dashboard-my-my-content" aria-expanded>Content</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="ez-tab-label-dashboard-my" data-toggle="tab" href="#ez-tab-dashboard-my-my-media" role="tab" aria-controls="ez-tab-dashboard-my-my-media" aria-expanded>Media</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="ez-tab-label-dashboard-my" data-toggle="tab" href="#ez-tab-dashboard-my-my-drafts-under-review" role="tab" aria-controls="ez-tab-dashboard-my-my-drafts-under-review" aria-expanded>Drafts under review</a>
    </li>
</ul>
code_example]]
</div>

!!! note
    Specific styling classes for **My dashboard** tabs component will be applied automatically.
