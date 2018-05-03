<?php

namespace App\Http\Controllers;

use App\Models\keywords;
use App\Transformers\KeywordsTransformer;
use Illuminate\Http\Request;
use League\Fractal;
use App\Transformers\RegionTransformer;
use App\Transformers\SlideshowTransformer;
use App\Transformers\CategoriesTransformer;
use App\Transformers\JobsTransformer;
use App\Transformers\EmergencyContactTransformer;
use App\Transformers\NoticesTransformer;
use App\Transformers\ServicesTransformer;
use App\Transformers\VersionTransformer;
use App\Models\Notices;
use App\Models\Services;
use App\Models\Region;
use App\Models\Slideshow;
use App\Models\Categories;
use App\Models\Jobs;
use App\Models\EmergencyContact;
use App\Repositories\Formater;

class MasterController extends ApiController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
    
    public function getVersion()
    {
        $count = \App\Models\Version::get()->count();

        $version = \App\Models\Version::get();
        $dataVersion = [];
        if ($version) {
            $manager = new \League\Fractal\Manager();
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($version, new VersionTransformer());
            $dataVersion = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataVersion, ['meta.count' => $count]);
    }

    public function getRegion()
    {
        $count = Region::get()->count();

        $data = Region::get();
        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new RegionTransformer());
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }

    public function getSlideshow()
    {
        $arr = $this->request->get('type');

        $typeOne = null;
        $typeTwo = null;

        $languageId = $this->request->get('language_id');
        $regionId = $this->request->get('region_id');

        $count = Slideshow::get()->count();

        if (count($arr) > 1) {
            $typeOne = $arr[0];
            $typeTwo = $arr[1];

            $data = Slideshow::where('language_id',
                $languageId)->where('city_id', $regionId)
                ->where(function ($query) use ($typeOne, $typeTwo) {
                    $query->where('type', $typeOne);
                    $query->orWhere('type', $typeTwo);
                })->get();


        } else {
            $typeOne = $arr[0];

            $data = Slideshow::where('language_id',
                $languageId)->where('city_id', $regionId)->
            where('type', $typeOne)->get();
        }

        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            //$manager->parseIncludes('type');
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new SlideshowTransformer());
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }

    public function getCategories()
    {
        $languageId = $this->request->get('language_id');
        $count = Categories::get()->count();

        $data = Categories::with(['contents' => function ($query) use ($languageId) {
            $query->where('language_id', $languageId);
        }])->get();

        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new CategoriesTransformer());
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }

    public function getJobs()
    {
        $languageId = $this->request->get('language_id');
        $regionId = $this->request->get('region_id');
//        $keyword = $this->request->get('keyword');
//        $job = Jobs::with(['contents' => function ($query) use ($languageId) {
//            $query->where('language_id', $languageId)->Where('job_title','LIKE', '%Designer%');
//
//        }])->where('city_id', $regionId);
//
//        return $job
//->where('job_title','LIKE', '%d%')
//        dd($job->where('job_title','LIKE', '%d%')->get());


        /*$query = "SELECT * FROM MySimpang_db.tbl_jobs
                            INNER JOIN MySimpang_db.tbl_job_content
                            ON MySimpang_db.tbl_jobs.id = MySimpang_db.tbl_job_content.job_id
                            where city_id=22 and language_id=1
                            and (job_title like \"%des%\" or company_name like '%".$languageId."%')";
        $raw = DB::SELECT($query);
        return $raw;*/
        /*$job = Jobs::with(['contents' => function ($query) use ($languageId) {
            $query->where('language_id', $languageId)
                ->Where('job_title', 'LIKE', '%Designer%');

        }])->where('city_id', $regionId);*/


        $job = Jobs::with(['contents' => function ($query) use ($languageId) {
            $query->where('language_id', $languageId)
                ->Where('job_title', 'LIKE', '%Designer%');

        }])->where('city_id', $regionId);


        $job = Jobs::with('contents')->where('city_id', $regionId)
            ->whereHas('contents', function($query) use ($languageId) {
                $query->where('language_id', $languageId)
                    ->where('job_title', 'LIKE', '%Designer%');
            });


        /*$job = Jobs::with('contents')
            ->whereHas('contents', function($query) use ($languageId) {
                $query->where('language_id', $languageId)
                    ->where('job_title', 'LIKE', '%Designer%');
            })->where('city_id', $regionId);*/
        $formatter = new Formater($job);
        $formatter->withPagination();


        $data = $formatter->get();
        $count = $data->count();
        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new JobsTransformer());
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }

    public function getContact()
    {

        $regionId = $this->request->get('region_id');

        $data = EmergencyContact::where('city_id', $regionId)->get();
        $count = $data->count();
        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new EmergencyContactTransformer());
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }



    public function getNotices()
    {

        $regionId = $this->request->get('region_id');
        $languageId = $this->request->get('language_id');

        $data = Notices::with(['contents' => function ($query) use ($languageId) {
            $query->where('language_id', $languageId);
        }])->where('city_id', $regionId);

        $formatter = new Formater($data);
        $formatter->withPagination();
        $data = $formatter->get();
        $count = $data->count();

        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new NoticesTransformer());
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }

    public function getServices()
    {

        $languageId = $this->request->get('language_id');

        $data = Services::where('language_id', $languageId)->get();
        $count = $data->count();
        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new ServicesTransformer());
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }

    public function getKeywords()
    {

        $languageId = $this->request->get('language_id');

        $data = Keywords::where('language_id', $languageId)->get();
        $count = $data->count();
        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new KeywordsTransformer());
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }

}