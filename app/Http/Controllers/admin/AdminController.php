<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\rights\Rights;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public $rights;

    public function __construct(Rights $rights)
    {
        $this->rights = $rights;
    }
    public function view()
    {
        session()->put('referring_route', request()->route()->getName());
        $roles = Roles::all();
        return view('admin.admins.view', compact('roles'));
    }
    public function permissioView($id = "")
    {
        try {
            $data = Admin::where('ids', $id)->firstOrFail();
            $rights = $this->rights->view();
            $rights->with('data', $data);
            return $rights;
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withErrors(["error" => "Unknown action"]);
        }
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
    protected function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'role' => 'required|exists:roles,id',
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|min:8',
                'mobile' => 'nullable|numeric|digits:10',
                'address' => 'required|string|max:255',
            ]);
            $ids = \Str::lower(\Str::random(30));
            Admin::create([
                'ids' => $ids,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->mobile,
                'address' => $request->address,
                'password' => \Hash::make($request->password),
                'role' => $request->role,
                'remember_token' => \Str::random(60)
            ]);
            return withSuccess('create');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withInput()->withErrors(["error" => $th->getMessage()])->with('keepModalOpen', true);
        }
    }
    protected function update(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:admins,id',
                'name' => 'required|string|max:255',
                'role' => 'required|exists:roles,id',
                'password' => 'nullable|min:8',
                'mobile' => 'nullable|numeric|digits:10',
                'address' => 'required|string|max:255',
            ]);

            // Fetch the admin record
            $admin = Admin::findOrFail($request->id);
            $authenticatedUser = auth()->user();
            if ($request->id == $authenticatedUser->id) {
                throw new \Exception('You cannot update your own ID.');
            }
            if ($admin->dflt == 1) {
                throw new \Exception('Default admin cannot be updated.');
            }
            // Validate email uniqueness if it's changed
            if ($request->email != $admin->email) {
                $request->validate([
                    'email' => 'required|email|unique:admins,email',
                ]);
            }

            // Update password if provided
            if (!empty($request->password)) {
                $request->validate([
                    'password' => 'required|min:8',
                ]);
                $admin->password = \Hash::make($request->password);
            }

            // Update other fields
            $admin->email = $request->email;
            $admin->name = $request->name;
            $admin->phone = $request->mobile;
            $admin->address = $request->address;
            $admin->role = $request->role;
            $admin->save();
            return withSuccess('update');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withInput()->withErrors(['error' => $th->getMessage()])->with('keepModalOpen', true);
        }
    }
    protected function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:admins,id',
            ]);

            // Fetch the admin record
            $admin = Admin::findOrFail($request->id);
            if ($admin->id == user()->id()) {
                throw new \Exception('You cannot delete your own account.');
            }
            if ($admin->dflt == 1) {
                throw new \Exception('Default admin cannot be deleted.');
            }
            Admin::destroy($request->id);

            return withSuccess('delete');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withInput()->withErrors(['error' => $th->getMessage()])->with('keepModalOpen', true);
        }
    }

}
