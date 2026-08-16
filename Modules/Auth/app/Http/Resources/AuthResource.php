<?php

namespace Modules\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public static $wrap = 'user';

    public function toArray($request)
    {
        return UserResource::make($this->resource)->toArray($request);
    }
}
