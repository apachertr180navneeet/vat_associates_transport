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
    Item
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

        return view('admin.builty.index');
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
}
