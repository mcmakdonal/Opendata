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
    {!! Form::open(['url' => '/dataset/pre_new_resource','class' => 'form-auth-small', 'method' => 'post','files' => true]) !!}
    @csrf
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-6">
                <button type="button" class="btn btn-block btn-success">1. Create dataset</button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-block btn-success" style="opacity : 0.5">2. Add data</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="title" class="control-label">Title : </label>
                    <input type="text" class="form-control" id="title" name="title" value="" placeholder="ชื่อ" required>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="URL" class="control-label">Url : </label>
                    <div class="input-group">
						<span class="input-group-addon">/dataset/page/</span>
						<input type="text" name="url" id="url" class="form-control" placeholder="my-dataset">
					</div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="description" class="control-label">Description : </label>
                    <textarea class="form-control" id="description" name="description" rows="3" style="resize : none;"></textarea>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="" class="control-label">License : </label>
                    <select class="form-control use-select2" name="lcs_id" id="lcs_id" required>
                        @foreach($get_lcs as $k => $v)
                            <option value="{{ $v->lcs_id }}">{{ $v->license }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="" class="control-label">Organization : </label>
                    <select class="form-control use-select2" name="ogz_id" id="ogz_id" required>
                        @foreach($get_ogz as $k => $v)
                            <option value="{{ $v->ogz_id }}" {{ ($v->url == $lock_ogz)? "selected" : "" }} >{{ $v->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="" class="control-label">สถานะ : </label>
                    <select class="form-control use-select2" name="status" id="status">
                        <option value="pb">Public</option>
                        <option value="pv">Private</option>
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