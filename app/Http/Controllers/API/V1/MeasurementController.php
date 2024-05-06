<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\Call;
use App\Models\Measurement;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MeasurementLargeResource;
use App\Http\Requests\Api\Measurements\StoreRequest;

class MeasurementController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
      
        Measurement::create([
            'call_id' => $request->call_id,
            'user_id' => Auth::id(),
            'blood_pressure' => $request->blood_pressure,
            'sugar_analysis' => $request->sugar_analysis,
            'tempreture' => $request->tempreture,
            'fluid_balance' => $request->fluid_balance,
            'respiratory_rate' => $request->respiratory_rate,
            'heart_rate' => $request->heart_rate,
            'note' => $request->note,
            'status' => $request->status,

        ]);
        $call = Call::find($request->call_id);

        $title = 'New Measurement';
        $body = 'You Have New Measurement';
        $user = User::find($call->doctor_id);
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
        $measurement = Measurement::find($id);
        return $this->respondWithItem(new MeasurementLargeResource($measurement));
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
        //
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
