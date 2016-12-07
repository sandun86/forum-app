$(document).ready(function() {
    activeMenu();

    $('#signUp').on('click', function(e){
        e.preventDefault();
        $('#signUpModal').modal('show');
    });

    $('#signUpSubmit').on('click', function(e){
        e.preventDefault();
        resetForm();
        var firstName = $.trim($('#firstName').val());
        var lastName = $.trim($('#lastName').val());
        var email = $.trim($('#email').val());
        var password = $.trim($('#password').val());
        var confirmPassword = $.trim($('#confirmPassword').val());
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

        if(password == null || password == ''){
            fieldErrors += 'Password is required.<br>';
            $('.password').addClass('has-error');
            isValid = false;
        }

        if(password != null && password != ''){
            if(password.length < 6){
                fieldErrors += 'The password must be at least 6 characters.<br>';
                $('.email').addClass('has-error');
                isValid = false;
            }
        }

        if(confirmPassword == null || confirmPassword == ''){
            fieldErrors += 'Confirm password is required.<br>';
            $('.confirm-password').addClass('has-error');
            isValid = false;
        }

        if(confirmPassword != null && confirmPassword != ''){
            if(confirmPassword.length < 6){
                fieldErrors += 'The confirm password must be at least 6 characters.<br>';
                $('.confirm-password').addClass('has-error');
                isValid = false;
            }
        }

        if(confirmPassword !== password){
            fieldErrors += 'Password confirmation does not match.<br>';
            $('.confirm-password').addClass('has-error');
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
            $('.loader').removeClass('hidden');
            var dataSet = {
                'first_name': firstName,
                'last_name': lastName,
                'email': email,
                'password': password,
                'confirm_password': confirmPassword
            };
            $.ajax({
                url: APP_URL + 'user',
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
                    $('#signUpSubmit').removeAttr('disabled');
                }
            }).fail(function(data) {
                $('#signUpSubmit').removeAttr('disabled');
                $('.loader').addClass('hidden');
                var errorText = '';
                if(data.responseJSON.errors){                   
                    if(typeof data.responseJSON.errors.last_name != "undefined"){
                        errorText += data.responseJSON.errors.last_name[0]+"<br>";
                    }
                    if(typeof data.responseJSON.errors.first_name != "undefined"){
                        errorText += data.responseJSON.errors.first_name[0]+"<br>";
                    }
                    if(typeof data.responseJSON.errors.email != "undefined"){
                        errorText += data.responseJSON.errors.email[0]+"<br>";
                    }
                    if(typeof data.responseJSON.errors.password != "undefined"){
                        errorText += data.responseJSON.errors.password[0]+"<br>";
                    }
                    if(typeof data.responseJSON.errors.confirm_password != "undefined"){
                        errorText += data.responseJSON.errors.confirm_password[0]+"<br>";
                    }
                }
                
                if(data.responseJSON.message){
                    errorText += data.responseJSON.message + "<br>";
                }

                if(data.message){
                    errorText += data.message+ "<br>";
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

    $('#login').on('click', function(e){
        e.preventDefault();
        $('#loginModal').modal('show');
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
                if(data.responseJSON.errors){  
                    if(typeof data.responseJSON.errors.email != "undefined"){
                        errorText += data.responseJSON.errors.email[0]+"<br>";
                    }
                    if(typeof data.responseJSON.errors.password != "undefined"){
                        errorText += data.responseJSON.errors.password[0]+"<br>";
                    }
                }

                if(data.responseJSON.message){
                    errorText += data.responseJSON.message + "<br>";
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

    $('#logOut').on('click', function(e){
        e.preventDefault();

        $.ajax({
            url: APP_URL + 'user/logout',
            type: 'POST',
            dataType: "json",
        }).done(function(data) {
            console.log(data);
            if(data){
                $.removeCookie('userToken', { path: '/' });
                $.removeCookie('userName', { path: '/' });
                $.removeCookie('userId', { path: '/' });
                setTimeout(function(){
                   window.location.reload(1);
                }, 2000);
            }
        }).fail(function(data) {

        });
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

    function resetForm(){
        $('.first-name').removeClass('has-error');
        $('.last-name').removeClass('has-error');
        $('.email').removeClass('has-error');
        $('.password').removeClass('has-error');
        $('.confirm-password').removeClass('has-error');
        $('.login-form .alert-success').addClass('hidden')
        $('.login-form .alert-warning').addClass('hidden')
        $('.login-form .alert-danger').addClass('hidden')
        $('.login-form .alert-success').text('');
        $('.login-form .alert-warning').text('');
        $('.login-form .alert-danger').text('');
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


    function activeMenu()
    {
        if(getCookie('userToken')){
            $('.sign-up').addClass('hidden');
            $('.logged-name').show();
            $('.user-name').html(getCookie('userName'));
            $('.log-out').removeClass('hidden');
            $('.log-in').addClass('hidden');
            $('.add-post').removeClass('hidden');
            $('.my-posts').removeClass('hidden');
        }else{
            $('.add-post').addClass('hidden');
            $('.sign-up').removeClass('hidden');
            $('.log-in').removeClass('hidden');
        }
    }
});