@extends('adminlte::page')

@section('title', trans('Users::users.users'))

@section('content_header')
<h1>
    {{trans('Users::users.userDelete')}}
</h1>
<ol class="breadcrumb">
    <li>
        <a href="{{route('admin')}}"><i class="fa fa-home"></i>{{trans('adminlte::adminlte.administration')}}</a>
    </li>
    <li>
        <a href="{{ route('users.index') }}">{{trans('Users::users.users')}}</a>
    </li>
    <li class="active">{{trans('adminlte::adminlte.delete')}}</li>
</ol>
@stop

@section('content_header_options')
<div class="x_content">
    <a href="{{route('users.index')}}" class="btn btn-primary ">{{trans('adminlte::adminlte.return')}}</a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-edit"></i>
                <h3 class="box-title">{{trans('Users::users.userDelete')}}</h3>
            </div>
            <form id="deleteForm" role="form" method="post" action="{{ route('users.destroy', ['id' => $user->id]) }}" enctype="multipart/form-data">
                {{csrf_field()}}
                {{ method_field('DELETE') }}
                <div class="clearfix"></div>

                <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                    <label for="name">{{ trans("Users::users.name") }} (*)</label>
                    <input disabled="" type="text" value="{{$user['name']}}" class="form-control" id="name" name="name" placeholder="{{ trans("Users::users.name") }}" required="" maxlength="255">
                </div>

                <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                    <label for="email">{{ trans("Users::users.email") }} (*)</label>
                    <input disabled="" type="email" value="{{$user['email']}}" class="form-control" id="email" name="email" placeholder="{{ trans("Users::users.email") }}" required="" maxlength="50">
                </div>

                <div class="clearfix"></div>
                <div class="box-footer">
                    <button type="button" class="btn btn-primary center-block" data-toggle="modal" data-target="#confirmDelete">{{trans('adminlte::adminlte.delete')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop
