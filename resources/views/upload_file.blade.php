@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <form action="{{route('post_upload_file')}}" method="post" enctype="multipart/form-data">
        <h3 class="text-center mb-3">Upload File in ChatGPT</h3>
        @csrf
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <label>Only (mp3,mp4,mpeg,mpga,m4a,wav,webm)</label>
        <div class="custom-file">
            <input type="file" name="file" class="custom-file-input" id="chooseFile">
            <label class="custom-file-label" for="chooseFile">Select file</label>
        </div>
        <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
            Upload File
        </button>
    </form>
</div>
@endsection