<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskLargeResource extends JsonResource
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
            'description' => $this->description,
            'note' => $this->note,
            //'image' => asset('public/'.$this->image),
            'to_do' => 
                $this->todo ,
            
            'user' => [
                'id' => $this->user->id,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'mobile' => $this->user->mobile,
                'email' => $this->user->email,
                'gender' => $this->user->gender,
                'specialist' => $this->user->specialist,
                'birthday' => $this->user->birthday,
                'address' => $this->user->address,
            ],
            'created_at' =>date("Y-m-d",strtotime($this->created_at)),
            'status' => $this->status,
        ];
    }
}
