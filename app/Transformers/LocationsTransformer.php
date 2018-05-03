<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 9/20/17
 * Time: 5:35 PM
 */

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Locations;

class LocationsTransformer extends TransformerAbstract
{

    public $lang;

    public function __construct($lang = 1)
    {
        $this->lang = $lang;
    }

    protected $availableIncludes = [
        'contents', 'category'
    ];

    public function transform(Locations $data)
    {
        /*   $temp = $this->condition($data);
           $result = [];
           if(count($temp) > 0)
           {*/

        $result = [
            'id' => (int)$data->location_id,
            'category_id' => (int)$data->category_id,
            'location_image' => (string)$data->location_image,
            'latitude' => (string)$data->latitude,
            'longitude' => (string)$data->longitude,
            //'city_id' => (string)$data->city_id
            /*'location_name' => isset($data->contents[0]->location_name) ? $data->contents[0]->location_name : null,//$data->job_title,
            'address' => isset($data->contents[0]->address) ? $data->contents[0]->address : null,
            'language_id' => isset($data->contents[0]->language_id) ? $data->contents[0]->language_id : null*/
            //'category_marker' => isset($data->contents[0]->category_marker) ? $data->contents[0]->category_marker: null

        ];
        return $result;
        /*        }

                return $result;*/
    }

    public function includeContents(Locations $data)
    {

//        dd($data->content($this->lang)->get()->toArray());

        /*$var = $data->content;
        dd($data->content);
        dd($data->contents);*/
        if (isset($data->contents)) {
            return $this->collection($data->contents, new LocationContentTransformer());
        }
    }

    public function includeCategory(Locations $data)
    {

        if (isset($data->category)) {
            return $this->item($data->category, new CategoriesTransformer());
        }
    }


    /*private function condition($data)
    {
        $result = [];
        if ($data != null) {
            $temp = $data->contents->toArray();
            //$tempLanguage = $data->contents[0]->toArray();
            $result = $this->search($temp, 'language_id', $this->lang);
        }

        return $result;
    }


    public function search($array, $key, $value)
    {
        $results = array();

        foreach ($array as $subArray) {
            if ($subArray[$key] == $value) {
                $results[] = $subArray;
            }
        }

        return $results;
    }*/

}