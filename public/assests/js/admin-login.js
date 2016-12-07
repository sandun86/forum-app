$(document).ready(function() {

    $('#adminLoginSubmit').on('click', function(e){
        e.preventDefault();
        resetLoginForm();
        var email = $.trim($('#email').val());
        var password = $.trim($('#password').val());
        var fieldErrors = '';
        var isValid = true;

        if(email == null || email == ''){
            fieldErrors += 'Email is required.<br>';
            $('.email').addClass('has-error');
            isValid = false;
        }

        if(email != null && email != ''){
            if(!isValidEmailAddress(email)){
                fieldErrors += 'Your email address is invalid. Please enter a valid email.<br>';
                $('.email').addClass('has-error');
                isValid = false;
            }
        }

        if(password == null || password == ''){
            fieldErrors += 'Password is required.<br>';
            $('.password').addClass('has-error');
            isValid = false;
        }

        if(isValid == false){
            $('.alert-danger').html(fieldErrors);
            $('.alert-danger').css('display', '');
            $('.alert-danger').fadeIn('slow');
            $('.alert-danger').removeClass('hidden');
        }

        if(isValid){
            $(this).attr('disabled', 'disabled');
            var dataSet = {
                'email': email,
                'password': password
            };
            $.ajax({
                url: APP_URL + 'admin/login',
                type: 'POST',
                dataType: "json",
                data: dataSet
            }).done(function(data) {

                $('.loader').addClass('hidden');
                if(data){
                    setCookie("adminUserToken", data.data.token);
                    setCookie("adminUserName", data.data.first_name);
                    setCookie("adminUserId", data.data.id);

                    window.location.href = APP_URL+'admin/dashboard';

                }
            }).fail(function(data) {
                $('#adminLoginSubmit').removeAttr('disabled');
                var errorText =  data.responseJSON.message;
                console.log(errorText);
                if(errorText != ''){
                    $('.alert-danger').html(errorText);
                    $('.alert-danger').css('display', '');
                    $('.alert-danger').fadeIn('slow');
                    $('.alert-danger').removeClass('hidden');
                }
            });
        }
    });



    function resetLoginForm(){
        $('.email').removeClass('has-error');
        $('.password').removeClass('has-error');
        $('.login-form .alert-success').addClass('hidden')
        $('.login-form .alert-warning').addClass('hidden')
        $('.login-form .alert-danger').addClass('hidden')
        $('.login-form .alert-success').text('');
        $('.login-form .alert-warning').text('');
        $('.login-form .alert-danger').text('');
    }

    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    };
});