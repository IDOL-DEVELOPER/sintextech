<?php

namespace App\Http\Controllers\locations;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CountriesController extends Controller
{
    public function view()
    {
        session()->put('referring_route', request()->route()->getName());
        return view("admin.locations.countries.view");
    }
    public function action(Request $request)
    {
        try {
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

        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withErrors(["error" => $th->getMessage()]);
        }
    }
    protected function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $countries = new Countries();
            $countries->name = $request->name;
            $countries->save();
            return withSuccess("create");
        } catch (ValidationException $e) {
            ce($e->getMessage());
            return back()->withErrors($e->validator->errors())->withInput()->with('keepModalOpen', true);
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withInput()->withErrors(["error" => $th->getMessage()])->with('keepModalOpen', true);
        }
    }
    protected function update(Request $request)
    {
        try {
            $request->validate([
                "id" => 'required|exists:countries,id',
                'name' => 'required|string|max:255',
            ]);
            $countries = Countries::findOrFail($request->id);
            $countries->name = $request->name;
            $countries->save();
            return withSuccess("update");
        } catch (ValidationException $e) {
            ce($e->getMessage());
            return back()->withErrors($e->validator->errors())->withInput()->with('keepModalOpen', true);
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withInput()->withErrors(["error" => $th->getMessage()])->with('keepModalOpen', true);
        }
    }
    protected function delete(Request $request)
    {
        try {
            $request->validate([
                "id" => 'required|exists:countries,id',
            ]);
            $countries = Countries::findOrFail($request->id);
            $countries->delete();
            return withSuccess("delete");
        } catch (\Throwable $th) {
            return back()->withErrors(["error" => $th->getMessage()]);
        }
    }
}
