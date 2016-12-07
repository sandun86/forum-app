@extends('admin.index')

@section('content')
<!-- Content -->
<div class="panel panel-default">
    <div class="panel-body">
        <form class="form-horizontal add-user-form">                
            <div class="row update-user-form">
                <div class="notifications">
                    <div class="alert alert-success hidden" role="alert"></div>
                    <div class="alert alert-warning hidden" role="alert"></div>
                    <div class="alert alert-danger hidden" role="alert"></div>
                </div>
                <input value="{{ $user->id }}" id="userId" name="userId" hidden>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="title">First name:</label>
                    <div class="col-sm-8 first_name">
                        <input type="text" class="form-control" id="firstName" placeholder="First name" value="{{ $user->first_name}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Last name:</label>
                    <div class="col-sm-8 last_name">
                        <input type="text" class="form-control" id="lastName" placeholder="Last name" value="{{ $user->last_name }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Email:</label>
                    <div class="col-sm-8 email">
                        <input type="text" class="form-control" id="email" disabled="true" placeholder="Email" value="{{ $user->email }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="tag">Password:</label>
                    <div class="col-sm-8 password">
                        <input type="password" class="form-control" id="password" placeholder="Password" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="tag">Confirm password:</label>
                    <div class="col-sm-8 confirm-password">
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password" value="">
                    </div>
                </div>

                <div class="form-group"> 
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-default" id="updateUser">Update</button>
                    </div>
                 </div>
            </div>
        </form>
    </div>
</div>

@endsection




