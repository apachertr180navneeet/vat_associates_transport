<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{
    User,
    Mesurment,
    Method,
    Group,
    Item

};
use Mail, DB, Hash, Validator, Session, File, Exception, Redirect, Auth;
use Illuminate\Validation\Rule;

class ItemController extends Controller
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

        $measurments = Mesurment::where('firm_id',$compId)->where('status','active')->orderBy('id', 'desc')->get();
        $methods = Method::where('firm_id',$compId)->where('status','active')->orderBy('id', 'desc')->get();
        $groups = Group::where('firm_id',$compId)->where('status','active')->orderBy('id', 'desc')->get();
        // Pass the company and comId to the view
        return view('admin.item.index', compact('measurments', 'groups', 'methods'));
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

        $branchs = Item::where('firm_id',$compId)
        ->select('items.*')
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
            $User = Item::findOrFail($request->userId);
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
            Item::where('id', $id)->delete();

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
            'skucode' => 'required|unique:items,skucode',
            'measurment' => 'required',
            'group' => 'required',
            'method' => 'required',
            'open_stock' => 'required',
            'price' => 'required',
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
            'skucode' => $request->skucode,
            'measurment' => $request->measurment,
            'group' => $request->group,
            'method' => $request->method,
            'open_stock' => $request->open_stock,
            'price' => $request->price,
            'firm_id' =>  $compId
        ];
        Item::create($dataUser);
        return response()->json([
            'success' => true,
            'message' => 'Branch saved successfully!',
        ]);
    }

    // Fetch user data
    public function get($id)
    {
        $user = Item::find($id);
        return response()->json($user);
    }

    // Update user data
    public function update(Request $request)
    {
        $request->validate([
           'name' => 'required|string',
            'measurment' => 'required',
            'group' => 'required',
            'method' => 'required',
            'open_stock' => 'required',
            'price' => 'required',
            'id' => 'required|integer|exists:items,id', // Adjust as needed
            'skucode' => [
                'required',
                Rule::unique('items', 'skucode')->ignore($request->id), // Ensure account number is unique, ignoring the current record
            ],
        ]);

        $user = Item::find($request->id);
        if ($user) {
            $user->update($request->all());
            return response()->json(['success' => true , 'message' => 'Branch Update Successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Branch not found']);
    }
}
