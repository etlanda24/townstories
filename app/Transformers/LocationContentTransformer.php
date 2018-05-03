<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 10/6/17
 * Time: 4:30 PM
 */

namespace App\Transformers;


use App\Models\LocationsContent;
use League\Fractal\TransformerAbstract;

class LocationContentTransformer extends TransformerAbstract
{

    public $lang;

    public function __construct($lang = 1)
    {
        $this->lang = $lang;
    }

    protected $availableIncludes = [
        'locationContentServices'
    ];

    public function transform(LocationsContent $data)
    {
        /*$temp = $this->condition($data);
        $result = [];
        if (count($temp) > 0) {*/
            return [
                'id' => (int)$data->id,
                'location_id' => (int)$data->location_id,
                'location_name' => (string)$data->location_name,
                'address' => (string)$data->address,
                'description' => (string)$data->description,
                'language_id' => (string)$data->language_id

            ];
        }

        public
        function includeLocationContentServices(LocationsContent $data)
        {
            if (isset($data->locationContentServices)) {
                return $this->collection($data->locationContentServices, new LocationContentServiceTransformers());
            }
        }

        /*private
        function condition($data)
        {
            $result = [];
            if ($data != null) {
                $temp = $data->contents->toArray();
                //$tempLanguage = $data->contents[0]->toArray();
                $result = $this->search($temp, 'language_id', $this->lang);
            }

            return $result;
        }


        public
        function search($array, $key, $value)
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