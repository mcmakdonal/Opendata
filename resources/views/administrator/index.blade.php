@extends('master.layout')
@section('title', $title )
@section('header', $header )

@section('content')
<section class="">
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 10px;">
            <?= link_to('/administrator/create', $title = 'Add Administrator', ['class' => 'btn btn-primary'], $secure = null); ?>
        </div>
    </div>
    <table class="table table-bordered datatable">
        <thead>
          <tr>
            <th style="width: 5%;">#</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Username</th>
            <th style="width: 10%;">Edit</th>
            <th style="width: 10%;">Delete</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($administrator as $k => $v)
            <tr>
                <td>{{$k + 1}}</td>
                <td>{{$v->first_name}}</td>
                <td>{{$v->last_name}}</td>
                <td>{{$v->username}}</td>
                <td>
                    <a href="{{ url('/administrator/'.$v->admin_id.'/edit') }}">
                        <button class="btn btn-warning">Edit</button>
                    </a>
                </td>
                <td>
                    <button onclick="delete_admin(this)" class="btn btn-danger" data="{{$v->admin_id}}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
</section>
@endsection