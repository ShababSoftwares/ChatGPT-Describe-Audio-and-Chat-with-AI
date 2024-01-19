@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <h3 class="text-center mb-3">Uploaded Files List</h3>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <div class="clearfix"></div>
    <table  class="table">
        <thead class="thead-dark">
            <tr>
                <th width="5%" scope="col">File.#</th>
                <th width="20%" scope="col">File</th>
                <th width="50%" scope="col">Translation</th>
                <th width="25%" scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if($uploaded_files->isNotEmpty())
            @foreach($uploaded_files as $key=>$uploaded_file)
            <tr id="row_{{$uploaded_file->id}}">
                <th scope="row">{{++$key}}</th>
                <td>
                    <audio controls>
                        <source src="{!! url($uploaded_file->file_path) !!}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                </td>
                <td>{!! substr($uploaded_file->transcript,0,200).'...' !!}</td>
                <td>
                    <a href="{{route('ask_questions',$uploaded_file->id)}}" class="btn btn-info btn-sm">Ask Questions</a>
                    <a href="javascript:void(0)" onclick="delete_file_chat({{$uploaded_file-> id}})" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="4">No Records Found!</td>
            </tr>
            @endif
        </tbody>
    </table> 
</div>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function delete_file_chat(file_id) {
    if (confirm('Are you sure you want to delete this file?')) {
        $.ajax({
            url: "{{route('delete_file_chat')}}",
            type: "post",
            dataType: 'json',
            data: {file_id: file_id},
            success: function (respObj) {
                if (respObj.status == 'done') {
                    setTimeout(
                        function () {
                            $('#row_' + file_id).html('');
                        }, 500);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
}
</script>
@endsection