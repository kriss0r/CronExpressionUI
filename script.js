jQuery(document).ready(function(){
    jQuery("#input_expression").bind("keyup", validate);
    loadView();
});

function loadView(){
    var input = jQuery("#input_expression");

    jQuery.ajax({
        url: './?view',
        method: 'post',
        data: {expression: input.val()},
        type: 'application/json',
        context: input,
        success: function(response){
            jQuery("#output").html(response.data.output);
        },
        error: function(xhr){
            console.log(xhr);
        },
    })
}

function validate(){
    var input = jQuery("#input_expression");
    input.removeClass('good bad').addClass('pending');
    jQuery.ajax({
        url: './?validate',
        method: 'post',
        data: {expression: input.val()},
        type: 'application/json',
        context: input,
        success: function(response){
            var input = $(this);
            var newClass = response.data.valid ? 'good' : 'bad';
            input.removeClass('pending').addClass(newClass);
            if(response.data.valid)
                loadView();
        },
        error: function(xhr){
            console.log(xhr);
        },
    })
}
