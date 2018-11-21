// tmp fix for read-the-docs embeded versions injection
let jquery = jQuery;

$(document).ready(function () {
    $(document).on("click", "[data-toggle='rst-current-version']", function() {
        $('.rst-other-versions').toggle();
    });

    // replace edit url
    var branchName = 'master',
        branchNameRegexp = /\/en\/([a-z0-9-_.]*)\//g.exec(document.location.href);

    if (branchNameRegexp !== null && branchNameRegexp.hasOwnProperty(1) && branchNameRegexp[1].length) {
        branchName = branchNameRegexp[1];
    }

    $('.md-content a.md-icon').each(function() {
        $(this).attr('href', $(this).attr('href').replace('master/docs/', branchName + '/docs/'));
    });

    if (!/^\d+\.\d+$/.test(branchName) && branchName !== 'latest') {
        branchName = 'master';
    }

    if (typeof window.doc_version_warning !== 'undefined') {
        var doc_version_warning = window.doc_version_warning,
            warningMessage = '';

        if ($.inArray(branchName, doc_version_warning.previous_lts) !== -1) {
            warningMessage = 'You are viewing documentation for an older Long-Term Support release. The latest LTS release is <span class="version">' + doc_version_warning.lts[0] + '</span>.';
        }

        if ($.inArray(branchName, doc_version_warning.ft) !== -1) {
            warningMessage = 'You are viewing documentation for an older Fast Track release. The latest release is <span class="version">' + doc_version_warning.latest[0] + '</span>.';
        }

        if ($.inArray(branchName, doc_version_warning.dev) !== -1) {
            warningMessage = 'You are viewing documentation for a development version. The latest stable release is <span class="version">' + doc_version_warning.latest[0] + '</span>.';
        }

        if (warningMessage) {
            $("article").prepend($(
                '<div class="md-typeset admonition caution version-warning"> ' +
                '<p class="admonition-title">Version warning</p> ' +
                '<p> ' + warningMessage + '</p>' +
                '</div>'
            ));
        }
    }

    // remove elements, leave only 'versions'
    var update = setInterval(function() {
        if ($('.injected .rst-versions').length) {
            clearInterval(update);
            $('.rst-current-version span:first').html(' Change version');
            $('.rst-other-versions').html($('.injected dl:first').clone());
            $('.injected').remove();

            //replace url in version switcher
            var currentVersion = $('.rst-other-versions strong dd a').attr('href'),
                resourceUrl = document.location.href.replace(currentVersion, '');

            $('.rst-other-versions dd a').each( function() {
                $(this).attr('href', $(this).attr('href') + resourceUrl);
            });

            if ($('.version-warning').length) {
                var version = $('.version-warning .version').html(),
                    url = $('.rst-other-versions dd a').first().attr('href').replace('latest', version);

                $('.version-warning .version').html($('<a href ="' + url + '" class="external">' + version + '</a>'));
            }
        }
    }, 300);

    $('img').each(function() {
        if ($(this).attr('title')) {
            $(this).wrap( "<figure></figure>" );
            $(this).after( "<figcaption>" + $(this).attr('title') + "</figcaption>" );
        }
    });

    $('.md-content a:not(.md-icon):not(.md-source)').filter(function() {
        return this.hostname && this.hostname !== location.hostname;
    }).addClass("external");

    docsearch({
        apiKey: 'bfb5bd7cad971d31ef8be599174334f3',
        indexName: 'ezplatform',
        inputSelector: '#search_input',
        algoliaOptions: {
            'facetFilters': ["lang:en", "version:" + branchName],
            'hitsPerPage': 10
        },
        debug: false
    });

    $(document).on("keypress", "#search_input", function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });

    $("#search_input, label.md-search__icon").on("click", function() {
        var toggle = document.querySelector("[data-md-toggle=search]");
        toggle.checked = true;
    });

    // Image enlargement modal
    $(".md-content img:not(.card-img-top)").click( function(){
        $('#enlargedImage').attr('src', $(this).attr('src'));
        if ($(this).attr('title')) {
            $('#modalCaption').html($(this).attr('title'));
        }
        $('#imageModal').show();
    });

    $("#imageModal").click(function(){ $(this).hide() });

});
