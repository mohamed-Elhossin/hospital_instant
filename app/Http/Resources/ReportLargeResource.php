<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportLargeResource extends JsonResource
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
            'report_name' => $this->report_name,
            'created_at' => date("Y-m-d",strtotime($this->created_at)),
            'status' => $this->status,
            'description' => $this->description,
            'note' => $this->answer ?? "",
            'user' => [
                'id' => $this->user->id ??"",
                'first_name' => $this->user->first_name ??"",
                'last_name' => $this->user->last_name ??"",
                'specialist' => $this->user->specialist ??"",
            ],
            'manger' => [
                'id' => $this->manger->id ??"",
                'first_name' => $this->manger->first_name ??"",
                'last_name' => $this->manger->last_name ??"",
                'specialist' => $this->manger->specialist ??"",
                'updated_at' => date("Y-m-d",strtotime($this->updated_at)),

            ],
            'answer' => $this->answer ?? "",

        ];
    }
}
