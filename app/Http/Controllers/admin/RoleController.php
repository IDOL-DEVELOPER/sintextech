<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    public function view()
    {
        session()->put('referring_route', request()->route()->getName());
        return view('admin.roles.view');
    }
    public function action(Request $request)
    {
        $request->validate([
            "action" => 'required|in:create,update,delete'
        ]);
        $action = $request->action;
        switch ($action) {
            case 'create':
                if (check() && user()->hasPermission('write')) {
                    return $this->create($request);
                } else {
                    ce("Unautorize Permission Access Not Allowed For Write");
                    return back()->withErrors(["error"], "Unautorize Permission Access Not Allowed");
                }
            case 'update':
                if (check() && user()->hasPermission('update')) {
                    return $this->update($request);
                } else {
                    ce("Unautorize Permission Access Not Allowed For Update");
                    return back()->withErrors(["error"], "Unautorize Permission Access Not Allowed");
                }
            case 'delete':
                if (check() && user()->hasPermission('delete')) {
                    return $this->delete($request);
                } else {
                    ce("Unautorize Permission Access Not Allowed For Delete");
                    return back()->withErrors(["error"], "Unautorize Permission Access Not Allowed");
                }
            default:
                ce("Invalid action");
                return back()->withErrors(['error' => 'Invalid action']);
        }
    }
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|string|max:20|unique:roles,name',
        ]);
        try {
            $role = new Roles();
            $role->name = $request->role;
            $role->save();
            return redirect()->back()->with('success', 'New Role Successfully Added');
        } catch (\Exception $e) {
            ce($e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:roles,id',
            'role' => 'required|string|max:20|unique:roles,name',
        ]);
        try {
            $role = new Roles();
            $role->name = $request->role;
            $role->save();
            return redirect()->back()->with('success', 'New Role Successfully Added');
        } catch (\Exception $e) {
            ce($e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    protected function delete(Request $request)
    {
        try {
            $role = Roles::findOrFail($request->id);
            if ($role->users()->exists()) {
                return back()->withErrors(['error' => 'Role has associated users. Please reassign the users before deleting this role.']);
            }
            $role->delete();
            return back()->with('success', 'Role deleted successfully');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }
}
