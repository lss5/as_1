<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('profile.notification.index');
    }
    public function update(Request $request)
    {
        return redirect()->route('profile.notifications.index')->with('success', 'Notification updated');
    }

}
