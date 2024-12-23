<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{
    User,
    Department,
    Departmenttype,
    Departmentlevel
};
use Mail, DB, Hash, Validator, Session, File, Exception, Redirect, Auth;
use Illuminate\Validation\Rule;

class DeapartmentController extends Controller
{
    /**
     * Display the User index page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $compId = $user->firm_id;

        $types = Departmenttype::where('firm_id',$compId)->where('status','active')->orderBy('id', 'desc')->get();
        $levels = Departmentlevel::where('firm_id',$compId)->where('status','active')->orderBy('id', 'desc')->get();
        // Pass the company and comId to the view
        return view('admin.department.index', compact('types','levels'));
    }

    /**
     * Fetch all companies and return as JSON.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getall(Request $request)
    {
        $user = Auth::user();

        $compId = $user->firm_id;

        $branchs = Department::join('departmenttypes', 'departments.type', '=', 'departmenttypes.id')
        ->join('departmentlevels', 'departments.level', '=', 'departmentlevels.id')
        ->where('departments.firm_id',$compId)
        ->select('departments.*', 'departmentlevels.name as departmentlevels_name', 'departmenttypes.name as departmenttypes_name')
        ->get();

        return response()->json(['data' => $branchs]);
    }

    /**
     * Update the status of a User.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request)
    {
        try {
            $User = Department::findOrFail($request->userId);
            $User->status = $request->status;
            $User->save();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Delete a User by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            Department::where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Branch deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string',
            'type' => 'required',
            'level' => 'required',
            'descrption' => 'required',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $user = Auth::user();

        $compId = $user->firm_id;
        // Save the User data
        $dataUser = [
            'name' => $request->name,
            'type' => $request->type,
            'level' => $request->level,
            'descrption' => $request->descrption,
            'firm_id' =>  $compId
        ];
        Department::create($dataUser);
        return response()->json([
            'success' => true,
            'message' => 'Branch saved successfully!',
        ]);
    }

    // Fetch user data
    public function get($id)
    {
        $user = Department::find($id);
        return response()->json($user);
    }

    // Update user data
    public function update(Request $request)
    {
        $request->validate([
           'name' => 'required|string',
            'type' => 'required',
            'level' => 'required',
            'descrption' => 'required',
            'id' => 'required|integer|exists:departments,id', // Adjust as needed
        ]);

        $user = Department::find($request->id);
        if ($user) {
            $user->update($request->all());
            return response()->json(['success' => true , 'message' => 'Branch Update Successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Branch not found']);
    }
}
