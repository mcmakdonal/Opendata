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
    {!! Form::open(['url' => '/dataset/save_res','class' => 'form-auth-small', 'method' => 'post','files' => true]) !!}
    @csrf
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
            <input type="hidden" value="{{$slug_url}}" name="slug_url">
            <button type="submit" class="btn btn-success">Add New Resource</button>
            <?= link_to('/dataset/page/'.$slug_url, $title = 'Cancel', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
    {!! Form::close() !!}
</section>
@endsection