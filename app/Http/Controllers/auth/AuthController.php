<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function view()
    {
        return view('admin.login.view');
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string',
                "email" => "required|email|exists:admins,email",
            ]);
            $credentials = $request->only('email', 'password');
            $guard = 'admin';
            if (Auth::guard($guard)->attempt($credentials)) {
                $user = Auth::guard($guard)->user();
                if ($user->status != 1) {
                    Auth::logout();
                    session()->flush();
                    session()->regenerate();
                    return back()->withInput()->withErrors(["error" => "Your account is blocked. Please contact support."]);
                }
                $request->session()->regenerate();
                return redirect()->route('dms.dash')->with('success', 'Login success');
            } else {
                return back()->withInput()->withErrors(["error" => "Invalid credentials"]);
            }

        } catch (ValidationException $e) {
            ce($e->getMessage());
            return redirect()->route('login')->withInput()->withErrors(["error" => $e->getMessage()]);
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return redirect()->route('login')->withInput()->withErrors(["error" => $th->getMessage()]);
        }
    }

    //google auth
    public function googleLogin()
    {
        if (setting('google_login') != true) {
            return abort(404);
        }
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }
    public function googleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->user();
            $existingUser = User::where('email', $user->getEmail())->first();
            if (!$existingUser) {
                // If user does not exist, create a new user
                $newUser = new User();
                $newUser->google_id = $user->getId();
                $newUser->name = $user->getName();
                $newUser->email = $user->getEmail();
                $newUser->password = Hash::make($user->getName() . '@' . $user->getId());
                $newUser->email_verified_at = now();
                $newUser->remember_token = Str::random(60);
                $newUser->save();
                // Send welcome email
                $data = [
                    'name' => $newUser->name,
                    'email' => $newUser->email,
                ];
                //$mailSender = new mailSend();
                //$mailSender->Sendmail($user->getEmail(), $data, emailsubject('register'), 'emails.register');
                //notification event
                //Event::dispatch(new UserRegistered($newUser));
                Auth::login($newUser);
                $request->session()->regenerate();
            } else {
                $existingUser->google_id = $user->getId();
                $existingUser->save();
                Auth::login($existingUser);
                $request->session()->regenerate();
            }
            if (Auth::check()) {
                return redirect()->intended('/')->with('success', 'Login successfully');
            } else {
                return redirect()->route('login')->with('error', 'Authentication failed');
            }
        } catch (\Throwable $th) {
            return back()->withErrors(['error', 'Login error connect with administor']);
        }
    }
    public function logout()
    {
        Auth::logout();
        session()->flush();
        session()->regenerate();
        return redirect()->route('login')->with(['success' => 'Logged out successfully']);
    }
}
