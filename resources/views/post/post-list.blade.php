@extends('index')

@section('content')
<!-- Content -->
<div class="panel panel-default">
    <h3>Your Posts</h3>
    <div class="panel-body post-list">
        <div class="notifications">
            <div class="alert alert-success hidden" role="alert"></div>
            <div class="alert alert-warning hidden" role="alert"></div>
            <div class="alert alert-danger hidden" role="alert"></div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Tag</th>
                    <th>Create Date</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->description }}</td>
                    <td>{{ $post->tag }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td style="text-align: center;"><a href="{{ url('post/edit-post/'.$post->id) }}" style="cursor:pointer" class="glyphicon glyphicon-pencil"></a></td>
                    <td style="text-align: center;"><span id="{{ $post->id}}" style="cursor:pointer" class="glyphicon glyphicon-trash delete-post" onclick="return confirm('Are you sure you want to delete this post?');"></span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {{ $posts->links() }} </div>
    </div>
</div>
@endsection

