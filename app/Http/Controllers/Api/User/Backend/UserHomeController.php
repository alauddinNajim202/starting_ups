<?php

namespace App\Http\Controllers\Api\User\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Traits\ApiResponse;
use Carbon\Carbon;

class UserHomeController extends Controller
{

    use ApiResponse;

    // _categories
    public function categories()
    {
        try {

            $categories = Category::all();

            if ($categories->isEmpty()) {
                return $this->error([], 'No categories found', 404);
            }

            $categories->map(function ($category) {
                $category->image = $category->image ? url($category->image) : null;
            });

            return $this->success($categories, 'Categories retrieved successfully', 200);

        } catch (\Exception $e) {

            return $this->error([], 'Error retrieving categories: ' . $e->getMessage(), 500);
        }
    }

    // _categories event details
    public function categories_event($id)
    {
        try {

            $category = Category::find($id);

            if (!$category) {
                return $this->error([], 'Category not found', 404);
            }

            $events = Event::where('category_id', $category->id)->get();

            if ($events->isEmpty()) {
                return $this->error([], 'No events found for this category', 404);
            }

            $events = $events->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'time' => Carbon::parse($event->date)->format('h:i A'),
                    'date' => Carbon::parse($event->date)->format('d M Y'),
                    'location' => $event->location_address,
                    'cover' => $event->cover ? url($event->cover) : null,
                ];
            });

            return $this->success($events, 'Events retrieved successfully', 200);

        } catch (\Exception $e) {

            return $this->error([], 'Error retrieving events: ' . $e->getMessage(), 500);
        }
    }
















    // _events
    public function events()
    {
        // upcoming events where frequency_end_date not null

        $upcoming_events = Event::whereNull('frequency_end_date')->
            where('date', '>', Carbon::now())
            ->orderBy('date', 'asc')
            ->get();

        // If no upcoming events, fetch friends' events
        if ($upcoming_events->isEmpty()) {

            // $friends_events = Event::whereHas('visits', function ($query) use ($user) {
            //     $query->whereIn('user_id', $user->friends->pluck('id'));
            // })
            //     ->orderBy('date', 'desc')
            //     ->limit(5)
            //     ->get();

            // $friends_events = $friends_events->map(function ($event) {
            //     return [
            //         'id' => $event->id,
            //         'title' => $event->title,
            //         'time' => Carbon::parse($event->date)->format('h:i A'),
            //         'date' => Carbon::parse($event->date)->format('d M Y'),
            //         'location' => $event->location_address,
            //         'cover' => $event->cover ? url($event->cover) : null,
            //     ];
            // });

            $friends_events = 0;

            return $this->success($friends_events, 'Here are some events where your friends are going.', 200);
        }
        $upcoming_events = $upcoming_events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'time' => Carbon::parse($event->date)->format('h:i A'),
                'date' => Carbon::parse($event->date)->format('d M Y'),
                'location' => $event->location_address,
                'cover' => $event->cover ? url($event->cover) : null,

            ];
        });

        return $this->success($upcoming_events, 'Upcoming events retrieved successfully', 200);

        // past events
        // $past_events = Event::where('status', 'active')
        //     ->where('date', '<', Carbon::now())
        //     ->orderBy('date', 'desc')
        //     ->get();

    }


    // _event details
    public function event_details($id)
    {
        $event = Event::with('event_prices')->find($id);

        if (!$event) {
            return $this->error([], 'Event not found', 404);
        }

        $event = [

            'user_id' => $event->user_id,
            'user_name' => $event->user->name,
            'user_image' => $event->user->image ? url($event->user->image) : null,


            'id' => $event->id,
            'title' => $event->title,
            'time' => Carbon::parse($event->date)->format('h:i A'),
            'date' => Carbon::parse($event->date)->format('d M Y'),
            'location' => $event->location_address,
            'cover' => $event->cover ? url($event->cover) : null,
            'description' => $event->description,
            'location_type' => $event->location_type,
            'location_address' => $event->location_address,
            'amount' => $event->amount,
            'offerings' => $event->offerings,
            'guest_list' => $event->guest_list,
            'event_prices' => $event->event_prices,

        ];



        return $this->success($event, 'Event details retrieved successfully', 200);
    }




}
