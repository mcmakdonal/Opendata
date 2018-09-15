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
    <div class="row">
        <div class="col-md-9">
            <div class="form-group">
                <input type="text" class="form-control" id="title" name="title" value="" placeholder="คำค้นหา" required>
            </div>
        </div>
        <div class="col-md-3 text-center">
            <div class="form-group">
                <button type="submit" class="btn btn-success">ค้นหา</button>
                <a href="/organization"><button type="button" class="btn btn-warning">ล้างค่า</button></a>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    <div class="row index-content">
        @foreach($get_ogz as $k => $v)
        <a href="{{ url('/organization/page/'.$v->ogz_url) }}">
            <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
                <div class="card">
                    <img src="{{ url($v->ogz_image) }}" class="img-responsive" alt="#">
                    <h4>{{ $v->ogz_title }}</h4>
                    <p>{{ $v->ogz_description }}</p>
                    <a href="{{ url('/organization/page/'.$v->ogz_url) }}" class="blue-button"> {{ $v->num }} Dataset </a>
                </div>
            </div>
        </a>
        @endforeach                    
    </div>
    @if ($get_ogz->lastPage() > 1)
    <ul class="pagination">
        <li class="">
            <a href="{{ $get_ogz->url(1) }}">หน้าแรก</a>
        </li>
        <li class="{{ ($get_ogz->currentPage() == 1) ? ' disabled' : '' }}">
            <a href="{{ $get_ogz->url(1) }}">ก่อนหน้า</a>
        </li>
        @for ($i = 1; $i <= $get_ogz->lastPage(); $i++)
            <li class="{{ ($get_ogz->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $get_ogz->url($i) }}">{{ $i }}</a>
            </li>
        @endfor
        <li class="{{ ($get_ogz->currentPage() == $get_ogz->lastPage()) ? ' disabled' : '' }}" {{ ($get_ogz->currentPage() == $get_ogz->lastPage()) ? ' disabled' : '' }} >
            <a href="{{ $get_ogz->url($get_ogz->currentPage()+1) }}" >หน้าต่อไป</a>
        </li>
        <li class="{{ ($get_ogz->currentPage() == $get_ogz->lastPage()) ? ' disabled' : '' }}" {{ ($get_ogz->currentPage() == $get_ogz->lastPage()) ? ' disabled' : '' }} >
            <a href="{{ $get_ogz->url($get_ogz->lastPage()) }}" >หน้าสุดท้าย</a>
        </li>
    </ul>
    @endif
</section>
@endsection