<!DOCTYPE html>
<html>
    <head>
        <title>Forum - Admin</title>
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content=""/>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="{{ URL::asset('assests/libs/bootstrap/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ URL::asset('assests/css/style.css') }}" />
        <style type="text/css">
            body {
                padding-top: 20px;
                padding-bottom: 20px;
            }

            span.hover {
                cursor: pointer;
            }
        </style>
        <script type="text/javascript">
            var APP_URL = "<?php echo URL::to('/'); ?>/";
        </script>
    </head>
	<div class="container">
	 	<h2>Admin Login</h2>
		<form class="form-horizontal">
			<div class="form-group">
			    <div class="notifications">
                    <div class="alert alert-success hidden" role="alert"></div>
                    <div class="alert alert-warning hidden" role="alert"></div>
                    <div class="alert alert-danger hidden" role="alert"></div>
                </div>
			  	<label class="control-label col-sm-2" for="email">Email:</label>
			  	<div class="col-sm-8 email">
			    	<input type="email" class="form-control" id="email" placeholder="Enter email">
			  	</div>
			</div>
		    
		    <div class="form-group">
		      	<label class="control-label col-sm-2" for="pwd">Password:</label>
		      	<div class="col-sm-8 password">          
		        	<input type="password" class="form-control" id="password" placeholder="Enter password">
		      	</div>
		    </div>
		    
		    <div class="form-group">        
		      <div class="col-sm-offset-2 col-sm-10">
		        <button type="submit" class="btn btn-default" id="adminLoginSubmit">Login</button>
		      </div>
		    </div>
		</form>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
{{--    <script type="text/javascript" src="{{ URL::asset('assests/js/custom.js') }}"></script>--}}
    <script type="text/javascript" src="{{ URL::asset('assests/js/common.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assests/js/admin-login.js') }}"></script>

	</body>
</html>
