<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->withCount('orders')
            ->withSum('orders as total_belanja', 'total')
            ->latest()
            ->paginate(12);

        return view('admin.users.index', compact('users'));
    }
}