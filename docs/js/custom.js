// tmp fix for read-the-docs embedded versions injection
let jquery = jQuery;

$(document).ready(function() {
    // replace edit url
    let branchName = 'master';
    const branchNameRegexp = /\/en\/([a-z0-9-_.]*)\//g.exec(document.location.href);
    const eolVersions = window.eol_versions ?? [];

    if (branchNameRegexp !== null && branchNameRegexp.hasOwnProperty(1) && branchNameRegexp[1].length) {
        branchName = branchNameRegexp[1];
    }

    // Show warning box for versions that have reached End Of Life
    if (eolVersions.includes(branchName)) {
        const warningBox = document.querySelector('#eol-warning-box');

        warningBox.hidden = false;
    }

    if (!/^\d+\.\d+$/.test(branchName) && branchName !== 'latest') {
        branchName = 'master';
    }

    // Insert version into header links
    $('.md-header a.md-logo, #site-name > a').each(function() {
        $(this).attr(
            'href',
            $(this)
                .attr('href')
                .replace(/\/en\/[^\/]+\//, '/en/' + branchName + '/'),
        );
    });

    // Add version pill to top of navigation
    $('#site-name').append('<span class="pill pill--inline">' + branchName + '</span>');

    $('.rst-current-version.switcher__label').html(branchName);

    // Change navigation icons on onclick
    $('.md-nav--primary .md-nav__item--nested .md-nav__link').click(function() {
        $(this).addClass('open');
    });

    // remove elements, leave only 'versions'
    var update = setInterval(function() {
        let ready = false, version = '';
        if ($('readthedocs-flyout').length) {
            $('dl.versions', $('readthedocs-flyout').prop('shadowRoot')).prependTo('.version-switcher .switcher__list');
            $('readthedocs-flyout').remove();
            version = $('.switcher__list dl.versions dd strong a').text();
            ready = true;
        }
        if (ready) {
            clearInterval(update);

            if (!$('.rst-versions.switcher__selected-item').length) {
                // add rst-current-version back (what removed it??)
                $('.switcher.version-switcher').prepend(`
                    <div class="rst-versions switcher__selected-item" data-toggle="rst-versions" role="note" aria-label="versions">
                        <div class="rst-current-version switcher__label" data-toggle="rst-current-version">
                        Version
                        </div>
                    </div>
                `);
            }
            $('.rst-current-version.switcher__label').html(version.length ? version : 'Change version');
            $('.rst-other-versions.switcher__list dl.versions dd strong').parent().addClass('rtd-current-item');

            if ('latest' !== (vl = $('.rst-other-versions.switcher__list dl.versions')).find('dd:first').text()) {
                vl.find('dd').each(function() {
                    $(this).detach().prependTo(vl);
                });
            }

            const allVersions = [...document.querySelectorAll('.switcher__list .versions dd')];
            const olderVersions = document.querySelector('#older-versions');

            if (eolVersions.length > 0) {
                olderVersions.hidden = false;
            }

            allVersions
                .filter((versionNode) => eolVersions.includes(versionNode.textContent))
                .forEach((versionNode) => {
                    versionNode.hidden = true;
                });

            olderVersions.addEventListener('click', (event) => {
                event.stopPropagation();
                allVersions.forEach((versionNode) => {
                    versionNode.hidden = false;
                });
                olderVersions.hidden = true;
            });
        }
    }, 300);
    setTimeout(function() {
        clearInterval(update);
        setSwitcherEvents();
    }, 1200);

    $('img').each(function() {
        if ($(this).attr('title')) {
            $(this).wrap('<figure></figure>');
            $(this).after('<figcaption>' + $(this).attr('title') + '</figcaption>');
        }
    });

    $('.md-content a:not(.md-icon):not(.md-source):not(.instantsearch__entry)')
        .filter(function() {
            return this.hostname && this.hostname !== location.hostname;
        })
        .addClass('external');

    const hitsPerPage = 10;
    let search = docsearch({
        container: '#docsearch',
        appId: '2DNYOU6YJZ',
        apiKey: '21ce3e522455e18e7ee16cf7d66edb4b',
        indexName: 'ezplatform',
        inputSelector: '#search_input',
        transformData: function(hits) {
            let link = $('.ds-dropdown-menu a.search-page-link');
            if (!link.length) {
                $('.ds-dropdown-menu').append(`<div class="search-page-link-wrapper">
                    <a class="search-page-link" href="">See more results</a>
                </div>`);
                link = $('.ds-dropdown-menu a.search-page-link');
            }
            const href = '/en/' + branchName + '/search_results/?sq=' + encodeURI($('#search_input').val()) + '&p=1';
            link.attr('href', href).toggle(hits.length >= hitsPerPage);
        },
        algoliaOptions: {
            facetFilters: ['lang:en', 'version:' + branchName],
            hitsPerPage: hitsPerPage,
        },
        handleSelected: function(input, event, suggestion, datasetNumber, context) {
            if (context.selectionMethod == 'click') {
                window.location = suggestion.url;
            } else if (context.selectionMethod == 'enterKey') {
                window.location = $('.ds-dropdown-menu a.search-page-link').attr('href');
            }
        },
        debug: false,
    });
    search.autocomplete.on('autocomplete:updated', event => {
        $('.ds-cursor').removeClass('ds-cursor');
        const searchedText = $('#search_input')[0].value.trim();
        const separatorText = '›';
        const separatorClass = 'aa-suggestion-title-separator';
        const separatorHtml = '<span class="' + separatorClass + '" aria-hidden="true"> ' + separatorText + ' </span>';
        $('.algolia-docsearch-suggestion--wrapper').each((index, element) => {
            const title = $(element).find('.algolia-docsearch-suggestion--title');
            const category = $(element).find('.algolia-docsearch-suggestion--subcategory-column-text');
            category.append(separatorHtml);
            if (title.find('.' + separatorClass).length) {
                const titleParts = title.html().split(separatorHtml);
                for (let i = 0; i < titleParts.length - 1; i++) {
                    category.html(category.html() + titleParts[i] + separatorHtml);
                }
                title.html(titleParts[titleParts.length - 1]);
            }
            if (separatorText != category.text().trim().slice(-1)) {
                category.append(separatorHtml);
            }
            const displayedText = $(element).find('.algolia-docsearch-suggestion--text');
            if (displayedText.length && displayedText.text() == searchedText + '…') {
                displayedText.remove();
            }
        });
    });

    $(document).on('keydown keypress', 'form.md-search__form', function(event) {
        if (-1 != $.inArray(event.key, ['Enter', 'ArrowDown', 'ArrowUp'])) {
            event.preventDefault();
            $('.ds-cursor').removeClass('ds-cursor');

            return false;
        }
    });

    $('#search_input, label.md-search__icon').on('click', function() {
        var toggle = document.querySelector('[data-md-toggle=search]');
        toggle.checked = true;
    });

    // Image enlargement modal
    $('body').append('<div id="imageModal"><img class="modal-content" id="enlargedImage"><div id="modalCaption"></div>/div>');

    //Google Tag Manager code
    $('body').prepend('<!-- Google Tag Manager (noscript) --><noscript><iframe src=https://www.googletagmanager.com/ns.html?id=GTM-KKQR5LG height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript><!-- End Google Tag Manager (noscript) -->');

    $('.md-content__inner img').click(function() {
        $('#enlargedImage').attr('src', $(this).attr('src'));
        if ($(this).attr('title')) {
            $('#modalCaption').html($(this).attr('title'));
        }
        $('#imageModal').show();
    });

    $('#imageModal').click(function() {
        $(this).hide();
    });

    if ($('.md-sidebar--primary .md-sidebar__scrollwrap')[0] && $('.md-sidebar--primary .md-nav__item--active:not(.md-nav__item--nested)')[0]) {
        $('.md-sidebar--primary .md-sidebar__scrollwrap')[0].scrollTop =
            $('.md-sidebar--primary .md-nav__item--active:not(.md-nav__item--nested)')[0].offsetTop - 33;
    }

    $(document).scroll(function() {
        if ($('.md-sidebar--secondary .md-nav__link--active').length) {
            $('.md-sidebar--secondary .md-nav__link--active')[0].scrollIntoView({
                behavior: 'instant',
                block: 'nearest',
            });
        } else {
            $('.md-sidebar--secondary .md-sidebar__scrollwrap').scrollTop(0);
        }
    });

    $('.md-sidebar.md-sidebar--secondary nav a').click(function(event) {
        window.setTimeout(function() {
            $('.md-sidebar--secondary .md-nav__link--active').removeClass('md-nav__link--active');
            $(event.target).addClass('md-nav__link--active');
            $(document).scroll();
            // Fix page TOC/hash bug
            document.location.hash = event.target.hash;
        }, 500);
    });

    document.querySelectorAll('.notification__close-btn').forEach((closeBtn) => {
        closeBtn.addEventListener('click', () => {
            closeBtn.closest('.notification').setAttribute('hidden', 'hidden');
        });
    });

    // Mark higher-level nodes with "New" pill, not only the actual item
    $('.pill--new:not([hidden])').parents('.md-nav__item').children('label').children('.pill--new[hidden]').removeAttr('hidden');
});
