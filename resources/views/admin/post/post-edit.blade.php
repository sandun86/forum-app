@extends('admin.index')

@section('content')
<!-- Content -->
<div class="panel panel-default">
    <div class="panel-heading">Post Edit</div>
    <div class="panel-body">
        <form class="form-horizontal add-post-form">                
            <div class="row update-post-form">
                <div class="notifications">
                    <div class="alert alert-success hidden" role="alert"></div>
                    <div class="alert alert-warning hidden" role="alert"></div>
                    <div class="alert alert-danger hidden" role="alert"></div>
                </div>
                <input value="{{ $post->id }}" id="postId" name="postId" hidden>
                <input name="_method" type="hidden" value="PUT">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="title">Title:</label>
                    <div class="col-sm-8 title">
                        <input type="text" class="form-control" id="title" placeholder="Title" value="{{ $post->title}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Description:</label>
                    <div class="col-sm-8 description">
                        <textarea class="form-control" rows="5" id="description" placeholder="Description">{{ $post->description }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="tag">Tag:</label>
                    <div class="col-sm-8 tag">
                        <input type="text" class="form-control" id="tag" placeholder="Tag" value="{{ $post->tag }}">
                    </div>
                </div>

                <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-default" id="updatePost">Update</button>
                    </div>
                 </div>
            </div>
        </form>
    </div>
</div>

@endsection




