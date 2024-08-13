<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "city" => $this->city,
            "email" => $this->email,
            "phone" => $this->phone,
            "state" => $this->state,
            "country" => $this->country,
            "address" => $this->address,
            "imageUrl" => $this->files['image'],
            "userData" => $this->user_data,
            "username" => $this->username,
            "fullname" => $this->fullname,
            "lastname" => $this->lastname,
            "firstname" => $this->firstname,
            "createdAt" => $this->created_at,
            "updatedAt" => $this->updated_at,
            "lastAttempt" => $this->last_attempt,
            "emailVerifiedAt" => $this->email_verified_at,
            "phoneVerifiedAt" => $this->phone_verified_at,
        ];
    }
}
