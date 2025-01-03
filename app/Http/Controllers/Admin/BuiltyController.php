<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{
    User,
    Location,
    Branches,
    Vendor,
    City,
    Item,
    Builty,
    BuiltyItem
};
use Mail, DB, Hash, Validator, Session, File, Exception, Redirect, Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BuiltyController extends Controller
{
    /**
     * Display the User index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        $compId = $user->firm_id;

        $builtys = Builty::where('builty.firm_id', $compId)
                   ->join('branches', 'builty.branch', '=', 'branches.id')
                   ->join('vendors as consigner', 'builty.consigner', '=', 'consigner.id')
                   ->join('vendors as conignee', 'builty.conignee', '=', 'conignee.id')
                   ->join('cities as from', 'builty.consigner', '=', 'from.id')
                   ->join('cities as to', 'builty.conignee', '=', 'to.id')
                   ->select('builty.*', 'branches.name as branch_name' , 'consigner.name as consigner_name' , 'conignee.name as conignee_name' , 'from.city_name as from_name' , 'to.city_name as to_name')
                   ->get();

        return view('admin.builty.index', compact('builtys'));
    }



    public function add()
    {
        $user = Auth::user();
        $compId = $user->firm_id;
        $currentDate = Carbon::now()->toDateString();

        // Retrieve all active branches, vendors, and cities in a single query each
        $branchs = Branches::where('firmid', $compId)->where('status', 'active')->get();
        $vendors = Vendor::where('firm_id', $compId)
            ->where('status', 'active')
            ->get()
            ->groupBy('type'); // Group vendors by type to separate consignees and consigners

        $cites = City::all(); // Retrieve all cities

        $items = Item::where('firm_id', $compId)->get(); // Retrieve items

        // Extract consignees and consigners from the grouped vendors
        $consignees = $vendors->get('consignee', collect());
        $consigners = $vendors->get('consigner', collect());

        // Return view with compacted data
        return view('admin.builty.add', compact('currentDate', 'compId', 'branchs', 'consignees', 'consigners', 'cites', 'items'));
    }


    public function store(Request $request)
    {
        // Validate the request data
        // $validatedData = $request->validate([
        //     'date' => 'required|date',
        //     'type' => 'required',
        //     'branch' => 'required|exists:branches,id',
        //     'grn' => 'required',
        //     'consigner' => 'required|exists:vendors,id',
        //     'conignee' => 'required|exists:vendors,id',
        //     'form_city' => 'required',
        //     'to_city' => 'required',
        //     'good_location' => 'required|exists:branches,id',
        //     'no_of_package' => 'required|numeric',
        //     'total_price' => 'required|numeric',
        //     'items' => 'required|array|min:1',
        //     'items.*' => 'exists:items,id',
        //     'freight_charge' => 'required|array|min:1',
        //     'freight_charge.*' => 'required|numeric|min:1',
        //     'surcharge' => 'required|array|min:1',
        //     'surcharge.*' => 'required|numeric|min:0',
        //     'cover' => 'required|array|min:1',
        //     'cover.*' => 'required|numeric|min:0',
        //     'h' => 'required|array|min:1',
        //     'h.*' => 'required|numeric|min:0',
        //     'insurance' => 'required|array|min:1',
        //     'insurance.*' => 'required|numeric|min:0',
        //     'heading' => 'required|array|min:1',
        //     'heading.*' => 'required|numeric|min:0',
        //     'cps' => 'required|array|min:1',
        //     'cps.*' => 'required|numeric|min:0',
        //     'total' => 'required|array|min:1',
        //     'total.*' => 'required|numeric|min:0',
        // ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Add Builty
            $builty = Builty::create([
                'firm_id' => $request->compid,
                'date' => $request->date,
                'type' => $request->type,
                'branch' => $request->branch,
                'grno' => $request->grn,
                'consigner' => $request->consigner,
                'conignee' => $request->conignee,
                'from_city' => $request->form_city,
                'to_city' => $request->to_city,
                'good_location' => $request->good_location,
                'no_of_package' => $request->no_of_package,
                'total_price' => $request->total_price,
            ]);

            foreach ($request->items as $index => $itemId) {
                $item = BuiltyItem::create([
                    'builty_item_id' => $builty->id,
                    'item' => $itemId,
                    'freight_charge' => $request->freight_charge[$index],
                    'surcharge' => $request->surcharge[$index],
                    'cover' => $request->cover[$index],
                    'h' => $request->h[$index],
                    'insurance' => $request->insurance[$index],
                    'heading' => $request->heading[$index],
                    'cps' => $request->cps[$index],
                    'total' => $request->total[$index],
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Redirect with success message
            return redirect()->route('admin.builty.index')
                ->with('success', 'Builty entry saved successfully.');

        } catch (\Exception $e) {
            dd($e);
            // Rollback the transaction on error
            DB::rollback();

            // Redirect back with error message and old input
            return redirect()->back()
                ->withInput()
                ->with('error', 'An error occurred while saving the Builty entry.');
        }
    }

    /**
     * Force Delete a User by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            // Force delete the main record
            Builty::where('id', $id)->forceDelete();

            // Force delete associated items
            BuiltyItem::where('builty_item_id', $id)->forceDelete();

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

    /**
     * Update the status of a User.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request)
    {
        try {
            $User = Builty::findOrFail($request->userId);
            $User->status = $request->status;
            $User->save();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    // Fetch user data
    public function edit($id)
    {
        $user = Auth::user();
        $compId = $user->firm_id;
        $currentDate = Carbon::now()->toDateString();

        // Retrieve all active branches, vendors, and cities in a single query each
        $branchs = Branches::where('firmid', $compId)->where('status', 'active')->get();
        $vendors = Vendor::where('firm_id', $compId)
            ->where('status', 'active')
            ->get()
            ->groupBy('type'); // Group vendors by type to separate consignees and consigners

        $cites = City::all(); // Retrieve all cities

        $items = Item::where('firm_id', $compId)->get(); // Retrieve items

        // Extract consignees and consigners from the grouped vendors
        $consignees = $vendors->get('consignee', collect());
        $consigners = $vendors->get('consigner', collect());

        $builty = Builty::find($id);


        // Return view with compacted data
        return view('admin.builty.edit', compact('currentDate', 'compId', 'branchs', 'consignees', 'consigners', 'cites', 'items','builty'));
    }
}
