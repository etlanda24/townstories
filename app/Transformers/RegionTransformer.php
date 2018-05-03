<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Region;


class RegionTransformer extends TransformerAbstract
{
    public function transform(Region $region)
    {
        return [
            'id'            => (int) $region->id,
            'name'          => (string) $region->name
            
        ];
    }
}
