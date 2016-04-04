/*
 * @author Merwin Domingo
 * Jquery Ajax
 */

// create ajax parser - 3rd parameter is optional
function ajax( url, post_data, loader ) {
    return $.ajax({
        type: 'POST',
        beforeSend:loader,
        url: url,
        data: post_data
    });
}

// serialize form
function serialize_form( form_id ) {
    return $('#' + form_id).serialize();
}

// serialize form data with request id
function ajax_data( request_action, form_id ) {
    var form = $('#' + form_id).serialize();
    var data = {
        'reqid': request_action
    }
    post_data = form + '&' + $.param(data);
    return post_data;
}


