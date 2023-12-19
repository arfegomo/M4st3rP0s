<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolController extends Controller
{

    function __construct(){
        $this->middleware('permission:ver-rol|crear-rol|editar-rol|borrar-rol',['only'=>['index']]);
        $this->middleware('permission:crear-rol',['only'=>['create','store']]);
        $this->middleware('permission:editar-rol',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-rol',['only'=>['destroy']]);
    }

    public function index()
    {
        $roles = Role::all();
        return view('roles.index',compact('roles'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('roles.crear',compact('permission'));
    }

    public function store(Request $request)
   {
        $this->validate($request,[
        'name' => 'required|unique:roles|max:255',
        'guard_name' => 'required|max:255',
        'permission' => 'required'
    ]);

        $role = Role::create([
                'name' => $request->get('name'),
                'guard_name' => $request->get('guard_name')
            ]);

        $role->syncPermissions($request->get('permission'));
                  
        return redirect()->route('roles.index')->with('success', 'Registro creado correctamente.');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_has_permissions.role_id',$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('roles.editar', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
        'name' => 'required|max:255',
        
    ]);

         $role = Role::find($id);  
         $role->name = $request->get('name');
         
         $role->save();
         $role->syncPermissions($request->get('permission'));
         
        return redirect()->route('roles.index')->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy($id)
    {
        try {

            $roles = Role::find($id);
            $roles->delete();
            
            return redirect()->route('roles.index')->with('success', 'Registro eliminado correctamente.');

        } catch (\Throwable $th) {
            
            return redirect()->route('roles.index')->with('success', 'El registro no pudo ser eliminado.');

        }
    }
}
