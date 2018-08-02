<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\BaseResource;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray ($request)
    {
        return parent::toArray($request);
    }
}
