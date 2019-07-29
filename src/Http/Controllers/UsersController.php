<?php

namespace Walksoft\Users\Http\Controllers;

use UsersAppController as Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Auth;

class UsersController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        if (!Auth::user()->hasPermissionTo('list.users') &&
                !Auth::user()->hasPermissionTo('create.users') &&
                !Auth::user()->hasPermissionTo('edit.users') &&
                !Auth::user()->hasPermissionTo('delete.users')) {
            Session::flash('error', trans('adminlte::adminlte.app_msj_not_permissions'));
            return redirect()->route('admin');
        }

        $permits = [];
        $permits['create'] = Auth::user()->hasPermissionTo('create.users');
        $permits['edit'] = Auth::user()->hasPermissionTo('edit.users');
        $permits['delete'] = Auth::user()->hasPermissionTo('delete.users');

        $users = \App\Models\User::all();
        return view('Users::admin.users.index', compact('users', 'permits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        if (!Auth::user()->hasPermissionTo('create.users')) {
            Session::flash('error', trans('adminlte::adminlte.app_msj_not_permissions'));
            return redirect()->route('admin');
        }

        if(Session::get('user.create')){
            $user = Session::get('user.create');
        }else{
            $user = ['name'=>'', 'email'=>'', 'paswword'=>'', 'retype_password'=>''];
        }
        Session::forget('user.create');

        $roles = Role::where('level', 1)->orderBy('created_at', 'DESC')->get();
        return view('Users::admin.users.create', compact('states', 'roles', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        if (!Auth::user()->hasPermissionTo('create.users')) {
            Session::flash('error', trans('adminlte::adminlte.app_msj_not_permissions'));
            return redirect()->route('admin');
        }

        Session::put('user.create', $request);

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:50',
            'password' => 'required|max:40',
            'retype_password' => 'required|max:40|in:'.$request->password,
        ]);

        try {
            $user = new \App\Models\User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            if ($user->save() && count($request->roles) > 0) {
                    $user->syncRoles($request->roles);
            }//if

            Session::flash('success', trans('Users::users.store_ok'));
            Session::forget('user.create');
        } catch (QueryException $e) {
            Session::flash('error', 'error');
        }//cath

        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        if (!Auth::user()->hasPermissionTo('edit.users')) {
            Session::flash('error', trans('adminlte::adminlte.app_msj_not_permissions'));
            return redirect()->route('admin');
        }

        $user = \App\Models\User::find($id);
        $roles = Role::where('level', 1)->orderBy('created_at', 'DESC')->get();
        $rolesUser = $user->getRoles()->pluck('id')->toArray();

        return view('Users::admin.users.edit', compact("user", "roles", "rolesUser"));
    }

    /**
     *
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        if (!Auth::user()->hasPermissionTo('edit.users')) {
            Session::flash('error', trans('adminlte::adminlte.app_msj_not_permissions'));
            return redirect()->route('admin');
        }

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:50',
            'password' => 'nullable|max:40',
        ]);

        if($request->password){
            $this->validate($request, [
                'password' => 'required|max:40',
                'retype_password' => 'required|max:40|in:'.$request->password,
            ]);
        }

        try {
            $user = \App\Models\User::find($id);

            $user->name = $request->name;
            $user->email = $request->email;

            if($request->password){
                $user->password = Hash::make($request->password);
            }

            if ($user->save()) {
                if (count($request->roles) > 0) {
                    $user->syncRoles($request->roles);
                } else {
                    $user->detachAllRoles();
                }//else
            }//if

            Session::flash('success', trans('Users::users.update_ok'));
        } catch (QueryException $e) {
            Session::flash('error', 'error');
        }//cath

        return redirect()->route('users.edit', ['id' => $user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        if (!Auth::user()->hasPermissionTo('delete.users')) {
            Session::flash('error', trans('adminlte::adminlte.app_msj_not_permissions'));
            return redirect()->route('admin');
        }

        $user = \App\Models\User::find($id);
        return view('Users::admin.users.show', compact("user"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        if (!Auth::user()->hasPermissionTo('delete.users')) {
            Session::flash('error', trans('adminlte::adminlte.app_msj_not_permissions'));
            return redirect()->route('admin');
        }

        try {
            $user = \App\Models\User::find($id);
            $user->delete();

            Session::flash('success', trans('Users::users.delete_ok'));
        } catch (QueryException $e) {
            Session::flash('error', 'error');
        }//cath

        return redirect()->route('users.index');
    }
}
