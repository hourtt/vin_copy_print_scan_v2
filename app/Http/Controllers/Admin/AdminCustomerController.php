<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->withCount('orders')
            ->withSum('orders', 'total');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            match ($request->status) {
                'active' => $query->where('is_banned', false),
                'banned' => $query->where('is_banned', true),
                default  => null,
            };
        }

        $customers = $query->latest()->paginate(20)->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $user)
    {
        // Never allow viewing another admin through this panel
        abort_if($user->role === 'admin', 403, 'Unauthorized.');

        $orders = $user->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        //  Single query: both aggregates resolved in one SELECT with withSum + withCount
        $user = User::withSum('orders', 'total')
            ->withCount('orders')
            ->find($user->id);

        $lifetimeSpend = $user->orders_sum_total ?? 0;
        $totalOrders = $user->orders_count ?? 0;

        return view('admin.customers.show', compact('user', 'orders', 'lifetimeSpend', 'totalOrders'));
    }

    public function toggleStatus(User $user)
    {
        // Never allow banning another admin
        abort_if($user->role === 'admin', 403, 'Cannot modify an admin account.');

        $user->update(['is_banned' => !$user->is_banned]);

        $message = $user->is_banned
            ? "Customer \"{$user->first_name} {$user->last_name}\" has been banned."
            : "Customer \"{$user->first_name} {$user->last_name}\" has been unbanned.";

        return back()->with('success', $message);
    }
}
