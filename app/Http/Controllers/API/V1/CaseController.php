<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Call;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Http\Controllers\Controller;
use App\Http\Resources\CallResource;
use App\Http\Resources\CaseResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CallLargeResource;
use App\Http\Requests\Api\Call\StoreRequest;
use App\Http\Requests\Api\Call\StoreCallRequest;
use App\Models\MedicalRecord;
use App\Models\MedicalRecordType;

class CaseController extends Controller
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

        if (Auth::user()->type == ConstantController::DOCTOR) {

            $calls = Call::where('doctor_id', Auth::id())
                ->where('status', ConstantController::ACCEPT_DOCTOR)
                ->orWhere('status', ConstantController::ACCEPT_NURSE)
                ->orWhere('status', ConstantController::ACCEPT_ANALYSIS)
                ->orderby('id', 'DESC')
                ->get();
        } elseif (Auth::user()->type == ConstantController::NURSE) {
            $calls = Call::where('nurse_id', Auth::id())
                ->where('status', ConstantController::ACCEPT_DOCTOR)
                ->orWhere('status', ConstantController::ACCEPT_NURSE)
                ->orWhere('status', ConstantController::ACCEPT_ANALYSIS)
                ->orderby('id', 'DESC')
                ->get();
        } elseif (Auth::user()->type == ConstantController::ANALYSIS) {
            $calls = Call::where('analysis_id', Auth::id())
                ->where('status', ConstantController::ACCEPT_DOCTOR)
                ->orWhere('status', ConstantController::ACCEPT_ANALYSIS)
                ->orWhere('status', ConstantController::ACCEPT_NURSE)

                ->orderby('id', 'DESC')
                ->get();
        } elseif (Auth::user()->type == ConstantController::MANGER) {
            $calls = Call::get();
        }

        return $this->respondWithCollection(CaseResource::collection($calls));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $call = Call::find($id);
        if (!$call) return $this->errorStatus();

        return $this->respondWithItem(new CallLargeResource($call));
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, $id)
    {
        Call::whereId($id)->update([
            'status' => 'accept',
        ]);
        return $this->successStatus();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function makeRequest(Request $request)
    {
        Call::whereId($request->call_id)->update([
            'analysis_id' => $request->user_id
        ]);

        $medical = MedicalRecord::create([
            'call_id' => $request->call_id,
            'user_id' => $request->user_id,
            'note' => $request->note,
        ]);

        foreach ($request->types as $type) {
            $medical->medicalRecordType()->create(['type' => $type]);
        }

       $call = Call::whereId($request->call_id)->first();
       
        $title = 'New Call';
        $body = 'You Have New Call';
        $user = User::find($request->user_id);
        $this->notification->send($user->device_token, $title, $body);
        
        return $this->successStatus();
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addNurse(Request $request)
    {
        Call::whereId($request->call_id)->update([
            'nurse_id' => $request->user_id
        ]);

       
        $title = 'New Call';
        $body = 'You Have New Call';
        $user = User::find($request->user_id);
        $this->notification->send($user->device_token, $title, $body);
        
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
