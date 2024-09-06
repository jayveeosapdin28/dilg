<?php

namespace App\Http\Controllers\V1\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function show($id){
        $notification = Notification::find($id);
        if(!$notification) {
            return redirect()->back();
        }
        $notification->update([
           'read' => 1,
        ]);
        return redirect($notification->meta['link']);
    }
}
