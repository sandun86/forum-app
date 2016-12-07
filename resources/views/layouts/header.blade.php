<!DOCTYPE html>
<html>
    <head>
        <title>Forum</title>
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
    <body>

    <div class="container">

        <!-- Static navbar -->
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Forum</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-left">
                        <li><a href="{{ url('post') }}">Posts</a></li>
                        <li class="add-post hidden"><a href="{{ url('post/create') }}">Add Post</a></li>
                        <li class="my-posts hidden"><a href="{{ url('post/my-posts') }}">My Posts</a></li>                     
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="sign-up hidden"><a href="" id="signUp">Sign Up</a></li>
                        <li class="log-in hidden"><a href="" id="login">Log in</a></li>
                        <li class="logged-name"><a href="" class="user-name"></a></li>
                        <li class="hidden log-out"><a href="" id="logOut">Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
        
        @yield('content')
    </div>


    <!-- Sign Up Modal -->
    <div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="signUpModal">Sign up</h4>
                </div>
                <div class="modal-body">
                    <div class="notifications">
                        <div class="alert alert-success hidden" role="alert"></div>
                        <div class="alert alert-warning hidden" role="alert"></div>
                        <div class="alert alert-danger hidden" role="alert"></div>
                    </div>
                    <div class="form-group first-name">
                        <input class="form-control" type="text" id="firstName" name="firstName" placeholder="First name">
                    </div>
                    <div class="form-group last-name">
                        <input class="form-control" type="text" id="lastName" name="lastName" placeholder="Last name">
                    </div>
                    <div class="form-group email">
                        <input class="form-control" type="text" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group password">
                        <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                    </div>
                    <div class="form-group confirm-password">
                        <input class="form-control" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="signUpSubmit">Sign up</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="loginModal">Login</h4>
                </div>
                <div class="modal-body login-form">
                    <div class="notifications">
                        <div class="alert alert-success hidden" role="alert"></div>
                        <div class="alert alert-warning hidden" role="alert"></div>
                        <div class="alert alert-danger hidden" role="alert"></div>
                    </div>
                    <div class="form-group email">
                        <input class="form-control" type="text" id="loginEmail" name="loginEmail" placeholder="Email">
                    </div>
                    <div class="form-group password">
                        <input class="form-control" type="password" id="loginPassword" name="loginPassword" placeholder="Password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="loginSubmit">Login</button>
                </div>
            </div>
        </div>
    </div>

