<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordLargeAnaResource extends JsonResource
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
            'user' => [
                'id' => $this->call->doctor->id,
                'first_name' => $this->call->doctor->first_name,
                'last_name' => $this->call->doctor->last_name,
                'specialist' => $this->call->doctor->specialist,
            ],
            
          'type' => $this->medicalRecordType->map->type,
            'note' =>  $this->note,
            'status' =>  $this->status,
        ];
    }
}
