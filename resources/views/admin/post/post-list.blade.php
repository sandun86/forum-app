@extends('admin.index')

@section('content')

<!-- Content -->
<div class="panel panel-default">
    <div class="panel-heading">Posts</div>
    <div class="col-md-12" style="padding-top: 15px;">
        <a href="{{ url('admin/post/create') }}" style="cursor:pointer" class="btn btn-info" role="button">Add Post</a>
    </div>
    <div class="panel-body post-list">
        <div class="notifications">
            <div class="alert alert-success hidden" role="alert"></div>
            <div class="alert alert-warning hidden" role="alert"></div>
            <div class="alert alert-danger hidden" role="alert"></div>
        </div>
        <div class="col-md-12">
            <form action="post" method="GET" class="form-horizontal">
                <div class="row">
                    <div class="form-group">
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="term" value=""/>
                        </div>
                        <div class="col-sm-3">
                            <select id="order_by" name="order_by" class="form-control">
                                <option value="">Order By</option>
                                <option value="1">Created date</option>
                                <option value="2">Tag</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>
                    </div>

                </div>
            </form>
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
                    <td style="text-align: center;"><a href="{{ url('admin/post/edit-post/'.$post->id) }}" style="cursor:pointer" class="glyphicon glyphicon-pencil"></a></td>
                    <td style="text-align: center;"><span id="{{ $post->id}}" style="cursor:pointer" class="glyphicon glyphicon-trash delete-post" onclick="return confirm('Are you sure you want to delete this post?');"></span></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="pagination"> {{ $posts->links() }} </div>
    </div>
</div>

@endsection

