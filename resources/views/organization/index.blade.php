@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
    @if($is_login)
        <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
                <?= link_to('/organization/new', $title = 'Add Organization', ['class' => 'btn btn-primary'], $secure = null); ?>
            </div>
        </div>
    @endif
    {!! Form::open(['url' => url()->current(),'class' => 'form-auth-small', 'method' => 'get']) !!}
    <div class="row ">
    <div class="col-md-12">
    <div class="input-group my-colorpicker2 colorpicker-element box_select_search">
                  <input type="text" class="form-control form_style" id="title" name="title" value="" style="border-radius: 5px;" placeholder="คำค้นหา" required>
                  <div class="input-group-addon box_btn_search">
                  <button type="submit" class="btn search-data btn_search">
                        <img  src="{{ url('backend/assets/img/icon_search.png') }}" > ค้นหา
                        </button>
                        <a href="/organization"><button type="button" class="btn clear-data btn_search" style="margin-left:5px">
                        <img  src="{{ url('backend/assets/img/icon_reset.png') }}" > ค่าเริ่มเต้น
                        </button></a>
                  </div>
                </div>
            </div>
         </div>
         <div class="row">
                <div class="col-md-12 featured-responsive" style="margin-top:15px">
                    <div class="box_headder" style="margin-bottom:0px">
                     <div class="text_box_title" >
                     <img src="{{ url('backend/assets/img/icon_topic.png') }}" >   ORGANIZATION
                    </div>   
                    <img src="{{ url('backend/assets/img/topic_fx.png') }}" style="float:right">
                    </div>
                </div>
            </div>
    {!! Form::close() !!}
    <div class="row" style="padding: 20px 10px;">
 @php
  $g = 0;
  $size =count($get_ogz);
  $loop =  ceil($size/3.00);
 @endphp
    @for ($i = 0; $i < $loop; $i++)   
    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 " style="padding:0">
        @for($x = 0; $x < 3&$g<$size; $x++)
        <a href="{{ url('/organization/page/'.$get_ogz[$g]->ogz_url) }}">
            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 " style="padding:0px 5px">
                <div class=" panel-primary" style="color: #6b6b6b;padding: 10px;">
                    <div style="width:100%;text-align:center">
                    <img src="{{ url($get_ogz[$g]->ogz_image) }}" style="width:90px" alt="#" >
                    </div>
                    <div class="box_text_or">
                    <h4 style="margin-bottom:0;font-size:16px">{{ $get_ogz[$g]->ogz_title  }}</h4>
                    </div>
                    <div class="text_num">{{ $get_ogz[$g]->num }}</div>
                    <div class="text_des">
                    <p>{{ $get_ogz[$g]->ogz_description }}</p>
                    </div>  
                </div>
            </div>
        </a>
        @php
            $g++;
        @endphp
        @endfor  
</div>
@endfor
    </div>
   
</section>
@endsection