$(document).ready(function() {

    $('#image-cropper').cropit();

    // In the demos I'm passing in an imageState option
    // so it renders an image by default:
    // $('#image-cropper').cropit({ imageState: { src: { imageSrc } } });

    // Exporting cropped image
    $('.download-btn').click(function() {
        var imageData = $('#image-cropper').cropit('export');
        window.open(imageData);
    });

    $('#addPost').on('click', function(e){
        e.preventDefault();
        resetPostForm();
        var title = $.trim($('#title').val());
        var description = $.trim($('textarea#description').val());
        var tag = $.trim($('#tag').val());
        var fieldErrors = '';
        var isValid = true;

        console.log(description);

        if(title == null || title == ''){
            fieldErrors += 'Title is required.<br>';
            $('.title').addClass('has-error');
            isValid = false;
        }

        if(description == null || description == ""){
            fieldErrors += 'Description is required.<br>';
            $('.description').addClass('has-error');
            isValid = false;
        }

        if(tag == null || tag == ''){
            fieldErrors += 'Tag is required.<br>';
            $('.tag').addClass('has-error');
            isValid = false;
        }

        if(isValid == false){
            $('.add-post-form .alert-danger').html(fieldErrors);
            $('.add-post-form .alert-danger').css('display', '');
            $('.add-post-form .alert-danger').fadeIn('slow');
            $('.add-post-form .alert-danger').removeClass('hidden');
        }
        console.log(getCookie('user-token'));

        if(isValid){
            $(this).attr('disabled', 'disabled');
            $('.loader').removeClass('hidden');
            var dataSet = {
                'title': title,
                'description': description,
                'tag': tag,
                'user_id': getCookie('userId')
            };
            $.ajax({
                url: APP_URL + 'admin/post',
                type: 'POST',
                dataType: "json",
                data: dataSet,
                headers: {
                    'X-Auth-Token': getCookie('adminUserToken'),
                }
            }).done(function(data) {
                if(data.message){
                    resetPostFields();
                    $('.add-post-form .alert-success').html(data.message);
                    $('.add-post-form .alert-success').removeClass('hidden');
                    $('.add-post-form .alert-success').show();
                    $('.add-post-form .alert-success').fadeOut(8000);
                    $('#addPost').removeAttr('disabled');
                    setTimeout(function(){
                       window.location.reload(1);
                    }, 1000);
                }
            }).fail(function(data) {
                $('#addPost').removeAttr('disabled');
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
                    $('.add-post-form .alert-danger').html(errorText);
                    $('.add-post-form .alert-danger').css('display', '');
                    $('.add-post-form .alert-danger').fadeIn('slow');
                    $('.add-post-form .alert-danger').removeClass('hidden');
                }
            });
        }
    });

    $('.delete-post').on('click', function(e){
        e.preventDefault();
        var thisId = $(this).attr('id');
        $.ajax({
                url: APP_URL + 'admin/post/'+thisId,
                type: 'DELETE',
                dataType: "json",
                headers: {
                    'X-Auth-Token': getCookie('adminUserToken'),
                },
        }).done(function(data) {

            $('.loader').addClass('hidden');
            if(data.message){
                $('.post-list .alert-success').html(data.message);
                $('.post-list .alert-success').removeClass('hidden');
                $('.post-list .alert-success').show();
                $('.post-list .alert-success').fadeOut(8000);
                setTimeout(function(){
                   window.location.reload(1);
                }, 1000);
            }
        }).fail(function(data) {
            var errorText = data.message;

            if(errorText != ''){
                $('.post-list .alert-danger').html(data.message);
                $('.post-list .alert-danger').css('display', '');
                $('.post-list .alert-danger').fadeIn('slow');
                $('.post-list .alert-danger').removeClass('hidden');
            }
        });
    });

    $('#updatePost').on('click', function(e){
        e.preventDefault();
        resetPostForm();
        var id = $.trim($('#postId').val());
        var title = $.trim($('#title').val());
        var description = $.trim($('textarea#description').val());
        var tag = $.trim($('#tag').val());
        var fieldErrors = '';
        var isValid = true;

        console.log(description);

        if(title == null || title == ''){
            fieldErrors += 'Title is required.<br>';
            $('.title').addClass('has-error');
            isValid = false;
        }

        if(description == null || description == ""){
            fieldErrors += 'Description is required.<br>';
            $('.description').addClass('has-error');
            isValid = false;
        }

        if(tag == null || tag == ''){
            fieldErrors += 'Tag is required.<br>';
            $('.tag').addClass('has-error');
            isValid = false;
        }

        if(isValid == false){
            $('.update-post-form .alert-danger').html(fieldErrors);
            $('.update-post-form .alert-danger').css('display', '');
            $('.update-post-form .alert-danger').fadeIn('slow');
            $('.update-post-form .alert-danger').removeClass('hidden');
        }
        console.log(getCookie('user-token'));

        if(isValid){
            $(this).attr('disabled', 'disabled');
            var dataSet = {
                'title': title,
                'description': description,
                'tag': tag
            };
            $.ajax({
                url: APP_URL + 'admin/post/'+id,
                type: 'PUT',
                dataType: "json",
                data: dataSet,
                headers: {
                    'X-Auth-Token': getCookie('adminUserToken'),
                },
            }).done(function(data) {

                if(data.message){
                    $('.update-post-form .alert-success').html(data.message);
                    $('.update-post-form .alert-success').removeClass('hidden');
                    $('.update-post-form .alert-success').show();
                    $('.update-post-form .alert-success').fadeOut(8000);
                    $('#updatePost').removeAttr('disabled');
                    setTimeout(function(){
                       window.location.reload(1);
                    }, 1000);
                }
            }).fail(function(data) {
                $('#updatePost').removeAttr('disabled');
                var errorText = '';
                if(typeof data.responseJSON.errors.email != "undefined"){
                    errorText += data.responseJSON.errors.email[0]+"<br>";
                }
                if(typeof data.responseJSON.errors.password != "undefined"){
                    errorText += data.responseJSON.errors.password[0]+"<br>";
                }

                if(errorText != ''){
                    $('.update-post-form .alert-danger').html(errorText);
                    $('.update-post-form .alert-danger').css('display', '');
                    $('.update-post-form .alert-danger').fadeIn('slow');
                    $('.update-post-form .alert-danger').removeClass('hidden');
                }
            });
        }
    });

    function resetPostFields(){
        $('#title').val('');
        $('#description').val('');
        $('#tag').val('');
    }

    function resetPostForm(){
        $('.title').removeClass('has-error');
        $('.description').removeClass('has-error');
        $('.tag').removeClass('has-error');
        $('.add-post-form .alert-success').addClass('hidden')
        $('.add-post-form .alert-warning').addClass('hidden')
        $('.add-post-form .alert-danger').addClass('hidden')
        $('.add-post-form .alert-success').text('');
        $('.add-post-form .alert-warning').text('');
        $('.add-post-form .alert-danger').text('');
    }
});
