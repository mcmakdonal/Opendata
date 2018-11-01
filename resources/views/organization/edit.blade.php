@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
    <div class="col-md-12">
        <div class="panel panel-primary"  style="padding: 20px;">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a data-toggle="tab" href="#edit"><span class="lnr lnr-pencil"></span> แก้ไข </a></li>
                <li><a data-toggle="tab" href="#datasets"><span class="lnr lnr-cloud-download"></span> {{ Define::DTS }} </a></li>
                <div class="text-right">
                    <a href="{{url('/organization/page/'.$slug_url)}}">
                        <button type="submit" class="btn btn-primary"><span class="lnr lnr-eye"></span> ดู {{ Define::OGZ }}</button>
                    </a>
                </div>
            </ul>

            <div class="tab-content">
                <div id="edit" class="tab-pane fade in active">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {!! Form::open(['url' => '/organization/update','class' => 'form-auth-small', 'method' => 'put','files' => true]) !!}
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title" class="control-label">ชื่อ {{ Define::OGZ }} : </label>
                                <input type="text" class="form-control" id="ogz_title" name="ogz_title" value="{{ $content[0]->ogz_title }}" placeholder="ชื่อ {{ Define::OGZ }}" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="URL" class="control-label">ลิงก์ถาวร : </label>
                                <div class="input-group">
                                    <span class="input-group-addon">/organization/page/</span>
                                    <input type="text" name="ogz_url" id="ogz_url" value="{{ $content[0]->ogz_url }}" class="form-control" placeholder="my-organization" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" class="control-label">รายละเอียด : </label>
                                <textarea class="form-control" id="ogz_description" name="ogz_description" rows="3" style="resize : none;">{{ $content[0]->ogz_description }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Image" class="control-label">รูปภาพ : </label>
                                <input class="form-control" type="file" name="ogz_image" id="ogz_image">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Image" class="control-label">รูปภาพ : </label>
                                <img src="{{ url($content[0]->ogz_image) }}" class="img-responsive" style="width: 120px;">
                                <input type="hidden" value="{{$content[0]->ogz_image}}" name="ogz_old_image">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="" class="control-label">สถานะ : </label>
                                <select class="form-control use-select2" name="ogz_status" id="ogz_status">
                                    <option value="pb" {{ ($content[0]->ogz_status == "pb")? "selected" : "" }} >สาธารณะ</option>
                                    <option value="pv" {{ ($content[0]->ogz_status == "pv")? "selected" : "" }} >ส่วนตัว</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <button type="button" class="btn btn-danger" onclick="remove_ogz(this,'{{$slug_url}}')" data="{{ url('/organization/delete') }}" >ลบ {{ Define::OGZ }}</button>
                        </div>

                        <div class="col-md-6 text-right">
                            <input type="hidden" value="{{ $slug_url }}" name="slug_url">
                            <button type="submit" class="btn btn-success">บันทึก {{ Define::OGZ }}</button>
                            <?=link_to('/organization', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null);?>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>

                <div id="datasets" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 10px;">
                            <?= link_to('/dataset/new?ogz='.$slug_url, $title = 'เพิ่ม ' . Define::DTS , ['class' => 'btn btn-primary'], $secure = null); ?>
                            <input type="hidden" value="{{ $content[0]->ogz_id }}" id="organization_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered ogz-dts">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th><button type="button" class="btn btn-block" onclick="set_status_dts('pb')"><i class="fa fa-eye" aria-hidden="true"></i> ทำให้เป็น สาธารณะ </button></th>
                                        <th><button type="button" class="btn btn-block" onclick="set_status_dts('pv')"><i class="fa fa-eye-slash" aria-hidden="true"></i> ทำให้เป็น ส่วนตัว </button></th>
                                        <th><button type="button" class="btn btn-block btn-danger" onclick="set_status_dts('del')"><i class="fa fa-chain-broken" aria-hidden="true"></i> ลบ </button></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="row">
                                <ul id="pagination_ogz" class="pagination pull-right"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
get_dts_data();
@endsection