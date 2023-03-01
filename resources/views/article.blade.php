@extends('marketing::layouts.app')

@section('title', __('Articles | Imported'))

@section('heading')
    {{ __('Article ') }}
@endsection

@section('content')
    <!-- Insert here a partials !-->
    @include('feeds::partials.nav')
    <!-- Cards !-->
    <div class="card">
        <div class="card-table table-responsive p-5">

            <form method="POST" action="{{ route('feeds.article.update', [$article->id]) }}">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $article->title }}">
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="editor" class="form-control" id="content" name="markdown" rows="3">
                        {{ $article->markdown }}
                    </textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
    </div>
    <!---
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://rawgit.com/Grafikart/JS-Markdown-Editor/master/dist/mdeditor.css">

    <script src="https://rawgit.com/Grafikart/JS-Markdown-Editor/master/dist/mdeditor.min.js"></script>

    <script>
        var md = new MdEditor('#editor', {
            uploader: 'http://local.dev/Lab/MdEditor/app/upload.php',
            preview: true,
            images: [
                {id: '1.jpg', url: 'http://lorempicsum.com/futurama/200/200/1'},
                {id: '1.jpg', url: 'http://lorempicsum.com/futurama/200/200/2'},
                {id: '1.jpg', url: 'http://lorempicsum.com/futurama/200/200/3'},
                {id: '1.jpg', url: 'http://lorempicsum.com/futurama/200/200/4'}
            ]
        });
    </script>
    !-->
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
    <script>
        const easyMDE = new EasyMDE({element: document.getElementById('editor')});
    </script>
@endsection
