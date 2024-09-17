<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->get();
        if ($notifications) {
            $unreadCount = Auth::user()->unreadNotifications()->count();
        }
        return view('notifications', compact('notifications', 'unreadCount'));
    }
}
