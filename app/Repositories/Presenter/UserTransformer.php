<?php

namespace App\Repositories\Presenter;

use League\Fractal\TransformerAbstract;
use Hashids;

class UserTransformer extends TransformerAbstract
{
    public function transform(\App\Models\User $user)
    {
        return [
            //'id'                => $user->getRouteKey(),
            'id'                => $user->id,
            'name'              => $user->name,
            'nickname'          => $user->nickname,
            'email'             => $user->email,
            'api_token'         => $user->api_token,
            'remember_token'    => $user->remember_token,
            'phone'             => $user->phone,
            'avatar_url'        => $user->avatar_url,
            'created_at'        => format_date($user->created_at,'Y-m-d Hi:s'),
            'updated_at'        => format_date($user->updated_at,'Y-m-d Hi:s'),
        ];
    }
}