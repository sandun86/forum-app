@extends('admin.index')

@section('content')
<!-- Content -->
<div class="panel panel-default">
    <h3>Users</h3><br>
    <a href="{{ url('admin/user/create') }}" style="cursor:pointer" class="">Add User</a>
    <div class="panel-body user-list">
        <div class="notifications">
            <div class="alert alert-success hidden" role="alert"></div>
            <div class="alert alert-warning hidden" role="alert"></div>
            <div class="alert alert-danger hidden" role="alert"></div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Create Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                    <td style="text-align: center;"><a href="{{ url('admin/user/edit-user/'.$user->id) }}" style="cursor:pointer" class="glyphicon glyphicon-pencil"></a></td>
                    <td style="text-align: center;"><span id="{{ $user->id}}" style="cursor:pointer" class="glyphicon glyphicon-trash delete-user" onclick="return confirm('Are you sure you want to delete this user?');"></span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {{ $users->links() }} </div>
    </div>
</div>

@endsection

