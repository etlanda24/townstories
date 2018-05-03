<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Categories;

class CategoriesTransformer extends TransformerAbstract
{
    public function transform(Categories $data)
    {
        return [
            'id' => (int)$data->category_id,
            'category_marker' => $data->category_marker,
            'icon' => (string)$data->icon,
            'name' => isset($data->contents[0]->category_name) ? $data->contents[0]->category_name : null//$data->job_title,
        ];
    }
}
