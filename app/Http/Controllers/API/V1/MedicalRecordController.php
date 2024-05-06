<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Models\Call;
use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\Services\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MedicalRecordLargeAnaResource;
use App\Http\Requests\Api\MedicalRecords\StoreRequest;
use App\Http\Resources\MedicalRecordLargeDoctorResource;

class MedicalRecordController extends Controller
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
        MedicalRecord::where('call_id', $request->call_id)->update([
            'user_id' => Auth::id(),
            'image' => upload($request->image, 'medical-records'),
            'note' => $request->note,
            'status' => 'done',

        ]);

        $call = Call::find($request->call_id);

        $title = 'New Measurement';
        $body = 'You Have New Measurement';
        $user = User::find($call->doctor_id);
        if ($user->device_token != null) {
            $this->notification->send($user->device_token, $title, $body);
        }
        
        /*
        $title = 'New Medical Record';
        $body = 'You Have New Medical Record';
        $user = User::find(Auth::id());
        if($user->device_token != null){
            $this->notification->send($user->device_token, $title, $body);
        }
        */
        /*
        foreach ($request->types as  $type) {
            DB::table('medical_record_types')->insert([
                'medical_record_id' => $data->id,
                'type' => $type,
                ]);
            }
*/
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function medicalRecordShow(Request $request)
    {

        if (Auth::user()->type == ConstantController::DOCTOR) {
            $data = MedicalRecord::with('medicalRecordType')->where('call_id', $request->call_id)->first();
            if (!$data) return $this->errorStatus('call not found');

            return $this->respondWithItem(new MedicalRecordLargeDoctorResource($data));

        } elseif (Auth::user()->type == ConstantController::ANALYSIS) {
            $data = MedicalRecord::with('call','medicalRecordType')->where('call_id', $request->call_id)->first();
            if (!$data) return $this->errorStatus('call not found');

            return $this->respondWithItem(new MedicalRecordLargeAnaResource($data));
            
        } elseif (Auth::user()->type == ConstantController::MANGER) {

            $data = MedicalRecord::with('medicalRecordType')->where('call_id', $request->call_id)->first();
            if (!$data) return $this->errorStatus('call not found');

            return $this->respondWithItem(new MedicalRecordLargeAnaResource($data));
        }
        return $this->errorStatus('not DOCTOR or ANALYSIS');
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
