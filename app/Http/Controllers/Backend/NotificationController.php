<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function readNotification($id = null)
    {
        auth()->user()->unreadNotifications->when($id, function($query) use($id) {
            return $query->Where('id', $id);
        })->markAsRead();
        return response()->json(['count' => auth()->user()->unreadNotifications()->count()], 200);
    }
}
