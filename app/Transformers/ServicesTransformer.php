<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 9/29/17
 * Time: 6:25 PM
 */

namespace App\Transformers;


use App\Models\Services;
use League\Fractal\TransformerAbstract;

class ServicesTransformer extends TransformerAbstract
{
    public function transform(Services $data)
    {
        return [
            'service_id' => (int)$data->id,
            'name' => (string)$data->name,
            'icon' => (string)$data->icon,
            'language_id' => (string)$data->language_id
        ];
    }
}