$(document).ready(function() {
    $('#adminLogOut').on('click', function(e){
        e.preventDefault();
        var dataSet = {
            'admin_id': getCookie('adminUserId'),
        };

        $.ajax({
            url: APP_URL + 'admin/logout',
            type: 'POST',
            dataType: "json",
            data: dataSet
        }).done(function(data) {
            console.log(data);
            if(data){
                $.removeCookie('adminUserToken', { path: '/admin' });
                $.removeCookie('adminUserName', { path: '/admin' });
                $.removeCookie('adminUserId', { path: '/admin' });
                
                window.location.href = APP_URL+'admin/login';
                setTimeout(function(){
                   window.location.reload(1);
                }, 2000);
            }
        }).fail(function(data) {

        });
    });

    $('#loginSubmit').on('click', function(e){
        e.preventDefault();
        resetLoginForm();
        var email = $.trim($('#loginEmail').val());
        var password = $.trim($('#loginPassword').val());
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
            $('.login-form .alert-danger').html(fieldErrors);
            $('.login-form .alert-danger').css('display', '');
            $('.login-form .alert-danger').fadeIn('slow');
            $('.login-form .alert-danger').removeClass('hidden');
        }

        if(isValid){
            $(this).attr('disabled', 'disabled');
            $('.loader').removeClass('hidden');
            var dataSet = {
                'email': email,
                'password': password
            };
            $.ajax({
                url: APP_URL + 'user/login',
                type: 'POST',
                dataType: "json",
                data: dataSet
            }).done(function(data) {

                $('.loader').addClass('hidden');
                if(data.message){
                    setCookie("userToken", data.data.token);
                    setCookie("userName", data.data.first_name);
                    setCookie("userId", data.data.id);
                    resetFields();
                    $('.login-form .alert-success').html(data.message);
                    $('.login-form .alert-success').removeClass('hidden');
                    $('.login-form .alert-success').show();
                    $('.login-form .alert-success').fadeOut(8000);
                    $('#loginSubmit').removeAttr('disabled');
                    setTimeout(function(){
                       window.location.reload(1);
                    }, 1000);
                }
            }).fail(function(data) {
                $('#loginSubmit').removeAttr('disabled');
                $('.loader').addClass('hidden');
                var errorText = '';
                if(typeof data.responseJSON.errors.email != "undefined"){
                    errorText += data.responseJSON.errors.email[0]+"<br>";
                }
                if(typeof data.responseJSON.errors.password != "undefined"){
                    errorText += data.responseJSON.errors.password[0]+"<br>";
                }

                if(errorText != ''){
                    $('.login-form .alert-danger').html(errorText);
                    $('.login-form .alert-danger').css('display', '');
                    $('.login-form .alert-danger').fadeIn('slow');
                    $('.login-form .alert-danger').removeClass('hidden');
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