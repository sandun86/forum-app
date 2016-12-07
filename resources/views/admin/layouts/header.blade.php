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
                    <a class="navbar-brand" href="{{ url('admin/dashboard') }}">Admin Panel</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav nav-left">
                        <li><a href="{{ url('admin/post') }}">Posts</a></li>
                        <li class=""><a href="{{ url('admin/users') }}">Users</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="admin-logged-name"><a href="" class="admin-user-name"></a></li>
                        <li class="admin-log-out"><a href="" id="adminLogOut">Logout</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div><!--/.container-fluid -->
        </nav>
        
        @yield('content')
    </div>


