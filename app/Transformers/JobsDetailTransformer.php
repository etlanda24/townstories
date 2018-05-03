<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 9/29/17
 * Time: 6:53 PM
 */

namespace App\Transformers;


use App\Models\Jobs;
use League\Fractal\TransformerAbstract;

class JobsDetailTransformer extends TransformerAbstract
{

    public function transform(Jobs $data)
    {
        return [
            'description' => (int)$data->description,
            'lat' => $data->latitude,
            'long' => $data->longitude,
            'city_id' => (int)$data->city_id,
            'date_created' => (string)$data->date_created,
            'data_updated' => (string)$data->date_updated,
            'job_title' => isset($data->contents[0]->job_title) ? $data->contents[0]->job_title : null,//$data->job_title,
            'language_id' => isset($data->contents[0]->language_id) ? $data->contents[0]->language_id : null,//$data->language_id//isset($temp['language_id']) ? $temp['language_id'] : null
            'address' => isset($data->contents[0]->address) ? $data->contents[0]->address : null,//$data->language_id//isset($temp['language_id']) ? $temp['language_id'] : null
            'salary_range' => isset($data->contents[0]->salary_range) ? $data->contents[0]->salary_range : null,//$data->language_id//isset($temp['language_id']) ? $temp['language_id'] : null
            'start_date' => isset($data->contents[0]->start_date) ? $data->contents[0]->start_date : null,//$data->language_id//isset($temp['language_id']) ? $temp['language_id'] : null
            'company_name' => isset($data->contents[0]->company_name) ? $data->contents[0]->company_name : null
        ];
    }
}