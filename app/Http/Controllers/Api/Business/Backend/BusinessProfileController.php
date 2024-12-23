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

        $validatedData = $request->validate([
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'business_name' => 'required|string',
            'category_id' => 'required|integer',
            'sub_category_id' => 'required|integer',
            'activity' => 'required|in:Indoor,Outdoor',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'hours' => 'required|array',
            'hours.*.day' => 'required|string',
            'hours.*.is_closed' => 'required|boolean',
            'hours.*.open_time' => 'nullable|string',
            'hours.*.close_time' => 'nullable|string',
        ]);

        $businessProfile = BusinessProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'business_name' => $validatedData['business_name'],
                'category_id' => $validatedData['category_id'],
                'sub_category_id' => $validatedData['sub_category_id'],
                'activity' => $validatedData['activity'],
                'street_address' => $validatedData['street_address'],
                'city' => $validatedData['city'],
            ]
        );

        if ($request->hasFile('cover')) {
            $coverPath = Helper::uploadImage($request->file('cover'), 'business_profiles');
            $businessProfile->cover = $coverPath;
            $businessProfile->save();
        }

        $businessProfile->business_hours()->delete(); // __clear existing hours
        foreach ($validatedData['hours'] as $hour) {
            $businessProfile->business_hours()->create([
                'day' => $hour['day'],
                'is_closed' => $hour['is_closed'],
                'open_time' => $hour['is_closed'] ? null : $hour['open_time'],
                'close_time' => $hour['is_closed'] ? null : $hour['close_time'],
            ]);
        }

        $businessProfile->cover = url($businessProfile->cover);

        // load business hours
        $businessProfile->load('business_hours');

        return $this->success($businessProfile, 'Business Profile created successfully', 200);

    }

    public function business_profile_details()
    {
        $businessProfile = BusinessProfile::where('user_id', Auth::id())->first();

        if (!$businessProfile) {
            return $this->error([], 'Business Profile not found', 404);
        }

        $businessProfile->cover = url($businessProfile->cover);

        // load business hours
        $businessProfile->load('business_hours');

        return $this->success($businessProfile, 'Business Profile retrieved successfully', 200);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request)
    {

        $businessProfile = BusinessProfile::where('user_id', Auth::id())->first();


        if (!$businessProfile || $businessProfile->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Business profile not found or unauthorized access.',
            ], 404);
        }


        $validatedData = $request->validate([
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'business_name' => 'required|string',
            'category_id' => 'required|integer',
            'sub_category_id' => 'required|integer',
            'activity' => 'required|in:Indoor,Outdoor',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'hours' => 'required|array',
            'hours.*.day' => 'required|string',
            'hours.*.is_closed' => 'required|boolean',
            'hours.*.open_time' => 'nullable|string',
            'hours.*.close_time' => 'nullable|string',
        ]);


        $businessProfile->update([
            'business_name' => $validatedData['business_name'],
            'category_id' => $validatedData['category_id'],
            'sub_category_id' => $validatedData['sub_category_id'],
            'activity' => $validatedData['activity'],
            'street_address' => $validatedData['street_address'],
            'city' => $validatedData['city'],
        ]);


        if ($request->hasFile('cover')) {

            if ($businessProfile->cover) {
                Helper::deleteImage($businessProfile->cover);
            }

            // __new cover image
            $coverPath = Helper::uploadImage($request->file('cover'), 'business_profiles');
            $businessProfile->cover = $coverPath;
            $businessProfile->save();
        }


        $businessProfile->business_hours()->delete();
        foreach ($validatedData['hours'] as $hour) {
            $businessProfile->business_hours()->create([
                'day' => $hour['day'],
                'is_closed' => $hour['is_closed'],
                'open_time' => $hour['is_closed'] ? null : $hour['open_time'],
                'close_time' => $hour['is_closed'] ? null : $hour['close_time'],
            ]);
        }


        $businessProfile->cover = $businessProfile->cover ? url($businessProfile->cover) : null;


        return $this->success(
            $businessProfile->load('business_hours'),
            'Business Profile updated successfully',
            200
        );
    }

    public function destroy(string $id)
    {
        //
    }
}
