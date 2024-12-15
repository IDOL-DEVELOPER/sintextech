<?php

namespace App\Http\Controllers\blogs;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BlogController extends Controller
{
    public function view()
    {
        session()->put('referring_route', request()->route()->getName());
        return view('admin.blog.view');
    }
    public function draft()
    {
        session()->put('referring_route', request()->route()->getName());
        return view('admin.blog.draft');
    }
    public function published()
    {
        session()->put('referring_route', request()->route()->getName());
        return view('admin.blog.publish');
    }
    public function form($slug = "")
    {
        $blog = $slug ? Blog::where('slug', $slug)->firstOrFail() : new Blog();
        $categories = Category::all();
        return view('admin.blog.form', compact('blog', 'categories'));
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
            default:
                ce("Invalid action");
                return back()->withErrors(['error' => 'Invalid action']);
        }
    }
    protected function create(Request $request)
    {
        try {

            $request->validate([
                'categories' => 'required|array|min:1',
                'categories.*' => 'required|exists:category,id',
                'title' => 'required|max:255|unique:blog,title',
                'content' => 'nullable|string',
                'breif_description' => 'nullable|string|max:255',
                'meta_keywords' => 'nullable|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'tags' => 'nullable|string',
                'status' => 'boolean',
                'image' => 'required|exists:upload,id',
            ]);
            $slug = make_slug($request->title);
            $blog = Blog::create([
                'title' => $request->title,
                'content' => $request->content,
                'brief' => $request->breif_description,
                'meta_key' => $request->meta_keywords,
                'meta_title' => $request->meta_title,
                'meta_desc' => $request->meta_description,
                'slug' => $slug,
                'status' => $request->status,
                'tags' => $request->tags,
                'image_id' => $request->image,
                'auth_id' => user()->id,
                'instance_created' => user()->instance()
            ]);
            $blog->categories()->sync($request->categories);
            return redirect()->route('admin.blog')->with('success', 'Record created successfully');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }
    protected function update(Request $request)
    {
        try {
            //dd($request->all());
            $request->validate([
                'id' => 'required|exists:blog,id',
                'categories' => 'required|array|min:1',
                'categories.*' => 'required|exists:category,id',
                'title' => 'required|max:255|',
                'content' => 'nullable|string',
                'breif_description' => 'nullable|string|max:255',
                'meta_keywords' => 'nullable|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'tags' => 'nullable|string',
                'status' => 'boolean',
                'image' => 'sometimes|exists:upload,id',
            ]);
            $blog = Blog::findOrFail($request->id);
            if ($request->title != $blog->title) {
                $request->validate([
                    'title' => 'required|max:255|unique:blog,title'
                ]);
                $slug = make_slug($request->title);
            } else {
                $slug = $blog->slug;
            }
            if ($request->image == null) {
                $image = $blog->image_id;
            } else {
                $image = $request->image;
            }
            $blog->update([
                'title' => $request->title,
                'content' => $request->content,
                'brief' => $request->breif_description,
                'meta_key' => $request->meta_keywords,
                'meta_title' => $request->meta_title,
                'meta_desc' => $request->meta_description,
                'slug' => $slug,
                'status' => $request->status,
                'tags' => $request->tags,
                'image_id' => $image,
                'auth_id' => user()->id,
                'instance_created' => user()->instance()
            ]);
            $blog->categories()->sync($request->categories);
            return redirect()->route('admin.blog')->with('success', 'Record updated successfully');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }
}
