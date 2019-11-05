<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Owner;
use App\Manager;
use App\User;

class Property extends JsonResource
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

        //Get Roles for property model
        $owner = Owner::findOrFail($this->owner_id);
        $manager = Manager::findOrFail($this->manager_id);
        //Get users for fetch Roles
        $owner_user = User::findOrFail($owner->role_id);
        $manager_user = User::findOrFail($manager->role_id);

        return [
            'id' => $this->id,
            'owner_id' => $this->owner_id,
            'owner_user' => $owner_user->name,
            'manager_id' => $this->manager_id,
            'manager_user' => $manager_user->name,
            'address' => $this->address,
            'property_image' => $this->property_image
        ];
    }
}
