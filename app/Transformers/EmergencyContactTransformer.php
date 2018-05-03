<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmergencyContact;


class EmergencyContactTransformer extends TransformerAbstract
{
    public function transform(EmergencyContact $data)
    {
        return [
            'id'             => (int) $data->id,
            'name'             => (string) $data->name,
            'phone'          => (string) $data->phone,
            'city_id'   => (int)  $data->city_id
            
        ];
    }
}
