<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Filtering logic will be added here based on query params
        return Notification::all();
    }

    /**
     * Mark the specified resource as sent.
     */
    public function markAsSent(Notification $notification)
    {
        $notification->update(['enviado' => true, 'enviado_at' => now()]);
        return response()->json($notification, 200);
    }
}
