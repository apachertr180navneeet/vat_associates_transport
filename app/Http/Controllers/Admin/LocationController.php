<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{
    User,
    Location
};
use Mail, DB, Hash, Validator, Session, File, Exception, Redirect, Auth;



class LocationController extends Controller
{
    /**
     * Display the User index page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Pass the company and comId to the view
        return view('admin.location.index');
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

        $location = Location::where('firm_id',$compId)->orderBy('id', 'desc')->get();
        return response()->json(['data' => $location]);
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
            $User = Location::findOrFail($request->userId);
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
            Location::where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Variation deleted successfully',
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
            'name' => 'required|string|max:255',
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
            'firm_id' => $compId
        ];
        Location::create($dataUser);

        return response()->json([
            'success' => true,
            'message' => 'Variation saved successfully!',
        ]);
    }

    // Fetch user data
    public function get($id)
    {
        $user = Location::find($id);
        return response()->json($user);
    }

    // Update user data
    public function update(Request $request)
    {
        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ]);
        }

        $user = Location::find($request->id);
        if ($user) {
            $user->update($request->all());
            return response()->json(['success' => true , 'message' => 'Variation Update Successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Variation not found']);
    }
}
