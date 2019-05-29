$('.btn-modal-launcher').on("click", function (e) {
    $('div').attr('data-backdrop', 'true');
    
    $('#trash-location-modal').addClass('modal-backdrop');
    $('#view-notifications').addClass('modal-backdrop');
    $('#ez-modal--custom-url-alias').addClass('modal-backdrop');
});
