<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{
    User,
    Branches,
    Department,
    Employee

};
use Mail, DB, Hash, Validator, Session, File, Exception, Redirect, Auth;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
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

        $branchs = Branches::where('firmid',$compId)->where('status','active')->orderBy('id', 'desc')->get();
        $departments = Department::where('firm_id',$compId)->where('status','active')->orderBy('id', 'desc')->get();
        // Pass the company and comId to the view
        return view('admin.employee.index', compact('branchs','departments'));
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

        $branchs = Employee::join('departments', 'employees.deaprtment', '=', 'departments.id')
        ->join('branches', 'employees.breanch', '=', 'branches.id')
        ->where('employees.firm_id',$compId)
        ->select('employees.*', 'departments.name as departments_name', 'branches.name as branches_name')
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
            $User = Employee::findOrFail($request->userId);
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
            Employee::where('id', $id)->delete();

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
            'email' => 'required|unique:employees,email',
            'contact' => 'required|unique:employees,contact',
            'deaprtment' => 'required',
            'breanch' => 'required',
            'birthday' => 'required',
            'anniversary' => 'required',
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
            'email' => $request->email,
            'contact' => $request->contact,
            'deaprtment' => $request->deaprtment,
            'breanch' => $request->breanch,
            'birthday' => $request->birthday,
            'anniversary' => $request->anniversary,
            'firm_id' =>  $compId
        ];
        Employee::create($dataUser);
        return response()->json([
            'success' => true,
            'message' => 'Branch saved successfully!',
        ]);
    }

    // Fetch user data
    public function get($id)
    {
        $user = Employee::find($id);
        return response()->json($user);
    }

    // Update user data
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'deaprtment' => 'required',
            'breanch' => 'required',
            'birthday' => 'required',
            'anniversary' => 'required',
            'id' => 'required|integer|exists:employees,id', // Adjust as needed
            'email' => [
                'required',
                Rule::unique('employees', 'email')->ignore($request->id), // Ensure account number is unique, ignoring the current record
            ],
            'contact' => [
                'required',
                Rule::unique('employees', 'contact')->ignore($request->id), // Ensure account number is unique, ignoring the current record
            ],
        ]);

        $user = Employee::find($request->id);
        if ($user) {
            $user->update($request->all());
            return response()->json(['success' => true , 'message' => 'Branch Update Successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Branch not found']);
    }
}
