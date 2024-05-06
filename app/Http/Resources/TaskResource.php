<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'task_name' => $this->task_name,
            'created_at' =>date("Y-m-d",strtotime($this->created_at)),
            'status' => $this->status,
        ];
    }
}
