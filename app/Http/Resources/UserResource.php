<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'gender' => $this->gender,
            'status' => $this->status,
            'specialist' => $this->specialist,
            'type' => $this->type,
            'birthday' => $this->birthday,
            'address' => $this->address,
            'created_at' => (string) $this->created_at,
            'verified' => (bool) $this->hasVerifiedEmail(),
            'token_type' => 'Bearer',
            'access_token' => $this->remember_token,
        ];
    }
}
