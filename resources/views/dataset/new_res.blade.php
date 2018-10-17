@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
<div class="col-md-12">
    <div class="panel panel-primary" style="padding:20px">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    {!! Form::open(['url' => '/dataset/save','class' => 'form-auth-small', 'method' => 'post','files' => true]) !!}
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-6">
            <button type="button" class="btn btn-block btn-success" style="opacity : 0.5">1. สร้าง ชุดข้อมูล</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-block btn-success">2. เพิ่ม ชุดข้อมูล</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="file" class="control-label">เลือกชนิดของ ทรัพยากร : </label>
                <select class="form-control use-select2" id="file_type" name="file_type">
                    <option value="f">File Upload</option>
                    <option value="w">Web URL</option>
                </select>
            </div>
        </div>

        <div class="col-md-12" id="div-file">
            <div class="form-group">
                <label for="file" class="control-label">ไฟล์ : </label>
                <input class="form-control" type="file" name="file" id="file" onchange="read_filename(this)" required>
            </div>
        </div>

        <div class="col-md-12" id="div-web" style="display: none;">
            <div class="form-group">
                <label for="file" class="control-label">เว็บลิงก์ : </label>
                <input class="form-control" type="url" name="file" id="file" placeholder="Web URL" disabled>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="file_name" class="control-label">ชื่อไฟล์ : </label>
                <input type="text" class="form-control" id="file_name" name="file_name" value="" placeholder="ชื่อไฟล์" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="file_desc" class="control-label">รายละเอียด : </label>
                <textarea class="form-control" id="file_desc" name="file_desc" rows="3" style="resize : none;" required></textarea>
            </div>
        </div>

          <div class="col-md-12 featured-responsive">
                <div class="form-group">
                <label for="file_desc" class="control-label">Metadata : <button type="button" class="btn btn-success metadata_btn" onclick="add_table()"><i class="glyphicon glyphicon-plus"></i></button></label>
               
               
                <table class="table table-bordered" style="text-align:center;background:white">
        <tr>
        <td >Field name</td>
        <td>Description</td>
        <td >Field type</td>
        <td >Unit</td>
        <td >Del</td>
        </tr>
        <tbody id="data_body">
                                    </tbody>
                                    </table>
                                    </div>

         <div class="row">
              

        <!-- <div class="col-md-12">
            <div class="form-group">
                <label for="" class="control-label">Format : </label>
                <select class="form-control use-select2" name="file_format" id="file_format">
                    <option value="">Auto</option>
                    <option value="json">JSON</option>
                    <option value="xlsx">XLSX</option>
                    <option value="xml">XML</option>
                </select>
            </div>
        </div> -->

        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-success">สร้าง ชุดข้อมูล</button>
            <?=link_to('/dataset', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null);?>
        </div>
    </div>
    {!! Form::close() !!}
    </div>
    </div>
</section>
@endsection