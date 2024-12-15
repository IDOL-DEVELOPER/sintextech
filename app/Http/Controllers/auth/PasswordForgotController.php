<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetToken;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class PasswordForgotController extends Controller
{
    public function view()
    {
        return view('admin.login.password');
    }
    public function sendResetLink(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'userType' => 'required|in:admin',
            ]);

            $userType = $request->userType;
            $table = $this->getTableForUserType($userType);

            // Check if the email exists in the specified table
            $request->validate([
                'email' => "required|email|exists:$table,email",
            ]);

            // Delete any existing token for the email
            PasswordResetToken::where(['email' => $request->email, 'instance' => $userType])->delete();
            // Generate a new token and insert into the password_resets table
            $token = \Str::random(60);
            PasswordResetToken::create([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
                'instance' => $userType,
            ]);


            // Retrieve the user instance based on the email and user type
            $user = $this->getUserByEmail($request->email, $userType);

            if (!$user) {
                return back()->withErrors(['error' => 'User not found.']);
            }

            $data = [
                'token' => $token,
                'email' => $user->email,
                'name' => $user->name
            ];
            kvMail($user->email, $data, 'Password Reset Request', 'emails.forgot');
            return back()->with('success', 'Password reset link sent successfully');
        } catch (\Exception $e) {
            ce($e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    protected function getTableForUserType($userType)
    {
        switch ($userType) {
            case 'admin':
                return 'admins';
            default:
                throw new \Exception('Invalid user type.');
        }
    }

    protected function getUserByEmail($email, $userType)
    {
        $model = $this->getModelForUserType($userType);
        return $model::where('email', $email)->first();
    }

    protected function getModelForUserType($userType)
    {
        switch ($userType) {
            case 'admin':
                return \App\Models\Admin::class;
            default:
                throw new \Exception('Invalid user type.');
        }
    }

    public function showResetForm($token)
    {
        try {
            $token = PasswordResetToken::where('token', $token)->first();
            if ($token == null) {
                throw new \Exception("Token Expired. Please send another Forgot Password request.", 419);
            }
            return view('admin.login.forgot', compact('token'));
        } catch (\Throwable $th) {
            $errorCode = $th->getCode();
            $errorMessage = $th->getMessage();
            ce($th->getMessage());
            return response()->view('errors.error', compact('errorCode', 'errorMessage'), $errorCode);
        }
    }
    public function resetPassword(Request $request)
    {
        try {
            // Retrieve the token record
            $tokenRecord = PasswordResetToken::where('token', $request->token)->first();

            // Check if the token exists
            if ($tokenRecord == null) {
                return back()->withErrors(['error' => 'Token expired']);
            }

            // Validate the password fields
            $request->validate([
                'new_password' => 'required|min:8',
                'confirm_password' => 'required|same:new_password',
            ]);

            // Retrieve the user instance based on email and user type
            $user = $this->getUserByEmail($tokenRecord->email, $tokenRecord->instance);

            if ($user === null) {
                return back()->withErrors(['error' => 'User not found.']);
            }

            // Update the user's password
            $user->update([
                'password' => \Hash::make($request->new_password)
            ]);
            PasswordResetToken::where('token', $request->token)->delete();
            return redirect()->route('login')->with('success', 'Password reset successfully');
        } catch (ValidationException $e) {
            ce($e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            ce($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


}
