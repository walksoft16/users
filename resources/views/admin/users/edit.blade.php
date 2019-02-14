@extends('adminlte::page')

@section('title', trans('Users::users.users'))

@section('content_header')
<h1>
    {{trans('Users::users.userEdit')}}
</h1>
<ol class="breadcrumb">
    <li>
        <a href="{{route('admin')}}"><i class="fa fa-home"></i>{{trans('adminlte::adminlte.administration')}}</a>
    </li>
    <li>
        <a href="{{ route('users.index') }}">{{trans('Users::users.users')}}</a>
    </li>
    <li class="active">{{trans('adminlte::adminlte.edit')}}</li>
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
                <h3 class="box-title">{{trans('Users::users.userEdit')}}</h3>
            </div>
            <form id="editForm" role="form" data-parsley-validate="" novalidate="" method="post" action="{{route('users.update',['id'=>$user['id']])}}" enctype="multipart/form-data">
                {{csrf_field()}}
                {{ method_field('PUT') }}
                <div class="clearfix"></div>

                <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                    <label for="name">{{ trans("Users::users.name") }} (*)</label>
                    <input type="text" value="{{$user['name']}}" class="form-control" id="name" name="name" placeholder="{{ trans("Users::users.name") }}" required="" maxlength="255">
                </div>

                <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                    <label for="email">{{ trans("Users::users.email") }} (*)</label>
                    <input type="email" value="{{$user['email']}}" class="form-control" id="email" name="email" placeholder="{{ trans("Users::users.email") }}" required="" maxlength="50">
                </div>

                <div class="clearfix"></div>

                <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                    <label for="password">{{ trans("adminlte::adminlte.password") }} (*)</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="{{ trans("adminlte::adminlte.password") }}" required="" maxlength="40">
                </div>

                <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                    <label for="retype_password">{{ trans("adminlte::adminlte.retype_password") }} (*)</label>
                    <input type="password" class="form-control" id="retype_password" name="retype_password" placeholder="{{ trans("adminlte::adminlte.retype_password") }}" required="" maxlength="40">
                </div>

                <div class="clearfix"></div>

                <div class="form-group col-xs-10 col-sm-4 col-md-6 col-lg-6">
                    <label for="roles[]">{{ trans("Roles::roles.roles") }}</label>
                    <select name="roles[]" id="roles[]" class="form-control select2" multiple="multiple" data-placeholder="{{trans("Roles::roles.selectRoles")}}" style="width: 100%;">
                    @foreach($roles as $role)
                        <option @if(in_array($role->id,$rolesUser)) selected="selected" @endif value="{{$role->id}}">{{ $role->name}}</option>
                    @endforeach
                    </select>
                </div>

                <div class="clearfix"></div>

                <div class="box-footer">
                    <button type="button" class="btn btn-primary center-block" data-toggle="modal" data-target="#confirmEdit">{{trans('adminlte::adminlte.edit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

