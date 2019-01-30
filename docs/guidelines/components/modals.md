# Modals

<div>We use modals as components for displaying specific information directly related to the content item currently checked which needs interaction from the user.</div>

##<div class="mgt-3">Introduction</div>
<div class="mgt-minus-3 mgb-5">Right below you have a modal (with interaction removed). This use case contains the three standard elements that we usually add to it: `modal-header`, `modal-body`, and `modal-footer`. All of our modals include a `modal-header`s with dismiss actions as standard best practice. Often (but not always) they also have explicit dismiss action buttons.</div>

!!! note
    The objective of this component is to showcase `modal` structures. Content inside them is representative, but not an accurate representation of a real use case.


**<div class="mgb-3">Modal sample</div>**
<div class="ez-guidelines-modals ez-guidelines-modals__sample mgt-3 mgb-5">
[[code_example {html}
<div class="modal ez-modal ez-modal--send-to-trash" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="ez-icon ez-icon--medium" aria-hidden="true">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#discard"></use>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p class="ez-modal-body__main">Are you sure you want to send this content item to trash?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark">Cancel</button>
                <button type="button" class="btn btn-danger font-weight-bold">Send to trash</button>
            </div>
        </div>
    </div>
</div>
code_example]]
</div>

!!! note
    Remember when combining two buttons together to emphasize the preferred primary action button. We add class `font-weight-bold` for the primary button. Check more in [Buttons - Set of two buttons](buttons.md#set-of-two-buttons).

##<div class="mgt-3 header-line">Send to Trash modals</div>
<div class="mgt-minus-3 mgb-5">Removing and deleting content are important actions in our application. Whereas in the former case the Content item is later retrievable from the Trash, in the second case the Content item is completely erased. Given the significant effects that these actions can have, their purpose have to be highlighted with a specific group of modals.</div>

**<div class="mgb-3">Send to Trash</div>**
<div class="mgt-minus-3 mgb-5">Use it when removing content created by the user that will be sent to Trash.</div>
<div class="ez-guidelines-modals ez-guidelines-modals__send-to-trash mgt-3 mgb-5">
[[code_example {html}
<!-- Button trigger modal -->
<button type="button" class="btn btn-secondary btn-modal-launcher" data-toggle="modal" data-target="#trash-location-modal">Launch Send to Trash modal</button>

<!-- Modal -->
<div class="modal fade ez-modal ez-modal--send-to-trash show" id="trash-location-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="ez-icon ez-icon--medium" aria-hidden="true">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#discard"></use>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <p class="ez-modal-body__main">Are you sure you want to send this content item to trash?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger font-weight-bold">Send to Trash</button>
            </div>
        </div>
    </div>
</div>
code_example]]
</div>

All Send to Trash modals should have the same styling in order to help users quickly identify what the modal's message is about. We don't add `.modal-title` to the header and we position `.modal-footer` set of two buttons to the right.
##<div class="mgt-minus-2"></div>
<div class="ez-guidelines-sample ez-guidelines-sample--images">
![Content structure](../img/UIG_Component_Modal_correct.png)
<div class="ez-guidelines-sample__correct-block">Yes</div>
</div>
##<div class="mgt-minus-2"></div>
<div class="ez-guidelines-sample ez-guidelines-sample--images ez-guidelines-sample-negative">
![Content structure](../img/UIG_Component_Modal_wrong.png)
<div class="ez-guidelines-sample__correct-block ez-guidelines-sample__correct-block-negative">No</div>
</div>

##<div class="mgt-3 header-line">Modals with headers</div>
<div class="mgt-minus-3">We recommend using them when you have to display listed information in tables and you want users to interact with the information contained within that specific table through action buttons (either the whole row or specific buttons). Hence, there is no need to add more interaction buttons, like in `.modal-footer`.</div>

##<div class="mgt-minus-2"></div>
<div class="ez-guidelines-modals ez-guidelines-modals__with-header mgt-3">
[[code_example {html}
<!-- Button trigger modal -->
<button type="button" class="btn btn-secondary btn-modal-launcher" data-toggle="modal" data-target="#view-notifications">Launch modal with header</button>

<!-- Modal -->
<div class="modal fade ez-notifications-modal show" id="view-notifications" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" data-notifications-total="(1)">Notifications </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="ez-icon ez-icon--medium" aria-hidden="true">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#discard"></use>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="ez-notifications-modal__spinner">
                    <svg class="ez-icon ez-icon--medium" aria-hidden="true">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#spinner"></use>
                    </svg>
                </div>
                <div class="ez-notifications-modal__results">
                    <table class="table n-table--notifications">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody class="n-table__body">
                            <tr class="n-notifications-modal__item fw-notification">
                                <td class="n-notifications-modal__type">
                                    <span class="type__icon">
                                        <svg class="ez-icon ez-icon--review">
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#review"></use>
                                        </svg>
                                    </span>
                                    <span class="type__text">
                                        Content review request
                                    </span>
                                </td>
                                <td class="n-notifications-modal__description">
                                    <p class="description__title">
                                        From:
                                        <span class="description__title__item">Administrator user</span>
                                    </p>
                                    <p class="description__text">Can you check this? Thxs!</p>
                                </td>
                                <td class="n-notifications-modal__time">
                                    Sep 13, 2018, 2:58 PM
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
code_example]]
</div>

##<div class="mgt-3 header-line">Modals with headers and footers</div>
<div class="mgt-minus-3">We display them when users need to add or modify specific settings of a content item. This modal includes buttons within its `.modal-footer` due to the need of having an action button that submits changes added or defined.</div>

##<div class="mgt-minus-2"></div>
<div class="ez-guidelines-modals ez-guidelines-modals__with-header-footer mgt-3">
[[code_example {html}
<!-- Button trigger modal -->
<button type="button" class="btn btn-secondary btn-modal-launcher" data-toggle="modal" data-target="#ez-modal--custom-url-alias">Launch modal with header and footer</button>

<!-- Modal -->
<div class="modal fade ez-modal ez-translation show" id="ez-modal--custom-url-alias" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create new translation</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg class="ez-icon ez-icon--medium" aria-hidden="true">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#discard"></use>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <span class="ez-translation__title">Select a language for your new translation</span>
                <div id="add-translation_language" class="ez-translation__language-wrapper">
                    <div class="radio ez-translation__input-wrapper">
                        <label class="ez-translation__label">French</label>
                    </div>
                    <div class="radio ez-translation__input-wrapper">
                        <label class="ez-translation__label">German</label>
                    </div>
                    <div class="radio ez-translation__input-wrapper">
                        <label class="ez-translation__label">Norwegian</label>
                    </div>
                </div>
                <span class="ez-translation__title">Base this translation on an existing translation</span>
                <div id="add-translation_base_language" class="ez-translation__language-wrapper">
                    <div class="radio ez-translation__input-wrapper">
                        <label class="ez-translation__label">English (United Kingdom)</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary font-weight-bold" type="submit" name="custom_url_add[add]" disabled="true">Create</button>
            </div>
        </div>
    </div>
</div>
code_example]]
</div>
