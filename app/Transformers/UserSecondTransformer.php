<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;


class UserSecondTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id'            => (int) $user->id,
            'nama'          => $user->name,
            'email'         => (string) $user->email
            
        ];
    }
}
