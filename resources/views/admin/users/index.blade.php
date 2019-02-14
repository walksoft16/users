@extends('adminlte::page')

@section('title', trans('Users::users.users'))

@section('content_header')
<h1>
	{{trans('Users::users.users')}}
</h1>
<ol class="breadcrumb">
    <li>
        <a href="{{route('admin')}}"><i class="fa fa-home"></i>{{trans('adminlte::adminlte.administration')}}</a>
    </li>
    <li>{{trans('Users::users.users')}}</li>
</ol>
@stop

@section('content_header_options')
<div class="x_content">
    <a href="{{route('admin')}}" class="btn btn-primary ">{{trans('adminlte::adminlte.return')}}</a>
    @if($permits['create'])<a href="{{route('users.create')}}" class="btn btn-primary">{{trans('adminlte::adminlte.create')}}</a>@endif
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                  <table id="datatable-buttons" class="table table-striped table-bordered datatable">
                      <thead>
                          <tr>
                              <th>{{trans('Users::users.name')}}</th>
                              <th>{{trans('Users::users.email')}}</th>
															<th>{{trans('adminlte::adminlte.creationDate')}}</th>
                              @if($permits['edit'])<th class="center">{{trans('adminlte::adminlte.edit')}}</th>@endif
                              @if($permits['delete'])<th class="center">{{trans('adminlte::adminlte.delete')}}</th>@endif
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($users as $user )
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
																<td>{{ $user->created_at }}</td>
                                @if($permits['edit'])<td class="center"><a href="{{route('users.edit',['id' => $user->id ])}}"><i class="fa fa-edit fa-2x"></i></a></td>@endif
                                @if($permits['delete'])<td class="center"><a href="{{route('users.show',['id' => $user->id ])}}"><i class="fa fa-remove fa-2x"></i></a></td>@endif
                            </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
            </div>
            <!-- /.box-body -->
         </div>
     </div>
</div>
@stop
