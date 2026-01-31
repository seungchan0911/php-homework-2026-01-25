<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\User;
use App\Models\Store;

class StoreAdministratorController extends Controller
{
    public function index() {
        $store = Store::find(auth()->user()->store_id);

        return view('store_admin.index', compact('store'));
    }

    public function tableView(Request $request) {
        $storeId = auth()->user()->store_id;
        
        $query = Rental::with(['user', 'book'])
            ->where('store_id', $storeId);
        
        if ($request->has('status')) {
            if ($request->status === 'renting') {
                $query->where('is_returned', 0);
            } elseif ($request->status === 'returned') {
                $query->where('is_returned', 1);
            }
        }
        
        $rentals = $query->orderBy('created_at', 'desc')->paginate(3);
        
        return view('store_admin.table_view', compact('rentals'));
    }

    public function calendar(Request $request)
    {
        $storeId = auth()->user()->store_id;
        
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        $startOfMonth = \Carbon\Carbon::create($year, $month, 1)->startOfDay();
        $endOfMonth = $startOfMonth->copy()->endOfMonth()->endOfDay();
        
        $rentals = Rental::with(['user', 'book'])
            ->where('store_id', $storeId)
            ->where('is_returned', 0)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy(function($rental) {
                return $rental->created_at->format('Y-m-d');
            });
        
        $calendar = [];
        $currentDate = $startOfMonth->copy();
        
        $firstDayOfWeek = $currentDate->dayOfWeek;
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $calendar[] = null;
        }
        
        while ($currentDate->month == $month) {
            $calendar[] = $currentDate->copy();
            $currentDate->addDay();
        }
        
        return view('store_admin.calendar', compact('calendar', 'rentals', 'year', 'month'));
    }
    
    public function userProfile(User $user)
    {
        $storeId = auth()->user()->store_id;
        
        $rentals = $user->rentals()
            ->with('book')
            ->where('store_id', $storeId)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('store_admin.profile', compact('user', 'rentals'));
    }
}
