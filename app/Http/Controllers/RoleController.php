<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.role.index', [
           'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating the resource.
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required',
            'permissions' => 'required'
        ]);
        //$role = Role::findByName($request->role;
        try {
            $role = Role::findOrCreate($request->role);
            /*if (Role::findByName($request->role)) {
                return back()->with('success', 'Role with same name already exisits');
            }*/

            //$role = Role::create(['name' => $request->role]);

            foreach ($request->permissions as $permission) {
                //$permission = Permission::create(['name' => $permission]);
                $permission = Permission::findOrCreate($permission);
                $role->givePermissionTo($permission);
            }

        } catch (\Exception $e) {
            return back()->with('success', $e->getMessage());
        }

        return back()->with('success', 'Role with permissions has been created!');
    }

    /**
     * Display the resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy(): never
    {
        abort(404);
    }
}
