@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
<div class="col-md-12">
    <div class="panel panel-primary"  style="padding: 20px;">
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
                <label for="file" class="control-label">เลือกชนิดของ ทรัพยากร : </label>
                <select class="form-control use-select2" id="file_type" name="file_type">
                    <option value="f" {{ ($get_res[0]->file_type == "f")? "selected" : "" }} >File Upload</option>
                    <option value="w" {{ ($get_res[0]->file_type == "w")? "selected" : "" }} >Web URL</option>
                </select>
            </div>
        </div>

        <div class="col-md-12" id="div-file">
            <div class="form-group">
                <label for="file" class="control-label">ไฟล์ : </label>
                <input class="form-control" type="file" name="file" id="file" onchange="read_filename(this)">
            </div>
        </div>

        <div class="col-md-12" id="div-web" style="display: none;">
            <div class="form-group">
                <label for="file" class="control-label">Web URL : </label>
                <input class="form-control" type="url" name="file" id="file" value="{{ $get_res[0]->file_path }}" placeholder="Web URL" disabled>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="" class="control-label">Path ไฟล์เดิม : </label>
                <input type="text" class="form-control" value="{{ (strpos($get_res[0]->file_path, 'http') !== false)? $get_res[0]->file_path : url('').$get_res[0]->file_path }}" readonly>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="file_name" class="control-label">ชื่อไฟล์ : </label>
                <input type="text" class="form-control" id="file_name" name="file_name" value="{{ $get_res[0]->file_name }}" placeholder="ชื่อ" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="file_desc" class="control-label">รายละเอียดไฟล์ : </label>
                <textarea class="form-control" id="file_desc" name="file_desc" rows="3" style="resize : none;" required>{{ $get_res[0]->file_desc }}</textarea>
            </div>
        </div>

        <!-- <div class="col-md-12">
            <div class="form-group">
                <label for="" class="control-label">Format : </label>
                <select class="form-control use-select2" name="file_format" id="file_format">
                    <option value="" {{ ($get_res[0]->file_format == "")? "selected" : "" }} >Auto</option>
                    <option value="json" {{ ($get_res[0]->file_format == "json")? "selected" : "" }} >JSON</option>
                    <option value="xlsx" {{ ($get_res[0]->file_format == "xlsx")? "selected" : "" }} >XLSX</option>
                    <option value="xml" {{ ($get_res[0]->file_format == "xml")? "selected" : "" }} >XML</option>
                </select>
            </div>
        </div> -->

        <div class="col-md-6">
            <button class="btn btn-danger" type="button" onclick="remove_res(this,'{{$slug_url}}','{{ $get_res[0]->res_id }}')" data="{{ url('/resource/delete') }}">ลบ ทรัพยากร</button>
        </div>

        <div class="col-md-6 text-right">
            <input type="hidden" value="{{ $slug_url }}" name="slug_url">
            <input type="hidden" value="{{ $get_res[0]->file_path }}" name="old_file_path">
            <input type="hidden" value="{{ $get_res[0]->file_ext }}" name="old_file_ext">
            <input type="hidden" value="{{ $get_res[0]->res_id }}" name="res_id">
            <input type="hidden" value="{{ $get_res[0]->dts_id }}" name="dts_id">
            <button type="submit" class="btn btn-success">แก้ไข ทรัพยากร</button>
            <?=link_to('/dataset/page/' . $slug_url, $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null);?>
        </div>
    </div>
    {!! Form::close() !!}
</div>
</div>
</section>
@endsection

@section('script')
change_res(true);
@endsection