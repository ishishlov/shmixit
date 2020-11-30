function ajaxSend(url, ajaxParams, callback) {
    $.ajax({
        url: url,
        type: 'POST',
        data: ajaxParams,
        dataType: 'json'
    }).done(function(response) {
        callback(response);
    });
}

function showButtonLoader(object) {
    $(object)
        .attr('disabled', true)
        .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Ждемс...');
}

function hideButtonLoader(object, buttonText) {

}