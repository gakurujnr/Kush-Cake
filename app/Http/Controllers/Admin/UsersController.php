<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all()->load('addresses');
        return Inertia::render('Admin/Users/Index', [
            'users' => $users
        ]);
    }
}
