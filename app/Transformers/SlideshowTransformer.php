<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Slideshow;


class SlideshowTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'type'
    ];

    public function transform(Slideshow $data)
    {
        return [
            'id'             => (int) $data->id,
            'image'          => (string) $data->image,
            'id_type_item'   => (int)  $data->link,
            'city_id'        => (int) $data->city_id,
            'language_id'    => (int) $data->language_id,
            //'data_type' => (string) $data->type
            //'notice' => (string) $this->getRelationTable($data)
            
        ];
    }

    public function includeType(Slideshow $data)
    {

        if(isset($data->type)) {
            if ($data->type == "notice"){
                return $this->item($data->notice, new NoticesTransformer());
            } else{
                return $this->item($data->location, new LocationsTransformer());
            }

        }
    }

}
