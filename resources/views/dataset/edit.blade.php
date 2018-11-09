@extends('master.layout')
@section('title', $title )

@section('content')
<section class="">
<div class="col-md-12">
    <div class="panel panel-primary"  style="padding: 20px;">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#dataset"><span class="lnr lnr-pencil"></span>{{ Define::DTS }}</a></li>
        <li><a data-toggle="tab" href="#resouce"><span class="lnr lnr-cloud-download"></span> ทรัพยากร</a></li>
        <li><a data-toggle="tab" href="#metadata"><span class="fa fa-database"></span> Metadata</a></li>
        <div class="text-right">
        <a href="{{url('/dataset/page/'.$slug_url)}}">
            <button type="button" class="btn btn-primary"><span class="lnr lnr-eye"></span> ดู {{ Define::DTS }}</button>
        </a>
    </div>
    </ul>

    <div class="tab-content">
        <div id="dataset" class="tab-pane fade in active"><br>

            {!! Form::open(['url' => '/dataset/update','class' => 'form-auth-small', 'method' => 'put','files' => true]) !!}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title" class="control-label">ชื่อ {{ Define::DTS }} <span class="must-input">*</span> : </label>
                            <input type="text" class="form-control" id="dts_title" name="dts_title" value="{{ $tbl_dataset[0]->dts_title }}" placeholder="ชื่อ {{ Define::DTS }}" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="URL" class="control-label">ลิงก์ถาวร <span class="must-input">*</span> : </label>
                            <div class="input-group">
                                <span class="input-group-addon">/dataset/page/</span>
                                <input type="text" name="dts_url" id="dts_url" value="{{ $tbl_dataset[0]->dts_url }}" class="form-control" placeholder="my-dataset" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description" class="control-label">รายละเอียด <span class="must-input">*</span> : </label>
                            <textarea class="form-control" id="dts_description" name="dts_description" rows="3" style="resize : none;">{{ $tbl_dataset[0]->dts_description }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="dts_scope_geo" class="control-label">ขอบเขตภูมิศาสตร์ <span class="must-input">*</span> : </label>
                            <input type="text" class="form-control" id="dts_scope_geo" name="dts_scope_geo" value="{{ $tbl_dataset[0]->dts_scope_geo }}" placeholder="ขอบเขตภูมิศาสตร์" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="dts_tag" class="control-label">ป้ายกำกับ <span class="must-input">*</span> : </label>
                            <input type="text" class="form-control tag-input" id="dts_tag" name="dts_tag" value="{{ $tbl_dataset[0]->dts_tag }}" placeholder="ป้ายกำกับ">
                            <span class="label label-warning">ใส่คำที่ต้องการจากนั้นกด enter</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dts_contact_name" class="control-label">ชื่อผู้ให้ข้อมูล <span class="must-input">*</span> : </label>
                            <input type="text" class="form-control" id="dts_contact_name" name="dts_contact_name" value="{{ $tbl_dataset[0]->dts_contact_name }}" placeholder="ชื่อผู้ใช้ข้อมูล" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dts_contact_email" class="control-label">อีเมลผู้ให้ข้อมูล <span class="must-input">*</span> : </label>
                            <input type="text" class="form-control" id="dts_contact_email" name="dts_contact_email" value="{{ $tbl_dataset[0]->dts_contact_email }}" placeholder="อีเมลผู้ให้ข้อมูล" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dts_permission" class="control-label">สิทธิ์ในการเข้าถึงข้อมูล <span class="must-input">*</span> : </label>
                            <input type="text" class="form-control" id="dts_permission" name="dts_permission" value="{{ $tbl_dataset[0]->dts_permission }}" placeholder="สิทธิ์ในการเข้าถึงข้อมูล" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="dts_frequent" class="control-label">ความถี่ในการปรับปรุง <span class="must-input">*</span> : </label>
                            <select class="form-control use-select2" name="dts_frequent" id="dts_frequent" required>
                                @foreach ($get_frequent as $k => $v )
                                    <option value="{{$k}}" {{ ($tbl_dataset[0]->dts_frequent == $k)? "selected" : "" }} >{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <hr style="display:none;" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">การอนุญาต <span class="must-input">*</span> : </label>
                            <select class="form-control use-select2" name="lcs_id" id="lcs_id" required>
                                @foreach($get_lcs as $k => $v)
                                    <option value="{{ $v->lcs_id }}" {{ ($tbl_dataset[0]->lcs_id == $v->lcs_id)? "selected" : "" }} >{{ $v->license }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">{{ Define::OGZ }} <span class="must-input">*</span> : </label>
                            @if (Cookie::get('m_type') === "A")
                                <select class="form-control use-select2" name="ogz_id" id="ogz_id" required>
                                    @foreach($get_ogz as $k => $v)
                                        <option value="{{ $v->ogz_id }}" {{ ($tbl_dataset[0]->ogz_id == $v->ogz_id)? "selected" : "" }} >{{ $v->ogz_title }}</option>
                                    @endforeach
                                </select>
                            @else
                                @php $ogz_title = ""; @endphp
                                @foreach($get_ogz as $k => $v)
                                    @php ($tbl_dataset[0]->ogz_id == $v->ogz_id)? $ogz_title = $v->ogz_title : "" @endphp
                                @endforeach
                                <input type="text" class="form-control" id="" name="" value="{{ $ogz_title }}" placeholder="" readonly>
                                <input type="hidden" class="form-control" id="ogz_id" name="ogz_id" value="{{ $tbl_dataset[0]->ogz_id }}">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr style="margin-bottom: 10px;margin-top: 10px;" />
                    </div>        

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">หมวดหมู่ <span class="must-input">*</span> : </label>
                            <select class="form-control use-select2" name="cat_id" id="cat_id" required>
                                @foreach($get_cat as $k => $v)
                                    <option value="{{ $v->cat_id }}" {{ ($tbl_dataset[0]->cat_id == $v->cat_id)? "selected" : "" }} >{{ $v->cat_title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">สถานะ <span class="must-input">*</span> : </label>
                            <select class="form-control use-select2" name="dts_status" id="dts_status">
                                <option value="pb" {{ ($tbl_dataset[0]->dts_status == "pb")? "selected" : "" }} >สาธารณะ</option>
                                <option value="pv" {{ ($tbl_dataset[0]->dts_status == "pv")? "selected" : "" }} >ส่วนตัว</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <button class="btn btn-danger" type="button" onclick="remove_dts(this,'{{$slug_url}}')" data="{{ url('/dataset/delete') }}">ลบ {{ Define::DTS }}</button>
                    </div>

                    <div class="col-md-6 text-right">
                        <input type="hidden" value="{{ $tbl_dataset[0]->dts_id }}" name="dts_id">
                        <button type="submit" class="btn btn-success">บันทึก {{ Define::DTS }}</button>
                        <?=link_to('/dataset/page/'.$slug_url, $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null);?>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
        <div id="resouce" class="tab-pane fade"><br>
            <div class="row">
                <div class="col-md-12 featured-responsive">
                    <?=link_to('/resource/new_resource/' . $slug_url, $title = 'เพิ่ม ทรัพยากร', ['class' => 'btn btn-primary'], $secure = null);?>
                    <div class="list-group" style="margin-top: 10px;">
                        @foreach($resource as $k => $v)
                        <div class="list-group-item list-group-item-action">
                            <div class="row">
                                <div class="col-md-12">
                                    @php
                                        $file_format = $v->file_format;
                                        if($v->file_format == "txt" || $v->file_format == "json"){
                                            $file_format = "text";
                                        }elseif($v->file_format == "png" || $v->file_format == "jpeg" || $v->file_format == "jpg"){
                                            $file_format = "image";
                                        }
                                    @endphp
                                    <h5> <i class="fa fa-file-{{ $file_format }}-o" aria-hidden="true"></i> {{ $v->file_name }} </h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div id="metadata" class="tab-pane fade"><br>
            {!! Form::open(['url' => '/dataset/update_metadata', 'method' => 'POST']) !!}
            <div class="row">
                <div class="col-md-12 featured-responsive">
                    <div class="form-group">
                        <label for="file_desc" class="control-label">Metadata : <button type="button" class="btn btn-success metadata_btn" onclick="add_table()"><i class="glyphicon glyphicon-plus"></i></button></label>
                        
                        <table class="table table-bordered" style="text-align:center;background:white">
                            <tr>
                                <td>ชื่อฟิลด์</td>
                                <td>รายละเอียด</td>
                                <td>รูปแบบฟิลด์</td>
                                <td>หน่วย</td>
                                <td>ลบ</td>
                            </tr>
                            <tbody id="data_body">
                            @for($x = 0; $x < count($metadata) ; $x++)
                                <tr id="tr{{$x}}">
                                    <td><input type="text" value="{{ $metadata[$x]->mtd_field_name }}" class="form-control" name="field_name[]"  required></td>
                                    <td><input type="text" value="{{ $metadata[$x]->mtd_description }}" class="form-control" name="description[]"  ></td>
                                    <td><input type="text" value="{{ $metadata[$x]->mtd_field_type }}" class="form-control" name="field_type[]"  required></td>
                                    <td >
                                        <input type="text" value="{{ $metadata[$x]->mtd_unit }}" class="form-control" name="unit[]"  >
                                        <input type="text" value="0" class="form-control" style="display:none" name="type[]" >
                                        <input type="hidden" value="{{ $metadata[$x]->mtd_id }}" name="mtd_id[]">
                                    </td>
                                    <td >
                                        <button type="button" class="btn btn-danger metadata_btn" onclick="remove_metadata('{{ $metadata[$x]->mtd_id }}','{{$slug_url}}')"><i class="glyphicon glyphicon-trash"></i></button>
                                    </td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-right">
                        <input type="hidden" value="{{ $tbl_dataset[0]->dts_id }}" name="dts_id">
                        <input type="hidden" value="{{$slug_url}}" name="slug_url">
                        <button type="submit" class="btn btn-success">บันทึก Metadata</button>
                    </div>          
                </div>
            </div>     
            {!! Form::close() !!}
        </div>
    </div>
</div>
</section>
@endsection