(function(global, doc) {
    const MENU_MIN_WIDTH = 300;
    const menu = doc.querySelector('.main_nav');
    const menuResizer = menu.querySelector('.main_nav__resize-handler');
    let resizeStartPositionX = 0;
    let menuCurrentWidth = menu.getBoundingClientRect().width;
    const setCookie = (name, value, maxAgeDays = 356, path = '/') => {
        const maxAge = maxAgeDays * 24 * 60 * 60;

        doc.cookie = `${name}=${value};max-age=${maxAge};path=${path}`;
    };
    const getCookie = (name) => {
        const decodedCookie = decodeURIComponent(doc.cookie);
        const cookiesArray = decodedCookie.split(';');

        const cookieValue = cookiesArray.find((cookie) => {
            const cookieString = cookie.trim();
            const seachingString = `${name}=`;

            return cookieString.indexOf(seachingString) === 0;
        });

        return cookieValue ? cookieValue.split('=')[1] : null;
    };
    const setWidthOfSecondLevelMenu = () => {
        let secondLevelMenuWidth = getCookie('php-api:menu-width');

        if (!secondLevelMenuWidth) {
            return;
        }

        const maxSize = window.innerWidth * 0.4;

        if(secondLevelMenuWidth > maxSize) {
            secondLevelMenuWidth = maxSize;

            setCookie('php-api:menu-width', secondLevelMenuWidth);
        }

        menu.style.width = `${secondLevelMenuWidth}px`;
    };
    const triggerSecondLevelChangeWidth = ({ clientX }) => {
        const resizeValue = menuCurrentWidth + (clientX - resizeStartPositionX);
        const maxSize = window.innerWidth * 0.4;
        const newMenuWidth = Math.min(Math.max(resizeValue, MENU_MIN_WIDTH), maxSize);

        setCookie('php-api:menu-width', newMenuWidth);
        setWidthOfSecondLevelMenu();
    };
    const removeResizeListeners = () => {
        menu.classList.remove('main_nav--resizing');
        doc.body.classList.remove('menu-resizing');
        doc.removeEventListener('mousemove', triggerSecondLevelChangeWidth, false);
        doc.removeEventListener('mouseup', removeResizeListeners, false);
    };
    const addResizeListeners = ({ clientX }) => {
        resizeStartPositionX = clientX;
        menu.classList.add('main_nav--resizing');
        doc.body.classList.add('menu-resizing');
        menuCurrentWidth = menu.getBoundingClientRect().width;

        doc.addEventListener('mousemove', triggerSecondLevelChangeWidth, false);
        doc.addEventListener('mouseup', removeResizeListeners, false);
    };

    menuResizer.addEventListener('mousedown', addResizeListeners, false);
    setWidthOfSecondLevelMenu();
})(window, window.document);
