@extends('master.layout')
@section('title', $title )

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
    {!! Form::open(['url' => '/organization/save','class' => 'form-auth-small', 'method' => 'post','files' => true]) !!}
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="title" class="control-label">หัวข้อ : </label>
                <input type="text" class="form-control" id="ogz_title" name="ogz_title" value="" placeholder="ชื่อ" required>
            </div>
        </div>

        <div class="col-md-12 hidden">
            <div class="form-group">
                <label for="URL" class="control-label">ลิงก์ถาวร : </label>
                <div class="input-group">
                    <span class="input-group-addon">/organization/page/</span>
                    <input type="text" name="ogz_url" id="ogz_url" class="form-control" value="{{ $uniq }}" placeholder="my-organization">
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="description" class="control-label">รายละเอียด : </label>
                <textarea class="form-control" id="ogz_description" name="ogz_description" rows="3" style="resize : none;"></textarea>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="Image" class="control-label">รูปภาพ : </label>
                <input class="form-control" type="file" name="ogz_image" id="ogz_image" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="" class="control-label">สถานะ : </label>
                <select class="form-control use-select2" name="ogz_status" id="ogz_status">
                    <option value="pb">สาธารณะ</option>
                    <option value="pv">ส่วนตัว</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-success">สร้าง หน่วยงาน</button>
            <?= link_to('/organization', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
    {!! Form::close() !!}
    </div>
    </div>
</section>
@endsection
