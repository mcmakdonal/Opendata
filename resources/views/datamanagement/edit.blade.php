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
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                {!! Form::open(['url' => '/datamanagement/'.$content[0]->ep_id,'class' => 'form-auth-small', 'method' => 'put','files' => true]) !!}
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ep_title" class="control-label">ชื่อ {{ Define::DTS }} <span class="must-input">*</span> : </label>
                            <input type="text" class="form-control" id="ep_title" name="ep_title" value="{{ $content[0]->ep_title }}" placeholder="ชื่อ {{ Define::DTS }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ep_scope_geo" class="control-label">ขอบเขตภูมิศาสตร์ <span class="must-input">*</span> : </label>
                                <input type="text" class="form-control" id="ep_scope_geo" name="ep_scope_geo" value="{{ $content[0]->ep_scope_geo }}" placeholder="ขอบเขตภูมิศาสตร์" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ep_view" class="control-label">Database <span class="must-input">*</span> : </label>
                                <select class="form-control use-select2" name="ep_view" id="ep_view" required>
                                    @foreach($view->data as $k => $v)
                                        <option value="{{ $v->view }}" {{ ($content[0]->ep_view == $v->view)? "selected" : "" }} >{{ $v->view }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="control-label">{{ Define::OGZ }} <span class="must-input">*</span> : </label>
                                <select class="form-control use-select2" name="ogz_id" id="ogz_id" required>
                                    @foreach($get_ogz as $k => $v)
                                        <option value="{{ $v->ogz_id }}" {{ ($content[0]->ogz_id == $v->ogz_id)? "selected" : "" }} >{{ $v->ogz_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="" class="control-label">หมวดหมู่ <span class="must-input">*</span> : </label>
                                <select class="form-control use-select2" name="cat_id" id="cat_id" required>
                                    @foreach($get_cat as $k => $v)
                                        <option value="{{ $v->cat_id }}" {{ ($content[0]->cat_id == $v->cat_id)? "selected" : "" }} >{{ $v->cat_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ep_status" class="control-label">สถานะ <span class="must-input">*</span> : </label>
                                <select class="form-control use-select2" name="ep_status" id="ep_status" required>
                                    <option value="pb" {{ ($content[0]->ep_status == "pb")? "selected" : "" }} >สาธารณะ</option>
                                    <option value="pv" {{ ($content[0]->ep_status == "pv")? "selected" : "" }} >ส่วนตัว</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lcs_id" class="control-label">การอนุญาต <span class="must-input">*</span> : </label>
                                <select class="form-control use-select2" name="lcs_id" id="lcs_id" required>
                                    @foreach($get_lcs as $k => $v)
                                        <option value="{{ $v->lcs_id }}" {{ ($content[0]->lcs_id == $v->lcs_id)? "selected" : "" }} >{{ $v->license }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ep_file" class="control-label">ชนิตไฟล์ <span class="must-input">*</span> : </label>
                                @php
                                    $file_arr = explode(",",$content[0]->ep_file);
                                    unset($file_arr[count($file_arr) - 1]);
                                @endphp
                                <select name="ep_file[]" id="ep_file" class="form-control use-select2" multiple="multiple" required>
                                    <option value="xls" {{ (in_array("xls",$file_arr))? "selected" : "" }} >xls</option>
                                    <option value="csv" {{ (in_array("csv",$file_arr))? "selected" : "" }} >csv</option>
                                    <option value="xml" {{ (in_array("xml",$file_arr))? "selected" : "" }} >xml</option>
                                    <option value="json" {{ (in_array("json",$file_arr))? "selected" : "" }} >json</option>
                                    <option value="rdf" {{ (in_array("rdf",$file_arr))? "selected" : "" }} >rdf</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ep_contact_name" class="control-label">ชื่อผู้ใช้ข้อมูล <span class="must-input">*</span> : </label>
                                <input type="text" class="form-control" id="ep_contact_name" name="ep_contact_name" value="{{ $content[0]->ep_contact_name }}" placeholder="ชื่อผู้ใช้ข้อมูล" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ep_contact_email" class="control-label">อีเมลผู้ให้ข้อมูล <span class="must-input">*</span> : </label>
                                <input type="email" class="form-control" id="ep_contact_email" name="ep_contact_email" value="{{ $content[0]->ep_contact_email }}" placeholder="อีเมลผู้ให้ข้อมูล" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ep_description" class="control-label">รายละเอียด <span class="must-input">*</span> : </label>
                                <textarea class="form-control" id="ep_description" name="ep_description" rows="4" style="resize : none;">{{ $content[0]->ep_description }}</textarea>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ep_tag" class="control-label">ป้ายกำกับ <span class="must-input">*</span> : </label>
                                <input type="text" class="form-control tag-input" id="ep_tag" name="ep_tag" value="{{ $content[0]->ep_tag }}" placeholder="ป้ายกำกับ">
                            </div>
                        </div>

                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-success">บันทึก</button>
                            <button type="button" data="{{ $content[0]->ep_id }}" class="btn btn-info" onclick="export_datamanagement(this)">Export</button>
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