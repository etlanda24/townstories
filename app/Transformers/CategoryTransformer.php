<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Categories;


class CategoryTransformer extends TransformerAbstract
{
    public function transform(Version $Version)
    {
        return [
            'id'            => (int) $Version->category_id
            
        ];
    }
}
