<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Call;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Notification;
use App\Http\Controllers\Controller;
use App\Http\Resources\CallResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CallLargeResource;
use App\Http\Requests\Api\Call\StoreRequest;
use App\Http\Requests\Api\Call\StoreCallRequest;

class CallController extends Controller
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
        if (Auth::user()->type == ConstantController::RECEPTIONIST) {
            $calls = Call::when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('created_at', $request->date);
            })
            ->orderby('id','DESC')
            ->get();
        } else {
            if (Auth::user()->type == ConstantController::DOCTOR) {
                $calls = Call::where('doctor_id', Auth::id())
                    ->where('status', ConstantController::PENDING_DOCTOR)
                    ->orderby('id','DESC')
                    ->get();
            } elseif (Auth::user()->type == ConstantController::NURSE) {

                $calls = Call::where('nurse_id', Auth::id())
                    ->where('status', ConstantController::PENDING_NURSE)
                    ->orderby('id','DESC')
                    ->get();
                  //  dd( Auth::id());
            } elseif (Auth::user()->type == ConstantController::ANALYSIS) {
             
                $calls = Call::where('analysis_id', Auth::id())
                    ->where('status', ConstantController::PENDING_ANALYSIS)
                    ->orderby('id','DESC')
                    ->get();
            }
        }

        return $this->respondWithCollection(CallResource::collection($calls));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        Call::create([
            'patient_name' => $request->patient_name,
            'doctor_id' => $request->doctor_id,
            'age' => $request->age,
            'phone' => $request->phone,
            'description' => $request->description,
            'status' => ConstantController::PENDING_DOCTOR,
        ]);
        
        $title = 'New Call';
        $body = 'You Have New Call';
        $user = User::find($request->doctor_id);
        if($user->device_token != null){
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
            'status' => 'logout',
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
       
        if (Auth::user()->type == ConstantController::DOCTOR) {
            if($request->status == 'reject'){
                Call::whereId($id)->update([
                    'status' => 'reject',
                ]);
            }else{

                Call::whereId($id)->update([
                    'status' => ConstantController::ACCEPT_DOCTOR,
                ]);
            }
        } elseif (Auth::user()->type == ConstantController::NURSE) {
            Call::whereId($id)->update([
                'status' => ConstantController::ACCEPT_NURSE,
            ]);
        } elseif (Auth::user()->type == ConstantController::ANALYSIS) {
            Call::whereId($id)->update([
                'status' => ConstantController::ACCEPT_ANALYSIS,
            ]);
        }

       
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
        if ($request->type == ConstantController::ANALYSIS) {
            Call::whereId($request->call_id)->update([
                'analysis_id' => $request->user_id,
              //  'status' => ConstantController::PENDING_ANALYSIS
            ]);
        } else {
            Call::whereId($request->call_id)->update([
                'nurse_id' => $request->user_id
            ]);
        }
        $title = 'New Call';
        $body = 'You Have New Call';
        $user = User::find($request->user_id);
        if($user->device_token != null){
            $this->notification->send($user->device_token, $title, $body);
        }
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
