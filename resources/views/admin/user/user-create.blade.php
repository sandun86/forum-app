@extends('admin.index')

@section('content')
<!-- Content -->
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal add-user-form">                
            <div class="row">
                <div class="notifications">
                    <div class="alert alert-success hidden" role="alert"></div>
                    <div class="alert alert-warning hidden" role="alert"></div>
                    <div class="alert alert-danger hidden" role="alert"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="title">First name:</label>
                    <div class="col-sm-8 first-name">
                        <input type="text" class="form-control" id="firstName" placeholder="First name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="title">Last name:</label>
                    <div class="col-sm-8 last-name">
                        <input class="form-control" type="text" id="lastName" name="lastName" placeholder="Last name">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="title">Email:</label>
                    <div class="col-sm-8 email">
                        <input class="form-control" type="text" id="email" name="email" placeholder="Email">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="title">Password:</label>
                    <div class="col-sm-8 password">
                        <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="title">Confirm password:</label>
                    <div class="col-sm-8 confirm-password">
                        <input class="form-control" type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm password">
                    </div>
                </div>
                
                <div class="form-group"> 
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="button" class="btn btn-default" id="createUser">Create User</button>
                    </div>
                 </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection




