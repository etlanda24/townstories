<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Jobs;
use App\Models\JobsContent;


class JobsTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'jobDetail'
    ];

    public function transform(Jobs $data)
    {
        return [
            'id' => (int)$data->id,
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

    public function includeJobsDetail(Jobs $data)
    {
        if (isset($data->category)) {
            return $this->item($data->category, new CategoriesTransformer());
        }
    }
}
