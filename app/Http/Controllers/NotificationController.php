<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller {

    /**
     * Permet de marquer la notification comme lu
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(string $id) {
        $notification = Auth::user()->unreadNotifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }

}
