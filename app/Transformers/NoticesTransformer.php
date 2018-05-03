<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 9/20/17
 * Time: 5:35 PM
 */

namespace App\Transformers;

use App\Models\Categories;
use App\Models\Notices;
use League\Fractal\TransformerAbstract;
use App\Models\Locations;

class NoticesTransformer extends TransformerAbstract
{

    public function transform(Notices $data)
    {
        return [
            'id' => (int)$data->id,
            'image' => (string)$data->image,
            'published_date' => (string)$data->published_date,
            'name' => isset($data->contents[0]->title) ? $data->contents[0]->title : null//$data->job_title,
        ];
    }

}