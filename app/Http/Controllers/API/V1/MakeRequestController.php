<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Call;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CallResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CallLargeResource;
use App\Http\Requests\Api\Call\StoreRequest;
use App\Http\Requests\Api\Call\StoreCallRequest;

class MakeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ## Specialist , Receptionist
        if (Auth::user()->type != ConstantController::RECEPTIONIST) {
            $calls = Call::when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('created_at', $request->date);
            })
            ->orderby('id','DESC')
            ->get();
        } else {
            $calls = Call::where('user_id', Auth::id())
                ->where('status', '!=', ConstantController::FINISHED)
                ->orderby('id','DESC')
                ->get();
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
