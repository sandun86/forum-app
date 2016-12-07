@extends('index')

@section('content')
<!-- Content -->
<div class="panel panel-default">
    @foreach($posts as $post)
        <div class="panel-body">
            <div class="span12">
                <a href="" title="{{ $post->title }}">{{ $post->title }}</a><br>
                <small style="font-size:85%;">{{ $post->full_name }}  by <a href="">{{ $post->created_at }}</a></small>
                <br>
                {{ $post->description }}

                <br>
                <a href="" title="Similiar ply"><small>Similiar to</small></a>

            </div><br>
        </div>
    @endforeach
</div>
<div class="pagination"> {{ $posts->links() }} </div>

@endsection

