<?php
use App\Models\Menus;
use App\Mail\Email;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\WebData;
use Illuminate\Support\Facades\Route;

function getFirst50Words($content)
{
    // Split the content into words by spaces
    $words = preg_split('/\s+/', $content, -1, PREG_SPLIT_NO_EMPTY);

    // Get the first 50 words
    $first50Words = array_slice($words, 0, 50);

    // Join them back into a string
    $shortContent = implode(' ', $first50Words);

    return $shortContent;
}
if (!function_exists('df')) {
    function df($date, $format)
    {
        try {
            $dateTime = new DateTime($date);
            return $dateTime->format($format);
        } catch (Exception $e) {
            return $date;
        }
    }
}
function make_slug($string)
{
    $slug = preg_replace('/\s+/u', '-', trim($string));
    $slug = str_replace("/", "", $slug);
    $slug = str_replace("?", "", $slug);
    return strtolower($slug);
}
// if (!function_exists('ce')) {
//     function ce($message)
//     {
//         $routeAction = Route::currentRouteAction();
//         list($controller, $method) = explode('@', $routeAction);
//         $controllerName = class_basename($controller);
//         $user = user();
//         $userDetails = $user ? $user->name . ' (' . $user->email . ')' : 'Guest';
//         \Log::channel('ce')->error('Error in ' . $controllerName, [
//             'user' => $userDetails,
//             'message' => $message,
//             'ip' => request()->ip(),
//             'url' => request()->fullUrl(),
//         ]);
//     }
// }

if (!function_exists('ce')) {
    function ce($message)
    {
        // Get the current route action
        $routeAction = Route::currentRouteAction();
        list($controller, $method) = explode('@', $routeAction);
        $controllerName = class_basename($controller);

        // Get user details
        $user = user();
        $userDetails = $user ? $user->name . ' (' . $user->email . ')' : 'Guest';

        // Get the error information
        $debugTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $errorLine = isset($debugTrace[1]['line']) ? $debugTrace[1]['line'] : 'Unknown Line';
        $errorFunction = isset($debugTrace[1]['function']) ? $debugTrace[1]['function'] : 'Unknown Function';

        // Log the error
        \Log::channel('ce')->error('Error in ' . $controllerName . ' at line ' . $errorLine . ' in function ' . $errorFunction, [
            'user' => $userDetails,
            'message' => $message,
            'ip' => request()->ip(),
            'url' => request()->fullUrl(),
        ]);
    }
}

if (!function_exists('withSuccess')) {
    function withSuccess($action = "")
    {
        $action = strtolower($action);
        switch ($action) {
            case 'create':
                $defaultMessage = 'Record Added Successfully';
                break;
            case 'update':
                $defaultMessage = 'Record Updated Successfully';
                break;
            case 'delete':
                $defaultMessage = 'Record Deleted Successfully';
                break;
            default:
                $defaultMessage = 'Operation Successful';
                break;
        }
        return back()->with("success", $defaultMessage);
    }
}
if (!function_exists('returnSuccess')) {
    function returnSuccess($action)
    {
        return new \App\Helpers\SuccessHandler($action);
    }
}

function menu()
{
    if (user()->instance() == "admin" && user()->dflt == true) {
        $filterMenus = Menus::where(function ($query) {
            $query->where('nav', '!=', 1)
                ->where('nextside', '!=', 1);
        })->get();
        return $filterMenus;
    }
    $menus = Menus::where(function ($query) {
        $query->where('nav', '!=', 1)
            ->where('nextside', '!=', 1);
    })->get();
    $filteredMenus = $menus->filter(function ($menu) {
        $menupr = $menu->permissions()
            ->where('uid', user()->id)
            ->where('user_type', user()->instance())
            ->where('read', true)
            ->exists();
        if ($menu->collapse == 1) {
            $submenuReadPermissionCount = $menu->submenu()
                ->whereHas('permissions', function ($query) {
                    $query->where('uid', user()->id)
                        ->where('user_type', user()->instance())
                        ->where('read', true);
                })->count();
            return $menupr && $submenuReadPermissionCount > 0;
        } else {
            return $menupr;
        }
    });
    $dfltmenu = Menus::where('dflt', 1)->get();
    $filterMenus = $filteredMenus->merge($dfltmenu);
    return $filterMenus;
}
function navmenu()
{

    if (user()->instance() == "admin" && user()->dflt == true) {
        $filterMenus = Menus::where(function ($query) {
            $query->where('nav', 1);
        })->get();
        return $filterMenus;
    }
    $menus = Menus::where(function ($query) {
        $query->where('nav', 1);
    })->get();
    $filterMenus = $menus->filter(function ($menu) {
        $menupr = $menu->permissions()
            ->where('uid', user()->id)
            ->where('user_type', user()->instance())
            ->where('read', true)
            ->exists();
        if ($menu->collapse == 1) {
            $submenuReadPermissionCount = $menu->submenu()
                ->whereHas('permissions', function ($query) {
                    $query->where('uid', user()->id)
                        ->where('user_type', user()->instance())
                        ->where('read', true);
                })->count();
            return $menupr && $submenuReadPermissionCount > 0;
        } else {
            return $menupr;
        }
    });
    return $filterMenus;
}

function sidemenu()
{

    if (user()->instance() == "admin" && user()->dflt == true) {
        $filterMenus = Menus::where('nav', 1)
            ->orWhere('nextside', 1)
            ->get();
        return $filterMenus;
    }
    $menus = Menus::where('nav', 1)
        ->orWhere('nextside', 1)
        ->get();
    ;
    $filterMenus = $menus->filter(function ($menu) {
        $menupr = $menu->permissions()
            ->where('uid', user()->id)
            ->where('user_type', user()->instance())
            ->where('read', true)
            ->exists();
        if ($menu->collapse == 1) {
            $submenuReadPermissionCount = $menu->submenu()
                ->whereHas('permissions', function ($query) {
                    $query->where('uid', user()->id)
                        ->where('user_type', user()->instance())
                        ->where('read', true);
                })->count();
            return $menupr && $submenuReadPermissionCount > 0;
        }
    });
    return $filterMenus;
}


function webData()
{
    $setting = WebData::with(['logo', 'favicon'])->first() ?? new WebData();
    return $setting;
}


function setting($name)
{
    $setting = Setting::where('name', $name)->first();
    return $setting ? $setting->value : null;
}
function lowerUniqueIds()
{
    return strtolower(substr(md5(uniqid(rand(), true)), 0, 30));
}
//------Mail------//
if (!function_exists('kvMail')) {
    function kvMail($tomail, $data = '', $subject = '', $template = '', $htmlcontent = '')
    {
        Mail::to($tomail)->queue(new Email($data, $subject, $template, $htmlcontent));
    }
}

