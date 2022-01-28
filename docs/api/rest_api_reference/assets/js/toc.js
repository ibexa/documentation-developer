$(function () {
    const tocRootPositions = document.querySelectorAll('#toc > .navbar-nav > li > .nav-link');

    tocRootPositions.forEach(rootPosition => {
        const arrow = document.createElement('i');
        arrow.classList.add('material-icons', 'nav__link--toggler');
        arrow.innerHTML = 'keyboard_arrow_down';

        rootPosition.append(arrow);
    });

    const navToggler = document.querySelectorAll('.nav__link--toggler');
    navToggler.forEach(toggler => {
        toggler.addEventListener('click', event => {
            event.preventDefault();

            const parentAnchor = event.target.parentNode;
            const subMenu = parentAnchor.nextElementSibling;

            if (!event.target.classList.contains('toggler--rotated')
                && parentAnchor.classList.contains('active')) {
                event.target.classList.toggle('toggler--rotated-0');
                event.target.classList.remove('toggler--rotated');
            } else if(event.target.classList.contains('toggler--rotated')
                && parentAnchor.classList.contains('active')) {
                event.target.classList.add('toggler--rotated-0');
                event.target.classList.remove('toggler--rotated');
            } else {
                event.target.classList.toggle('toggler--rotated');
            }

            if (parentAnchor.classList.contains('active')) {
                subMenu.classList.remove('d-block');
                subMenu.classList.toggle('d-none');
            } else {
                subMenu.classList.remove('d-none');
                subMenu.classList.toggle('d-block');
            }
        });
    });

    $(window).on('activate.bs.scrollspy', function (e, obj) {
        const navBar = document.querySelector('.sidebar__nav');
        const link = navBar.querySelector(`.nav-link[href="${obj.relatedTarget}"]`);
        const activeRootNode = navBar.querySelector('.nav-link.active');

        activeRootNode.childNodes.forEach(childNode => {
            if (typeof childNode.classList !== "undefined"
                && childNode.classList.contains('nav__link--toggler')) {
                childNode.classList.remove('toggler--rotated-0');
            }
        });

        if (activeRootNode.nextElementSibling.classList.contains('d-none')) {
            activeRootNode.nextElementSibling.classList.remove('d-none');
        }

        navBar.scrollTop = link.offsetTop;
    });

    $('body').scrollspy({ target: '#toc' });
})
