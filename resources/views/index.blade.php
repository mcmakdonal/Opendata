@extends('master.layout')
@section('header', $header )
@section('title', $title )

@section('content')
    <!-- SLIDER -->
    <section class="">
        {!! Form::open(['url' => "/dataset",'class' => '', 'method' => 'get']) !!}
        <div class="input-group">
            <input class="form-control" type="text" name="title">
            <span class="input-group-btn"><button class="btn btn-primary" type="submit">Search</button></span>
        </div>
        {!! Form::close() !!}
    </section>
    <!--// SLIDER -->
@endsection

