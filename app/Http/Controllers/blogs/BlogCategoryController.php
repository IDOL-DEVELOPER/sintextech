<?php

namespace App\Http\Controllers\blogs;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BlogCategoryController extends Controller
{
    public function view()
    {
        session()->put('referring_route', request()->route()->getName());
        return view('admin.blog.category.view');
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
            $request->validate(['name' => 'required|unique:category,name']);
            Category::create(['name' => $request->name]);
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
                'id' => 'required|exists:category,id',
                'name' => 'required|unique:category,name'
            ]);
            $category = Category::findOrFail($request->id);
            $category->update(['name' => $request->name]);
            return withSuccess('update');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withInput()->withErrors(["error" => $th->getMessage()])->with('keepModalOpen', true);
        }
    }
    protected function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:category,id',
            ]);
            $category = Category::findOrFail($request->id);
            $category->delete();
            return withSuccess('delete');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withInput()->withErrors(["error" => $th->getMessage()])->with('keepModalOpen', true);
        }
    }
}
