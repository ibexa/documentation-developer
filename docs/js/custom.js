// tmp fix for read-the-docs embeded versions injection
let jquery = jQuery;

$(document).ready(function() {
    // replace edit url
    var branchName = 'master',
        branchNameRegexp = /\/en\/([a-z0-9-_.]*)\//g.exec(document.location.href);

    if (branchNameRegexp !== null && branchNameRegexp.hasOwnProperty(1) && branchNameRegexp[1].length) {
        branchName = branchNameRegexp[1];
    }

    $('.md-content a.md-icon').each(function() {
        $(this).attr(
            'href',
            $(this)
                .attr('href')
                .replace('master/docs/', branchName + '/docs/')
        );
    });

    if (!/^\d+\.\d+$/.test(branchName) && branchName !== 'latest') {
        branchName = 'master';
    }

    // Add version pill to top of navigation
    $('#site-name').append('<span class="pill">' + branchName + '</span>');

    $('.rst-current-version.switcher__label').html(branchName);

    // Change navigation icons on onclick
    $('.md-nav--primary .md-nav__item--nested .md-nav__link').click(function() {
        $(this).addClass('open');
    });

    // remove elements, leave only 'versions'
    var update = setInterval(function() {
        if ($('.injected .rst-versions').length) {
            clearInterval(update);
            var version = $('.rst-other-versions dd.rtd-current-item a').text();
            $('.rst-current-version span:first').html(' ' + (version != '' ? version : 'Change version'));
            $('.rst-other-versions').html($('.injected dl:first').clone());
            $('.injected').remove();

            //replace url in version switcher
            var currentVersion = $('.rst-other-versions dd.rtd-current-item a').attr('href'),
                resourceUrl = document.location.href.replace(currentVersion, '');

            $('.rst-other-versions dd a').each(function() {
                $(this).attr('href', $(this).attr('href') + resourceUrl);
            });

            if ($('.version-warning').length) {
                var url,
                    version = $('.version-warning .version').html(),
                    parts = $('.rst-other-versions dd a')
                        .first()
                        .attr('href')
                        .split('/');

                parts[4] = version;
                url = parts.join('/');

                $('.version-warning .version').html($('<a href ="' + url + '" class="external">' + version + '</a>'));
            }
        }
    }, 300);

    $('img').each(function() {
        if ($(this).attr('title')) {
            $(this).wrap('<figure></figure>');
            $(this).after('<figcaption>' + $(this).attr('title') + '</figcaption>');
        }
    });

    $('.md-content a:not(.md-icon):not(.md-source)')
        .filter(function() {
            return this.hostname && this.hostname !== location.hostname;
        })
        .addClass('external');

    docsearch({
        container: '.md-search',
        appId: '2DNYOU6YJZ',
        apiKey: '21ce3e522455e18e7ee16cf7d66edb4b',
        indexName: 'ezplatform',
        transformItems: function(items) {
            let removedPattern = '¶';
            $.each(items, function(index, item) {
                for (let lvl=2; lvl<=6; lvl++) {
                    if (null !== item.hierarchy['lvl'+lvl]) {
                        items[index].hierarchy['lvl' + lvl] = item.hierarchy['lvl' + lvl].replace(removedPattern, '');
                    }
                    if ('undefined' !== typeof item._highlightResult.hierarchy['lvl'+lvl]) {
                        items[index]._highlightResult.hierarchy['lvl'+lvl].value = item._highlightResult.hierarchy['lvl'+lvl].value.replace(removedPattern, '');
                    }
                    if ('undefined' !== typeof item._snippetResult.hierarchy['lvl'+lvl]) {
                        items[index]._snippetResult.hierarchy['lvl'+lvl].value = item._snippetResult.hierarchy['lvl'+lvl].value.replace(removedPattern, '');
                    }
                }
            });

            return items;
        },
        searchParameters: {
            facetFilters: ['lang:en', 'version:' + branchName],
            hitsPerPage: 10,
        },
        debug: false,
    });

    $(document).on('keypress', '#search_input', function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });

    $(document).on('blur', '#search_input', function(event) {
        setTimeout(() => {
            $('#search_input').val('');
        }, 0);
    });

    $('#search_input, label.md-search__icon').on('click', function() {
        var toggle = document.querySelector('[data-md-toggle=search]');
        toggle.checked = true;
    });

    // Image enlargement modal
    $('body').append('<div id="imageModal"><img class="modal-content" id="enlargedImage"><div id="modalCaption"></div>/div>');

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
});
