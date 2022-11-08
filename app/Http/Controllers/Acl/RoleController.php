<?php

namespace App\Http\Controllers\Acl;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use App\Group;

use Illuminate\Support\Facades\Gate;

use Spatie\Permission\Models\Role;

use Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        // Verifica se é um superAdmin e retorna o Papel [Super User]
        //Auth::user()->isSuperAdmin() ? $roles = Role::get() : $roles = Role::where('id', '<>', 1)->get();

        $roles = Role::get();
       
        return view('admin.acl.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::denies('role-create')) {
                return view('errors.403');
        }

        $groups = Group::whereNull('parent_id')->get();

        $role = null;
        $disabled = null;

        return view('admin.acl.roles.form', compact('groups', 'role', 'disabled'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $permissions = explode("," , $request->permissions);

        $permissions_parse = [];

        if (count($permissions) < 2 || $permissions == null) {
           return redirect()->back()->with('flash_error', 'Selecione no mínimo duas permissões!');
        }

        foreach($permissions as $key => $permission) {
            if(is_numeric($permission)){
               $permissions_parse[] = $permission; 
            }
        }

        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);


        $role->syncPermissions($permissions_parse);

        return redirect()->route('admin.acl.roles')->with('flash_success', 'Papel cadastrado com sucesso!');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Gate::denies('role-view')) {
                return view('errors.403');
        }

        $disabled = true;
        $groups = Group::all();
        $role = Role::find($id);
       
        return view('admin.acl.roles.form', compact('groups','role','disabled'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('role-edit')) {
                return view('errors.403');
        }

        $groups = Group::all();
        $role = Role::find($id);
        $disabled = null;
       
        if($role->id == 1){
            return redirect()->route('admin.acl.roles');
        }

        return view('admin.acl.roles.form', compact('groups', 'role' , 'disabled'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('role-edit')) {
                return view('errors.403');
        }

        $role = Role::find($id);

        if($role->id == 1){
            return redirect()->route('user.papeis');
        }

         $permissions = explode("," , $request->permissions);

        $permissions_parse = [];

        if (count($permissions) < 2 || $permissions == null) {
           return redirect()->back()->with('flash_error', 'Selecione no mínimo duas permissões!');
        }

        foreach($permissions as $key => $permission) {
            if(is_numeric($permission)){
               $permissions_parse[] = $permission; 
            }
        }


        $role->syncPermissions($permissions_parse);
            

        return redirect()->route('admin.acl.roles')->with('flash_success', 'Papel atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Gate::denies('role-delete')) {
                return view('errors.403');
        }

        $role = Role::find($id);

        if($role->id == 1){
            return redirect()->route('admin.user.papeis');
        }    

        $role->forceDelete();


        return redirect()->route('admin.acl.roles')->with('flash_success', 'Papel excluído com sucesso!');
    }
}
