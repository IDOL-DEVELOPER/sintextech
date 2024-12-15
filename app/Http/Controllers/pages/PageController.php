<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use App\Models\Pages;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PageController extends Controller
{
    public function view()
    {
        session()->put('referring_route', request()->route()->getName());
        return view('admin.pages.view');
    }

    public function form($slug = "")
    {
        $page = $slug ? Pages::where('slug', $slug)->firstOrFail() : new Pages();
        return view('admin.pages.form', compact('page'));
    }

    public function action(Request $request)
    {
        $request->validate([
            "action" => 'required|in:create,update'
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
            // case 'delete':
            //     if (check() && user()->hasPermission('delete')) {
            //         return $this->delete($request);
            //     } else {
            //         ce("Unautorize Permission Access Not Allowed For Delete");
            //         return back()->withErrors(["error"], "Unautorize Permission Access Not Allowed");
            //     }
            default:
                ce("Invalid action");
                return back()->withErrors(['error' => 'Invalid action']);
        }
    }
    protected function create(Request $request)
    {
        try {
            $request->validate(
                [
                    'name' => 'required|unique:pages,name',
                    'slug' => 'required|unique:pages,slug',
                    'content' => 'required|string',
                ]
            );
            Pages::create($request->only(['name', 'slug', 'content']));
            return withSuccess('create');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    protected function update(Request $request)
    {
        try {
            $request->validate(
                [
                    'id' => 'required|exists:pages,id',
                    'name' => 'required|unique:pages,name,' . $request->id,
                    'slug' => 'required|unique:pages,slug,' . $request->id,
                    'content' => 'required|string',
                ]
            );
            Pages::whereId($request->id)->update($request->only(['name', 'slug', 'content']));
            return withSuccess('update');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
