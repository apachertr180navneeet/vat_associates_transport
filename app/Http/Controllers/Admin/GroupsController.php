<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,
    Group
};
use Mail, DB, Hash, Validator, Session, File, Exception, Redirect, Auth;
use Illuminate\Validation\Rule;

class GroupsController extends Controller
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
        // Pass the company and comId to the view
        return view('admin.group.index');
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

        $branchs = Group::where('firm_id',$compId)->get();

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
            $User = Group::findOrFail($request->userId);
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
            Group::where('id', $id)->delete();

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
            'firm_id' =>  $compId
        ];
        Group::create($dataUser);
        return response()->json([
            'success' => true,
            'message' => 'Branch saved successfully!',
        ]);
    }

    // Fetch user data
    public function get($id)
    {
        $user = Group::find($id);
        return response()->json($user);
    }

    // Update user data
    public function update(Request $request)
    {
        $request->validate([
           'name' => 'required|string',
        ]);

        $user = Group::find($request->id);
        if ($user) {
            $user->update($request->all());
            return response()->json(['success' => true , 'message' => 'Branch Update Successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Branch not found']);
    }
}
