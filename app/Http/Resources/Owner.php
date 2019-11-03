<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Role;
use App\User;

class Owner extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $role = Role::find($this->role_id);

        $user = User::find($role->user_id);
        
        return [
            'id' => $this->id,
            'role_id' => $this->role_id,
            'user_id' => $role->user_id,
            'name' => $user->name,
            'email' => $user->email
        ];
    }
}
