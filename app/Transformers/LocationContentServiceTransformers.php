<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 10/4/17
 * Time: 7:02 PM
 */

namespace App\Transformers;


use App\Models\LocationContentServices;
use League\Fractal\TransformerAbstract;

class LocationContentServiceTransformers extends TransformerAbstract
{

    protected $availableIncludes = [
        'service'
    ];

    public function transform(LocationContentServices $data)
    {
        return [
            'id' => (int)$data->id,
            'location_id' => $data->location_content_id,
            'service_id' => (string)$data->service_id
        ];
    }

    public function includeService(LocationContentServices $data)
    {
        if (isset($data->service)) {
            return $this->item($data->service, new ServicesTransformer());
        }
    }

}