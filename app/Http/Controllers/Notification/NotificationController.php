<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function showAll(Request $request){
        $notifications = \App\Notification::where('recipient', $request->user()->id)->select(['id', 'title', 'created_at', 'read'])->get();

        /**
         * to handle the `read` status, we could have set an enum `status` field ['read', 'unread'] in the database,
         * and just use it in the response, but a `read` tinyint takes less space. So in the getAll Notifications, we
         * need to parse the read=[0, 1] into status=[unread, read]
         */
        foreach($notifications as &$notification){
            $notification->status = ($notification->read) ? 'read' : 'unread';
        }

        return $notifications;
    }

    public function showOne(Request $request){
        if (!$notification = \App\Notification::where(['id' => $request->id, 'recipient' => $request->user()->id])->first()){
            abort(404, "Notification not found");
        }
        
        // marks the notification as `read`
        $notification->read = true;
        $notification->save();

        return $notification;
    }

    public function send(Request $request){
        // email and password are required, and enforces email structure
        $request->validate([
            'title' => ['required'],
            'message' => ['required'],
        ]);

        if (!\App\User::where('id', $request->userId)->first()){
            abort(404, "Recipient user not found");
        }

        $data = [
            'title' => $request->title,
            'created_by' => $request->user()->id,
            'message' => $request->message,
            'recipient' => $request->userId,
        ];

        \App\Notification::create($data);
    }

    public function remove(Request $request){
        if (!$notification = \App\Notification::where(['id' => $request->id, 'recipient' => $request->user()->id])->first()){
            abort(404, "Notification not found");
        }
        $notification->delete();
    }
}
