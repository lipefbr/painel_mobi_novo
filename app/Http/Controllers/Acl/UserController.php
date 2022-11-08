<?php

namespace App\Http\Controllers\Acl;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Admin;
use App\Group;
use App\Fleet;

use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Role;

use Auth;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = [];

        $user = Auth::user();

        if($user && ($user->isSuperAdmin() || $user->isAdmin())) {

            $users = Admin::where('id', '<>', Auth::user()->id )->get();
      
        } else {
            $users = Admin::where('id', '<>', Auth::user()->id )->where('parent_id', $user->id )->get();
        }
        
        return view('admin.acl.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $groups = Group::all();
        
        // Verifica se é um superAdmin e retorna o Papel [Super User]
        // Auth::user()->isSuperAdmin() ? $roles = Role::get() : $roles = Role::where('id', '<>', 1)->get();

        $roles = Role::get();

        $user = null;
        $disabled = null;
        $user_role = [];

        $fleets = Fleet::get()->pluck('name', 'id');

        return view('admin.acl.users.form', compact('groups', 'user', 'roles', 'disabled', 'user_role', 'fleets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|unique:admins,email|email|max:255',
            //'mobile' => 'digits_between:6,17',
            //'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required',
        ]);

        //try{

            $users = $request->all();

            $users['password'] = bcrypt($request->password);
            $users['active'] = $request->active == "on" ? true : false;
            if($request->hasFile('picture')) {
                $users['picture'] = $request->picture->store('admin/profile');
            }

            $users['parent_id'] = Auth::user()->id;

            $user = Admin::create($users);


            $user->assignRole($request->input('roles'));



            /*
            *   Fleets
            */
            if(!empty($request->fleets )){
                $user->fleets()->sync( $request->fleets );           
            }

            return redirect()->route('admin.acl.users')->with('flash_success', trans('Usuário Cadastrado com Sucesso!'));

        /*
        } catch (Exception $e) {
            return back()->with('flash_error', trans('Falha ao Cadastrar Usuário'));
        }

        /*
        if (!empty($request->roles)){            
           
            foreach($request->roles as $key => $value) {        
                
                UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => $value
                    ]);
            }

        }else{
            $user->update(['active' => 0]);
        }

        if(Gate::allows('permission-view')) {

                $permissions = explode("," , $request->permissions);

                if (!empty($permissions)){   
                    foreach($permissions as $key => $permission) {
                        if(is_numeric($permission)){
                            PermissionUser::create([
                                'permission_id' => $permission,
                                'user_id' => $user->id
                            ]);
                        }
                    }
                }
         }

        \Session::flash('toast','Usuário criado com sucesso!'); 

        return redirect()->route('acl.users');   
        */

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*
        if (Gate::denies('user-view')) {
                return view('errors.403');
        }

         $roles = [];

         
        // Verifica se é um superAdmin e retorna o Papel [Super User]
        Auth::user()->isSuperAdmin() ? $roles = Role::get() : $roles = Role::where('id', '<>', 1)->get();

        $groups = Group::all();
        $user = User::find($id);
        $user_role = $user->roles()->pluck('role_id')->toArray();
        $disabled = true;

        return view('backend.acl.users.form', compact('groups', 'user', 'roles', 'disabled', 'user_role'));
        */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $roles = [];

        // Verifica se é um superAdmin e retorna o Papel [Super User]
        //Auth::user()->isSuperAdmin() ? $roles = Role::get() : $roles = Role::where('id', '<>', 1)->get();

        $roles = Role::get(); 

        $groups = Group::all();
        
        $user = Admin::find($id);
        $user_role = $user->roles()->pluck('role_id')->toArray();
        $disabled = null;

        $fleets = Fleet::get()->pluck('name', 'id');

        return view('admin.acl.users.form', compact('groups', 'user', 'roles', 'disabled', 'user_role', 'fleets'));
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

        $this->validate($request, [
            'name' => 'required|max:255',
            //'mobile' => 'digits_between:6,16',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
        ]);

        try {

            //$request->roles = array_map('intval', $request->roles);
        

            $user = Admin::findOrFail($id);

            if($request->hasFile('picture')) {
                Storage::delete($user->picture);
                $user->picture = $request->picture->store('admin/profile');
            }

            $user->name = $request->name;
            //$user->email = $user->email;
            $user->mobile = $request->mobile;
            $user->cpf = $request->cpf;
            $user->active = $request->active == "on" ? true : false;


            if($request->password && ($request->password_confirmation == '' ||  $request->password_confirmation == null)){
                return back()->with('flash_error', 'Por favor, informe a senha de confirmação!');
            }else if($request->password && $request->password_confirmation && $request->password != '' && $request->password != null) {
                if($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                }else{
                    return back()->with('flash_error', 'As senhas não conferem!');
                }
            }
            

            if(empty($request->roles )){
                $user->roles()->sync([]);
            }else{
                $user->roles()->sync( $request->roles );           
            }

            /*
            *   Fleets
            */
            if(empty($request->fleets )){
                $user->fleets()->sync([]);
            }else{
                $user->fleets()->sync( $request->fleets );           
            }


            $user->save();
        

            //$user->assignRole($request->input('roles'));

            return redirect()->route('admin.acl.users')->with('flash_success', trans('Usuário Atualizado Com Sucesso!'));    
        
        } catch (ModelNotFoundException $e) {
            return back()->with('flash_error', trans('Falha ao  Atualizar Usuário!'));
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

       $user = Admin::withTrashed()->find($id);


       if(is_null($user->deleted_at)){
            $user->delete();
            return redirect()->route('admin.acl.users')->with('flash_success', 'Usuário excluido com sucesso!'); 
       }else{
     
            if (Gate::denies('user-delete-permanent')) {
                return view('errors.403');
            }

            $user->forceDelete();
            return redirect()->route('admin.acl.users')->with('flash_success', 'Usuário excluido com sucesso!');
       }    

       return 404;

    }

    public function checkedOut()
    {
        
        $users = Admin::onlyTrashed()->paginate(30);

        return view('admin.acl.users.checked-out', compact('users'));

    }

    public function restore($id){

        Admin::withTrashed()
        ->where('id', $id)
        ->restore();


        return redirect()->route('admin.acl.users')->with('flash_success','Usuário restaurado com sucesso!'); 
    }

}
