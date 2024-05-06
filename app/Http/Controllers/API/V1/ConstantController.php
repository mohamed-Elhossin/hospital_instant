<?php

namespace App\Http\Controllers\API\V1;


use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorResource;
use Illuminate\Http\Request;

class ConstantController extends Controller
{

    const LARGE_PAGINATE = 12;
    const TINY_PAGINATE = 8;

    const PENDING_DOCTOR = 'pending_doctor';
    const PENDING_NURSE = 'pending_nurse';
    const PENDING_ANALYSIS = 'pending_analysis';

    const ACCEPT_DOCTOR = 'accept_doctor';
    const ACCEPT_NURSE = 'accept_nurse';
    const ACCEPT_ANALYSIS = 'accept_analysis';
    const PENDING = 'pending';
    //const PROCESS = 'process';
    const FINISHED = 'finished';

    const DOCTOR = 'doctor';
    const HR = 'hr';
    const RECEPTIONIST = 'receptionist';
    const ANALYSIS = 'analysis';
    const NURSE = 'nurse';
    const MANGER = 'manger';

    const SEARCH_TYPE = ['full_name', 'code', 'mobile'];

    public function doctors(Request $request)
    {
        if($request->type == 'All'){
            $data = User::when($request->filled('name'), function ($query) use ($request) {
                $query->where('first_name', 'like', '%'. $request->name . '%');
            })->get();
    
        }else{

            $data = User::when($request->filled('name'), function ($query) use ($request) {
                $query->where('first_name', 'like', '%'. $request->name . '%');
            })->where('type', $request->type)->get();
        }

        return $this->respondWithItem(DoctorResource::collection($data));
    }
    /*
    public function specialization()
    {

        $data = Specialization::get();

        return new SpecializationCollection($data);
    }
*/
}
