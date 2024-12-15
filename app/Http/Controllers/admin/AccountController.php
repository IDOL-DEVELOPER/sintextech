<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public function view()
    {
        return view('admin.account.view');
    }

    public function saveImage(Request $request)
    {
        try {
            // Check if the request is authenticated and is AJAX
            if (!auth()->check() || !$request->ajax()) {
                return response()->json(['error' => true, 'message' => 'Unauthorized Access']);
            }

            // Retrieve the authenticated user
            $user = auth()->user();
            $class = get_class($user);

            // Fetch the user instance by ID
            $userInstance = $class::findOrFail($user->id);

            if ($userInstance) {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $request->validate([
                        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    ]);
                    $directory = 'uploads/admin';
                    if ($userInstance->image) {
                        \Storage::disk('public')->delete($userInstance->image);
                    }
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs($directory, $filename, 'public');
                    $userInstance->image = $directory . '/' . $filename;
                    $userInstance->save();
                    return response()->json(['success' => true, 'message' => 'Image uploaded successfully', 'url' => 'storage/' . $userInstance->image]);
                } else {
                    return response()->json(['error' => true, 'message' => 'No image file found']);
                }
            } else {
                return response()->json(['error' => true, 'message' => 'User not found']);
            }

        } catch (\Throwable $th) {
            ce($th->getMessage());
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }

    }
    public function fetchImage(Request $request)
    {
        try {
            if (!auth() && !$request->ajax()) {
                return response()->json(['error' => true, 'message' => 'Unautorize Access']);
            }
            $user = auth()->user();
            $class = get_class($user);
            $userInstance = $class::findOrFail($user->id);
            return response()->json('storage/' . $userInstance->image);
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return response()->json(['error' => true, 'message' => 'Unautorize Access']);
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|different:current_password',
            'confirm_password' => 'required|string|min:8|same:new_password',
        ]);
        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
        }
        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Password updated successfully.');
    }
    public function updateAccount(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
            ]);

            $user = auth()->user();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->address = $request->address;
            if (auth()->user()->dflt == 1) {
                if ($request->has('email') && $request->email !== $user->email) {
                    $user->email = $request->email;
                }
            }
            $user->save();
            return withSuccess('update');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withErrors(['error', $th->getMessage()]);
        }
    }

}
