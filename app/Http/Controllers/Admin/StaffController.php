<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class StaffController extends Controller
{
    public function index()
    {
        $users = User::where('role', 0)
            ->get();

        return view('admin.staff.index', compact('users'));
    }

    public function show()
    {
        $users = User::where('role', 0)
            ->get();

        return view('admin.staff.show', compact('users'));
    }
}
