<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MeasurementLargeResource extends JsonResource
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
            'blood_pressure' =>  $this->blood_pressure,
            'sugar_analysis' =>  $this->sugar_analysis,

            'tempreture' =>  $this->tempreture,
            'fluid_balance' =>  $this->fluid_balance,
            'respiratory_rate' =>  $this->respiratory_rate,
            'heart_rate' =>  $this->heart_rate,
            'note' =>  $this->note,
            'status' =>  $this->status,
        ];
    }
}
