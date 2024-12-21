<?php

namespace App\Http\Controllers\Api\Business\Backend;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessProfileController extends Controller
{

    use ApiResponse;





    public function create()
    {
        //
    }



    // __store business profile
    public function store(Request $request)
    {
        // Step 1: Validate the incoming request data
        $validatedData = $request->validate([
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'business_name' => 'required|string',
            'category_id' => 'required|integer',
            'sub_category_id' => 'required|integer',
            'activity' => 'required|string',
            'operation_days_start' => 'required|string',
            'operation_days_end' => 'required|string',
            'open_time' => 'required|string',
            'close_time' => 'required|string',
            'street_address' => 'required|string',
            'city' => 'required|string',
        ]);

        // Step 2: Create a new business profile record
        $businessProfile = BusinessProfile::create([
            'user_id' => Auth::id(),
            'business_name' => $validatedData['business_name'],
            'category_id' => $validatedData['category_id'],
            'sub_category_id' => $validatedData['sub_category_id'],
            'activity' => $validatedData['activity'],
            'operation_days_start' => $validatedData['operation_days_start'],
            'operation_days_end' => $validatedData['operation_days_end'],
            'open_time' => $validatedData['open_time'],
            'close_time' => $validatedData['close_time'],
            'street_address' => $validatedData['street_address'],
            'city' => $validatedData['city'],
        ]);

        // Step 3: Handle file upload for the cover image, if provided
        if ($request->hasFile('cover')) {
            $coverPath = Helper::uploadImage($request->file('cover'), 'business_profiles');
            $businessProfile->cover = $coverPath;
            $businessProfile->save();
        }

        // Step 4: Set the full URL for the cover image
        $businessProfile->cover = url($businessProfile->cover);

        // Step 5: Return a success response with the created business profile
        return $this->success($businessProfile, 'Business Profile created successfully', 200);


    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
