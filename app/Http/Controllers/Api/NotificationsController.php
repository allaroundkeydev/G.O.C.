<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = Notification::with('instancia');

        if ($request->has('enviado')) {
            $query->where('enviado', $request->enviado);
        }

        $notifications = $query->paginate(15);

        return $this->sendResponse($notifications, 'Notifications retrieved successfully.');
    }

    /**
     * Mark a notification as sent.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function markSent($id)
    {
        $notification = Notification::find($id);

        if (is_null($notification)) {
            return $this->sendError('Notification not found.');
        }

        $notification->update([
            'enviado' => true,
            'enviado_at' => now(),
        ]);

        return $this->sendResponse($notification, 'Notification marked as sent successfully.');
    }
}