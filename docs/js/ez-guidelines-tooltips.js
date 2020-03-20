$(function () {
    $('[title]').tooltip({
        delay:      {  show: 150, hide: 75 },
        placement:  'bottom',
        template:   `<div class="tooltip ez-tooltip">
                        <div class="arrow ez-tooltip__arrow"></div>
                        <div class="tooltip-inner ez-tooltip__inner"></div>
                    </div>`,
        container:  ".bootstrap-iso"
  });
})
