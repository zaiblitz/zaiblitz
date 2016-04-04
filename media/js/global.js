
function validateForm(div) {
    var errorCount = 0;
    var valid = true;
    div.find('input').filter(':visible').each( function(){
        var e = $(this);
        if(!e.val()) {
            errorCount++;
        }
    });
    if(errorCount > 0) {
        valid = false;
        toastr.error(ERROR_MSG.FORM_FIELDS_REQUIRED)
    }
    return valid;
}

function buttonLoadStart(btn, text) {
    if(text) {
        btn.html("<i class='fa fa-refresh fa-spin'></i> " + text);
    } else {
        btn.html("<i class='fa fa-refresh fa-spin'></i>");
    }
    btn.prop("disabled", true);
}

function buttonLoadEnd(btn, text) {
    btn.html(text);
    btn.prop("disabled", false);
}

function validateEmail(email) {
    var regEx = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return regEx.test(email);
}



var ERROR_MSG = {
   'FORM_FIELDS_REQUIRED'     : ' All fields are required.',
   'IMAGE' : {
       'INVALID_EXT'    : 'Invalid File Type',
       'FILE_EXCEED'    : 'File size is above the limit'
   }
};

