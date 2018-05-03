<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 10/5/17
 * Time: 4:13 PM
 */

namespace App\Transformers;


use App\Models\keywords;
use League\Fractal\TransformerAbstract;

class KeywordsTransformer extends TransformerAbstract
{
    public function transform(Keywords $data)
    {
        return [
            'id' => (int)$data->id,
            'name' => $data->name



        ];
    }
}