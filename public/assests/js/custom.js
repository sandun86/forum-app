$(document).ready(function() {

    var bgElem = $(".home-main-wrapper");
    var docH = $( document ).height();
    bgElem.height(docH);
    $(window).resize(function(event) {
        docH = $( document ).height();
        bgElem.height(docH);
    });


    $('#submitNotify').on('click', function (e) {
        e.preventDefault();
        resetForm();
        var firstName = $.trim($('#firstName').val());
        var lastName = $.trim($('#lastName').val());
        var email = $.trim($('#email').val());
        var fieldErrors = '';
        var isValid = true;

        if(firstName == null || firstName == ''){
            fieldErrors += 'First name is required.<br>';
            $('.first-name').addClass('has-error');
            isValid = false;
        }
        if(firstName != null && firstName != ''){
            if(firstName.length > 100){
                fieldErrors += 'First name should be less than 100 characters.<br>';
                $('.first-name').addClass('has-error');
                isValid = false;
            }
        }
        if(lastName == null || lastName == ''){
            fieldErrors += 'Last name is required.<br>';
            $('.last-name').addClass('has-error');
            isValid = false;
        }
        if(lastName != null && lastName != ''){
            if(lastName.length > 100){
                fieldErrors += 'Last name should be less than 100 characters.<br>';
                $('.last-name').addClass('has-error');
                isValid = false;
            }
        }
        if(email == null || email == ''){
            fieldErrors += 'Email is required.<br>';
            $('.email').addClass('has-error');
            isValid = false;
        }

        if(email != null && email != ''){
            if(email.length > 100){
                fieldErrors += 'Email should be less than 100 characters.<br>';
                $('.email').addClass('has-error');
                isValid = false;
            }else if(!isValidEmailAddress(email)){
                fieldErrors += 'Your email address is invalid. Please enter a valid email.<br>';
                $('.email').addClass('has-error');
                isValid = false;
            }
        }

        if(isValid == false){
            $('.alert-danger').html(fieldErrors);
            $('.alert-danger').css('display', '');
            $('.alert-danger').fadeIn('slow', function() {
                var winH = $(window).height();
                if($(window).width() < 501){
                    docH = $( ".home-wrapper" ).outerHeight();
                    if(winH > docH){
                        docH = winH;
                    }
                    bgElem.height(docH);
                }
            });
            $('.alert-danger').removeClass('hidden');
        }

        if(isValid){
            $(this).attr('disabled', 'disabled');
            $('.loader').removeClass('hidden');
            var dataSet = {
                'first_name': firstName, 'last_name': lastName, 'email': email
            };
            $.ajax({
                url: APP_URL + 'notify',
                type: 'POST',
                dataType: "json",
                data: dataSet
            }).done(function(data) {

                $('.loader').addClass('hidden');
                if(data.message){
                    resetFields();
                    $('.alert-success').html(data.message);
                    $('.alert-success').removeClass('hidden');
                    $('.alert-success').show();
                    $('.alert-success').fadeOut(8000);
                    $('#submitNotify').removeAttr('disabled');
                }
            }).fail(function(data) {
                $('#submitNotify').removeAttr('disabled');
                $('.loader').addClass('hidden');
                var errorText = '';
                if(typeof data.responseJSON.errors.last_name != "undefined"){
                    errorText += data.responseJSON.errors.last_name[0]+"<br>";
                }
                if(typeof data.responseJSON.errors.first_name != "undefined"){
                    errorText += data.responseJSON.errors.first_name[0]+"<br>";
                }
                if(typeof data.responseJSON.errors.email != "undefined"){
                    errorText += data.responseJSON.errors.email[0]+"<br>";
                }

                if(errorText != ''){
                    $('.alert-danger').html(errorText);
                    $('.alert-danger').css('display', '');
                    $('.alert-danger').fadeIn('slow');
                    $('.alert-danger').removeClass('hidden');
                }
            });
        }

    });

    function resetForm(){
        $('.first-name').removeClass('has-error');
        $('.last-name').removeClass('has-error');
        $('.email').removeClass('has-error');
        $('.alert-success').addClass('hidden')
        $('.alert-warning').addClass('hidden')
        $('.alert-danger').addClass('hidden')
        $('.alert-success').text('');
        $('.alert-warning').text('');
        $('.alert-danger').text('');
    }

    function resetFields(){
        $('#firstName').val('');
        $('#lastName').val('');
        $('#email').val('');
    }

    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };
});