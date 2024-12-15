<?php

namespace App\Http\Controllers\locations;

use App\Http\Controllers\Controller;
use App\Models\Countries;
use App\Models\Districts;
use App\Models\States;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DistrictsController extends Controller
{
    public function view()
    {
        session()->put('referring_route', request()->route()->getName());
        $countries = Countries::all();
        return view("admin.locations.districts.view", compact('countries'));
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
                'district_name' => 'required|string|max:255',
                'state' => 'required|exists:states,id'
            ]);

            $Districts = new Districts();
            $Districts->name = $request->district_name;
            $Districts->sid = $request->state;
            $Districts->save();
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
                "id" => 'required|exists:districts,id',
                'district_name' => 'required|string|max:255',
                'state' => 'required|exists:states,id'
            ]);
            $Districts = Districts::findOrFail($request->id);
            $Districts->name = $request->district_name;
            $Districts->sid = $request->state;
            $Districts->save();
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
                "id" => 'required|exists:districts,id',
            ]);
            $Districts = Districts::findOrFail($request->id);
            $Districts->delete();
            return withSuccess("delete");
        } catch (\Throwable $th) {
            return back()->withErrors(["error" => $th->getMessage()]);
        }
    }
    public function districtsFetch(Request $request)
    {
        try {
            if (!check() && !$request->ajax() && !user()->hasPermission('write', 'update')) {
                ce("unAuthorized Access Not Allowed");
                return response()->json(["error" => true, "message" => "unAuthorized access not allowed"]);
            }
            if ($request->state != null) {
                $request->validate([
                    "state" => "required|exists:states,id"
                ]);
                $sates = States::findOrFail($request->state);
                $response = $sates->districts;
                return response()->json($response);
            }
        } catch (\Throwable $th) {
            if ($request->state != null) {
                ce($th->getMessage());
                return response()->json(["error" => true, "message" => $th->getMessage()]);
            }
        }
    }
}
