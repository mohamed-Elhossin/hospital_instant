<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CallLargeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_name' => $this->patient_name,
            'created_at' => date("Y-m-d", strtotime($this->created_at)),
            'doctor_id' => getFullName($this->doctor),
            'doc_id' => (int) $this->doctor->id,
            'nurse_id' => getFullName($this->nurse) ?? '',
            'analysis_id' => getFullName($this->analysis) ?? '',
            'status' => $this->status,
            'case_status' => $this->case_status ??"",
            'age' => $this->age,
            'phone' => $this->phone,
            'description' => $this->description,

            'blood_pressure' => $this->measurement != null ? $this->measurement->blood_pressure : "",
            'sugar_analysis' => $this->measurement != null ? $this->measurement->sugar_analysis : "",

            'tempreture' => $this->measurement != null ? $this->measurement->tempreture : "",
            'fluid_balance' => $this->measurement != null ? $this->measurement->fluid_balance : "",
            'respiratory_rate' => $this->measurement != null ? $this->measurement->respiratory_rate : "",
            'heart_rate' => $this->measurement != null ? $this->measurement->heart_rate : "",

            'measurement_note' => $this->measurement != null ? $this->measurement->note : "",

            'image' => $this->medicalRecord != null ? asset('public/'.$this->medicalRecord->image) : "",
            'medical_record_note' => $this->medicalRecord != null ? $this->medicalRecord->note : "",
        ];
    }
}
