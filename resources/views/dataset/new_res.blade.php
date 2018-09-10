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
    {!! Form::open(['url' => '/dataset/save','class' => 'form-auth-small', 'method' => 'post','files' => true]) !!}
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-md-6">
            <button type="button" class="btn btn-block btn-success" style="opacity : 0.5">1. Create dataset</button>
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-block btn-success">2. Add data</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="file" class="control-label">File : </label>
                <input class="form-control" type="file" name="file" id="file" onchange="read_filename(this)" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="file_name" class="control-label">Filename : </label>
                <input type="text" class="form-control" id="file_name" name="file_name" value="" placeholder="ชื่อ" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="file_desc" class="control-label">Description : </label>
                <textarea class="form-control" id="file_desc" name="file_desc" rows="3" style="resize : none;" required></textarea>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="" class="control-label">Format : </label>
                <select class="form-control use-select2" name="file_format" id="file_format">
                    <option value="">Auto</option>
                    <option value="json">JSON</option>
                    <option value="xlsx">XLSX</option>
                    <option value="xml">XML</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-success">Create Dataset</button>
            <?= link_to('/dataset', $title = 'Cancel', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection