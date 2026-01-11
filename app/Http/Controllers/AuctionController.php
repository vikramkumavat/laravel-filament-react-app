<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Auction;
use Illuminate\Http\Request;
use App\Models\NotificationLogs;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    /**
     * Display a listing of the auctions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __construct()
    {
        // Middleware can be added here if needed
    }

    /**
     * Get a paginated list of auctions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 6);
        $page = $request->get('page', 1);

        if ($request->filled('nv')) {
            $userId = Auth::id();
            $today = Carbon::now()->toDateString(); // e.g., "2025-05-03"

            $alreadyLogged = NotificationLogs::where('user_id', $userId)
                ->whereDate('visited_at', $today)
                ->exists();

            if (! $alreadyLogged) {
                NotificationLogs::create([
                    'user_id'    => $userId,
                    'visited_at' => now(),
                ]);
            }
        }

        $query = Auction::with(['property.type']) // Eager load nested relation
            ->whereDate('start_time', '>=', Carbon::today())
            ->orderBy('start_time', 'asc');

        // Filter by property sq_ft or Auction description using title
        if ($request->filled('title')) {
            $query->where(function ($q) use ($request) {
                $q->where('description', 'like', '%' . trim($request->title) . '%')
                    ->orWhereHas('property', function ($q2) use ($request) {
                        $q2->where('sq_ft', 'like', '%' . trim($request->title) . '%')
                            ->orWhere('owner_name', 'like', '%' . trim($request->title) . '%');
                    });
            });
        }

        // Filter by Auction location (exists on Auction table)
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . trim($request->location) . '%');
        }

        if ($request->filled('min_price')) {
            $query->whereHas('property', function ($q) use ($request) {
                $q->where('price', '>=', trim($request->min_price));
            });
        }

        if ($request->filled('max_price')) {
            $query->whereHas('property', function ($q) use ($request) {
                $q->where('price', '<=', trim($request->max_price));
            });
        }

        $auctions = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($auctions);
    }

    /**
     * Get a paginated list of auctions.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function getAuctionNotificationOld(Request $request)
    // {
    //     $perPage = $request->get('per_page', 6);
    //     $notificationLogs = NotificationLogs::select('visited_at')
    //         ->whereUserId(Auth::id())
    //         ->whereDate('visited_at', Carbon::today())
    //         ->first()->toArray();

    //     if (isset($notificationLogs['visited_at']) && !empty($notificationLogs['visited_at'])) {
    //         return response()->json([
    //             'data' => []
    //         ]);
    //     }

    //     $query = Auction::with(['property.type']) // Eager load nested relation
    //         ->whereDate('start_time', '>=', Carbon::today())
    //         ->orderBy('start_time', 'asc')->limit($perPage);

    //     $auctions['data'] = $query->get()->toArray();
    //     return response()->json($auctions);
    // }

    public function getAuctionNotification(Request $request)
    {
        $perPage = $request->get('per_page', 6);

        // Check if a log already exists for today
        $alreadyNotified = NotificationLogs::where('user_id', Auth::id())
            ->whereDate('visited_at', Carbon::today())
            ->exists();

        // If already notified today, return empty response
        if ($alreadyNotified) {
            return response()->json(['data' => []]);
        }

        // Get upcoming auctions from today onwards
        $auctions = Auction::with(['property.type'])
            ->whereDate('start_time', '>=', Carbon::today())
            ->orderBy('start_time', 'asc')
            ->limit($perPage)
            ->get();

        return response()->json([
            'data' => $auctions,
        ]);
    }
}
