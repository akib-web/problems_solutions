function modify_payment_methods_Form(){
    event.preventDefault();
    var form_id = 'modify_payment_methods_Form';
    var route = "{{ route('admin.app_control.edit_payment_methods') }}";
    var getForm = document.getElementById(form_id);
    var formData = new FormData(getForm);

    $.ajax({
        url: route,
        type: 'POST',
        data: formData,
        cache : false,
        processData : false,
        contentType: false,
        beforeSend: function() {
            $('.ajax_loader').html('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(response) {
            console.log(response)
            window.location.reload();
        },
        error: function(xhr) {
            console.log(xhr)
        }
    });
}


<form id="compare_with_others" onsubmit="compare_with_other(this.id)" method="post">
<button type="submit" class="remitBtn compareBtn btnHover">Compare</button>
</form>
function compare_with_other(id){
    event.preventDefault();
    var form_id = id;
    var route = "{{ route('compare_with_others') }}";
    var getForm = document.getElementById(form_id);
    var formData = new FormData(getForm);
    console.log(formData)
    $.ajax({
        url: route,
        type: 'post',
        data: formData,
        cache : false,
        processData : false,
        contentType: false,
        beforeSend: function() {
            $('.ajax_loader').html('<i class="fa fa-spinner fa-spin"></i>');
            $('.error_msg').remove();
        },
        success: function(response) {
            $('.load_compare_data').html(response);
        },
        error: function(xhr) {
            console.log(xhr.responseJSON.errors)
            $.each(xhr.responseJSON.errors,function(key,value){
                // $('[name="'+key+'"]').css('border','1px solid red');
                Notiflix.Notify.Failure(value[0]);
            });
        },
        complete: function(response){
            $('.ajax_loader').html('');
        }
    });
}
