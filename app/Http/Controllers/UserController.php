<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

use App\User;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:ver-usuario|crear-usuario|editar-usuario|borrar-usuario',['only'=>['index']]);
        $this->middleware('permission:crear-usuario',['only'=>['create','store']]);
        $this->middleware('permission:editar-usuario',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-usuario',['only'=>['destroy']]);
    }

    public function index()
    {

        $users = User::all();
        return view('usuarios.index',compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('usuarios.crear',compact('roles'));
    }

    public function store(Request $request)
    {
         $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required']
        ]);

         $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'roles' => $request->get('roles'),
            ]);

         $user->assignRole($request->get('roles'));

        return redirect()->route('users.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {
        $users = User::find($id);
        $role = Role::get();
        //$userRole = $users->roles->pluck('id','name')->all();
        $roleUsers = DB::table('model_has_roles')->where('model_has_roles.model_id',$id)
            ->pluck('model_has_roles.role_id','model_has_roles.role_id')
            ->all();
            
        return view('usuarios.editar',compact('users','role','roleUsers'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'name' => 'required|max:255',
        'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
        'password' => 'same:password_confirmation',
        'role' => 'required'
    ]);

         $users = User::find($id);  
         $users->name = $request->get('name');
         $users->email = $request->get('email');

         if($request->get('password') != null){
         
            $users->password = Hash::make($request->get('password'));

        }else{

         unset($users->password);   
         
        }
        
        $users->save();

         $users->syncRoles($request->get('role'));

        //DB::table('model_has_roles')->where('model_id',$id)->delete();

         // Le asignamos el rol
        // $users->assignRole($request->get('roles'));
         
        //return redirect()->route('users.edit',array('user'=>$id))->with('success', 'Registro actualizado correctamente!!!');
        return redirect()->route('users.index')->with('success', 'Registro modificado correctamente.');

    }

    public function destroy($id)
    {
        try {

            $users = User::find($id);
            $users->delete();
            
            return redirect()->route('users.index')->with('success', 'Registro eliminado correctamente.');

        } catch (\Throwable $th) {
            
            return redirect()->route('users.index')->with('success', 'El registro no pudo ser eliminado.');

        }
    }
}
