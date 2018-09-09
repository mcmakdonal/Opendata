@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
    <div class="row">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        {!! Form::open(['url' => '/administrator/'.$tbl_administrator[0]->admin_id,'class' => 'form-auth-small', 'method' => 'put','files' => true]) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="first_name" class="control-label">Firstname : </label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{$tbl_administrator[0]->first_name}}" placeholder="ชื่อ" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="last_name" class="control-label">Lastname : </label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{$tbl_administrator[0]->last_name}}" placeholder="นามสกุล" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="username" class="control-label">Username : </label>
                    <input type="text" class="form-control" id="username" name="username" value="{{$tbl_administrator[0]->username}}" placeholder="Username" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="password" class="control-label">Password : </label>
                    <input type="password" class="form-control" id="password" name="password" value="" placeholder="Password">
                    <input type="hidden" name="old_password" value="{{$tbl_administrator[0]->password}}">
                </div>
            </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success">Update Administrator</button>
                <?= link_to('/administrator', $title = 'Cancel', ['class' => 'btn btn-warning'], $secure = null); ?>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</section>
@endsection