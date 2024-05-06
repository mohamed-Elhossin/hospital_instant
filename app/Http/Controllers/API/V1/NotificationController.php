<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public $notification;
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        $user =User::find($request->to);

        $this->notification->send($user->device_token,$request->title,$request->body);

        return $this->successStatus();
    }

}
