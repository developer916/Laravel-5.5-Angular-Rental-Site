<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;

use App\Models\Notification;

use Auth;

class NotificationController extends AdminController {

    public function getNotifications () {
        $arrReturn = [];
        $processed = [];

        $notifications      = Notification::where('receiver_id', Auth::user()->id)->get();
        $arrReturn['count'] = Notification::where('receiver_id', Auth::user()->id)->count();
        foreach ($notifications as $notification) {
            $icon = 'x';

            if (stristr($notification->action, 'new')) {
                $icon = 'add';
            }

            $processed[] = [
                'action'     => $notification->action,
                'icon'       => $icon,
                'message'    => $notification->message,
                'viewed'     => $notification->viewed,
                'created_at' => $notification->created_at->diffForHumans()
            ];
        }

        $arrReturn['notifications'] = $processed;

        return response()->json($arrReturn);
    }

}
