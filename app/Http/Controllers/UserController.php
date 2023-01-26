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
//use App\Rol;


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

        $users = User::paginate(10);
        /*$users = User::join("model_has_roles","model_has_roles.model_id","=","users.id")
        ->join("roles","roles.id","=","model_has_roles.role_id")
        ->select("users.id","users.name","roles.name AS roles","users.email")
        ->get();*/

        return view('usuarios.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('usuarios.crear',compact('roles'));
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

        return redirect()->route('users.edit',array('user'=>$user->id))->with('success', 'Registro creado correctamente!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $users->roles->pluck('name','name')->all();
        return view('usuarios.editar',compact('users','roles','userRole'));
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
        $this->validate($request,[
        'name' => 'required|max:255',
        'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
        'password' => 'same:password_confirmation',
        'roles' => 'required'


    ]);


         $users = User::find($id);  
         $users->name = $request->get('name');


         if($request->get('password') != null){
         
         $users->password = Hash::make($request->get('password'));

        }else{

         unset($users->password);   
         
        }
        
        $users->save();

        DB::table('model_has_roles')->where('model_id',$id)->delete();
         

         // Le asignamos el rol
        $users->assignRole($request->get('roles'));
         
        return redirect()->route('users.edit',array('user'=>$id))->with('success', 'Registro actualizado correctamente!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);
        $users->delete();
        
        return redirect()->route('users.index')->with('success', 'Registro eliminado correctamente!!!');
    }
}
