<?php

namespace App\Http\Controllers\Api\Business\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EventReportController extends Controller
{

    use ApiResponse;
    // __event reports

    // public function event_details(Request $request)
    // {
    //     // Get the authenticated user
    //     $user = auth('business')->user();

    //     // If user not found
    //     if (!$user) {
    //         return $this->error([], 'User not found.', 404);
    //     }

    //     // Fetch all events with related data
    //     // $events = Event::with([
    //     //     'event_clicks',
    //     //     'event_bookings' => function ($query) {
    //     //         $query->select('event_id', 'price', 'user_id'); // Fetch only relevant data
    //     //     }
    //     // ])->where('user_id', $user->id)->get();

    //     // // Initialize overall totals
    //     // $overall = [
    //     //     'link_clicks' => 0,
    //     //     'sign_ups' => 0,
    //     //     'revenue' => 0.00,
    //     //     'reported_customers' => 0
    //     // ];

    //     // // Process analytics for each event
    //     // $eventAnalytics = $events->map(function ($event) use (&$overall) {
    //     //     $linkClicks = $event->event_clicks->count();
    //     //     $signUps = $event->event_bookings->count();
    //     //     $revenue = $event->event_bookings->sum('price');
    //     //     $reportedCustomers = $event->event_bookings->sum('user_id');

    //     //     // Update overall totals
    //     //     $overall['link_clicks'] += $linkClicks;
    //     //     $overall['sign_ups'] += $signUps;
    //     //     $overall['revenue'] += $revenue;
    //     //     $overall['reported_customers'] += $reportedCustomers;

    //     //     return $overall;
    //     //     // // Return event-specific metrics
    //     //     // return [
    //     //     //     'link_clicks' => $linkClicks,
    //     //     //     'sign_ups' => $signUps,
    //     //     //     'revenue' => $revenue,
    //     //     //     'reported_customers' => $reportedCustomers,
    //     //     // ];
    //     // });

    //     // Fetch all events for the user and calculate totals
    //     $events = Event::where('user_id', $user->id)->with('event_clicks', 'event_bookings')->get();

    //     // Initialize overall totals
    //     $totals = [
    //         'link_clicks' => 0,
    //         'sign_ups' => 0,
    //         'revenue' => 0.00,
    //         'reported_customers' => 0,
    //     ];

    //     // Loop through events to calculate totals
    //     foreach ($events as $event) {
    //         $totals['link_clicks'] += $event->event_clicks->count();
    //         $totals['sign_ups'] += $event->event_bookings->count();
    //         $totals['revenue'] += $event->event_bookings->sum('price');
    //         $totals['reported_customers'] += $event->event_bookings->sum('user_id');
    //     }

    //     return $this->success($totals,'Event analytics fetched successfully.');
    // }

    public function event_details(Request $request)
    {
        // Get the authenticated user
        $user = auth('business')->user();

        // If user not found
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Fetch all events for the user
        $events = Event::where('user_id', $user->id)

                        ->with('event_clicks', 'event_bookings')->get();

        // Initialize overall totals
        $totals = [
            'link_clicks' => 0,
            'sign_ups' => 0,
            'revenue' => 0.00,
            'repeat_customers' => 0,
        ];

        // Fetch previous analytics data (Example: Last Week)
        $previousEvents = Event::where('user_id', $user->id)
                        ->where('created_at', now()->subMonth())
                        ->with('event_clicks', 'event_bookings')
                        ->get();
        // dd($previousEvents);

        // Initialize previous totals
        $previousTotals = [
            'link_clicks' => 0,
            'sign_ups' => 0,
            'revenue' => 0.00,
            'repeat_customers' => 0,
        ];

        // Calculate current totals
        foreach ($events as $event) {
            $totals['link_clicks'] += $event->event_clicks->count();
            $totals['sign_ups'] += $event->event_bookings->count();
            $totals['revenue'] += $event->event_bookings->sum('price');
            $totals['repeat_customers'] += $event->event_bookings->where('user_id', '!=', null)->count();
        }

        // Calculate previous totals
        foreach ($previousEvents as $event) {
            $previousTotals['link_clicks'] += $event->event_clicks->count();
            $previousTotals['sign_ups'] += $event->event_bookings->count();
            $previousTotals['revenue'] += $event->event_bookings->sum('price');
            $totals['repeat_customers'] += $event->event_bookings->where('user_id', '!=', null)->count();

        }

        // Calculate percentage change
        $percentageChange = [];
        foreach ($totals as $key => $value) {
            $previousValue = $previousTotals[$key] ?? 0;
            if ($previousValue != 0) {

                $percentageChange[$key] = round((($value - $previousValue) / $previousValue) * 100, 2);
            } else {

                $percentageChange[$key] = ($value > 0) ? 100 : 0;
            }
        }

        // Return response with analytics and percentage changes
        $data = [
            'overall' => $totals,
            'percentage_change' => $percentageChange,
        ];


        return $this->success($data,'Event analytics fetched successfully.');
    }

}
