@extends('master.layout') 
@section('title', $title ) 
@section('header', $header ) 
@section('content')
<section class="">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary box_gradient" style="padding-top:10px;padding-bottom: 10px;">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif {!! Form::open(['url' => '/datamanagement','class' => 'form-auth-small', 'method' => 'post','files' => true]) !!}
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ep_title" class="control-label">ชื่อ ชุดข้อมูล : </label>
                            <input type="text" class="form-control" id="ep_title" name="ep_title" value="" placeholder="ชื่อ ชุดข้อมูล" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ep_scope_geo" class="control-label">ขอบเขตภูมิศาสตร์ : </label>
                            <input type="text" class="form-control" id="ep_scope_geo" name="ep_scope_geo" value="" placeholder="ขอบเขตภูมิศาสตร์" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ep_view" class="control-label">Database : </label>
                            <select class="form-control use-select2" name="ep_view" id="ep_view" required>
                                    @foreach($view->data as $k => $v)
                                        <option value="{{ $v->view }}">{{ $v->view }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">หน่วยงาน : </label>
                            <select class="form-control use-select2" name="ogz_id" id="ogz_id" required>
                                    @foreach($get_ogz as $k => $v)
                                        <option value="{{ $v->ogz_id }}">{{ $v->ogz_title }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">หมวดหมู่ : </label>
                            <select class="form-control use-select2" name="cat_id" id="cat_id" required>
                                    @foreach($get_cat as $k => $v)
                                        <option value="{{ $v->cat_id }}" >{{ $v->cat_title }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ep_status" class="control-label">สถานะ : </label>
                            <select class="form-control use-select2" name="ep_status" id="ep_status" required>
                                    <option value="pb">สาธารณะ</option>
                                    <option value="pv">ส่วนตัว</option>
                                </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lcs_id" class="control-label">การอนุญาต : </label>
                            <select class="form-control use-select2" name="lcs_id" id="lcs_id" required>
                                    @foreach($get_lcs as $k => $v)
                                        <option value="{{ $v->lcs_id }}">{{ $v->license }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dts_tag" class="control-label">ชนิตไฟล์ : </label>
                            <select name="ep_file[]" class="form-control use-select2" multiple="multiple" required>
                                    <option value="xls">xls</option>
                                    <option value="csv">csv</option>
                                    <option value="xml">xml</option>
                                    <option value="json">json</option>
                                    <option value="rdf">rdf</option>
                                </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ep_contact_name" class="control-label">ชื่อผู้ใช้ข้อมูล : </label>
                            <input type="text" class="form-control" id="ep_contact_name" name="ep_contact_name" value="" placeholder="ชื่อผู้ใช้ข้อมูล"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ep_contact_email" class="control-label">อีเมลผู้ให้ข้อมูล : </label>
                            <input type="email" class="form-control" id="ep_contact_email" name="ep_contact_email" value="" placeholder="อีเมลผู้ให้ข้อมูล"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ep_description" class="control-label">รายละเอียด : </label>
                            <textarea class="form-control" id="ep_description" name="ep_description" rows="4" style="resize : none;"></textarea>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ep_tag" class="control-label">ป้ายกำกับ : </label>
                            <input type="text" class="form-control tag-input" id="ep_tag" name="ep_tag" value="" placeholder="ป้ายกำกับ">
                        </div>
                    </div>

                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success">บันทึก</button>
                        <?= link_to('/datamanagement', $title = 'ย้อนกลับ', ['class' => 'btn btn-warning'], $secure = null); ?>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</section>
@endsection