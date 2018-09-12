@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    {!! Form::open(['url' => '/resource/update','class' => 'form-auth-small', 'method' => 'put','files' => true]) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="file" class="control-label">File : </label>
                <input class="form-control" type="file" name="file" id="file" onchange="read_filename(this)">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="" class="control-label">File old : </label>
                <input type="text" class="form-control" value="{{ $get_res[0]->file_name }}" readonly>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="file_name" class="control-label">Filename : </label>
                <input type="text" class="form-control" id="file_name" name="file_name" value="{{ $get_res[0]->file_name }}" placeholder="ชื่อ" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="file_desc" class="control-label">Description : </label>
                <textarea class="form-control" id="file_desc" name="file_desc" rows="3" style="resize : none;" required>{{ $get_res[0]->file_desc }}</textarea>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="" class="control-label">Format : </label>
                <select class="form-control use-select2" name="file_format" id="file_format">
                    <option value="" {{ ($get_res[0]->file_format == "")? "selected" : "" }} >Auto</option>
                    <option value="json" {{ ($get_res[0]->file_format == "json")? "selected" : "" }} >JSON</option>
                    <option value="xlsx" {{ ($get_res[0]->file_format == "xlsx")? "selected" : "" }} >XLSX</option>
                    <option value="xml" {{ ($get_res[0]->file_format == "xml")? "selected" : "" }} >XML</option>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <button class="btn btn-danger" type="button" onclick="remove_res(this,'{{$slug_url}}','{{ $get_res[0]->res_id }}')" data="{{ url('/resource/delete') }}">Delete Resource</button>
        </div>

        <div class="col-md-6 text-right">
            <input type="hidden" value="{{ $slug_url }}" name="slug_url">
            <input type="hidden" value="{{ $get_res[0]->file_path }}" name="old_file_path">
            <input type="hidden" value="{{ $get_res[0]->file_ext }}" name="old_file_ext">
            <input type="hidden" value="{{ $get_res[0]->res_id }}" name="res_id">
            <button type="submit" class="btn btn-success">Update Resource</button>
            <?=link_to('/dataset/page/' . $slug_url, $title = 'Cancel', ['class' => 'btn btn-warning'], $secure = null);?>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection