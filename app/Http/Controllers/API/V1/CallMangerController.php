<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Call;
use App\Models\User;
use App\Models\CallManger;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Http\Controllers\Controller;
use App\Http\Resources\CallResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CallLargeResource;
use App\Http\Resources\CallMangerResource;
use App\Http\Requests\Api\Call\StoreCallRequest;

class CallMangerController extends Controller
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
    public function index(Request $request)
    {
        ## Specialist , Receptionist
        $calls = CallManger::where('user_id',Auth::id())->where('status','!=','done')
        ->orderby('id','DESC')
        ->get();

        return $this->respondWithCollection(CallResource::collection($calls));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CallManger::create([
            'user_id' => $request->user_id,
            'description' => $request->description,
        ]);
 
        $title = 'New Call';
        $body = 'You Have New Call from manager';
        $user = User::find($request->user_id);
        if ($user->device_token != null) {
            $this->notification->send($user->device_token, $title, $body);
        }
        return $this->successStatus();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $callManger = CallManger::find($id);

        return $this->respondWithItem(new CallMangerResource($callManger));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Call::whereId($id)->update([
            'logout' => 'logout',
        ]);
        return $this->successStatus();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
