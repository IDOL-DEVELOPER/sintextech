<?php

namespace App\Http\Controllers\setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\WebData;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    public function view()
    {
        if (auth() && user()->instance() == "admin" && user()->dflt == 1) {
            $websiteData = WebData::first() ?? new WebData();

            return view('admin.setting.view', compact('websiteData'));
        } else {
            return abort(404);
        }
    }
 
    public function action(Request $request)
    {
        if (!auth() && !user()->instance() == "admin" && !user()->dflt == 1) {
            return abort(404);
        }
        $request->validate([
            "action" => 'required|in:createUpdate,webData'
        ]);
        $action = $request->action;
        switch ($action) {
            case 'createUpdate':
                if (check() && user()->hasPermission('create,update')) {
                    return $this->createUpdate($request);
                } else {
                    ce("Unautorize Permission Access Not Allowed For Delete");
                    return back()->withErrors(["error"], "Unautorize Permission Access Not Allowed");
                }
            case 'webData':
                if (check() && user()->hasPermission('create,update')) {
                    return $this->webDataUpdate($request);
                } else {
                    ce("Unautorize Permission Access Not Allowed For Delete");
                    return back()->withErrors(["error"], "Unautorize Permission Access Not Allowed");
                }
            default:
                ce("Invalid action");
                return back()->withErrors(['error' => 'Invalid action']);
        }
    }
    public function createUpdate(Request $request)
    {
        if (!auth() && !user()->instance() == "admin" && !user()->dflt == 1) {
            return abort(404);
        }
        $requestData = $request->all();
        foreach ($requestData as $key => $value) {
            $setting = Setting::where('name', $key)->firstOrNew();
            $setting->value = $value;
            $setting->name = $key;
            $setting->save();
        }
        $this->update_env();
        return withSuccess('update');
    }
    private function update_env()
    {
        $sitename = setting('site_name');
        $data = [
            'APP_NAME' => "'$sitename'" ?? 'site_name',
            'MAIL_HOST' => setting('mail_host') ?? 'smtp.gmail.com',
            'MAIL_PORT' => setting('mail_port') ?? '587',
            'MAIL_USERNAME' => setting('mail_username') ?? 'example.gmail.com',
            'MAIL_PASSWORD' => setting('mail_password') ?? '',
            'MAIL_ENCRYPTION' => setting('mail_encryption') ?? 'tls',
            'MAIL_FROM_ADDRESS' => setting('mail_username') ?? 'example.gmail.com',
            'MAIL_FROM_NAME' => setting('mail_name') ?? 'site_name',
            'GOOGLE_CLIENT_ID' => setting('google_client') ?? '',
            'GOOGLE_CLIENT_SECERET' => setting('google_seceret') ?? '',
        ];

        // Get the contents of the existing .env file
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        // Replace the values in the .env file with the new values
        foreach ($data as $key => $value) {
            // Match the key and replace its value
            $pattern = "/^{$key}=.*/m";
            $newValue = "{$key}={$value}";
            $envContent = preg_replace($pattern, $newValue, $envContent);
        }
        // Write the updated content back to the .env file
        \File::put($envFile, $envContent);
    }

    protected function webDataUpdate(Request $request)
    {
        try {
            $request->validate([
                'logo' => 'required|numeric',
                'favicon' => 'required|numeric',
            ]);
            $websiteData = WebData::updateOrCreate(['id' => $request->id], ['websitelogo' => $request->logo, 'websitesmallogo' => $request->favicon]);
            return withSuccess('update');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }
}
