<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 10/4/17
 * Time: 4:03 PM
 */

namespace App\Http\Controllers;

use App\Models\LocationContentServices;
use App\Transformers\LocationsTransformer;
use DB;
use Illuminate\Http\Request;
use League\Fractal;
use App\Models\Locations;
use App\Repositories\Formater;

class LocationController extends ApiController
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function getPlaceNearby()
    {
        $regionId = $this->request->get('region_id');
        $languageId = $this->request->get('language_id');
        $radius = $this->request->get('radius');
        $lat = 1.825731;
        $long = 103.310389;
        $query = Locations::select(DB::raw('*,
						(
							3959  * acos(
								cos(radians(' . $lat . ')) * cos(radians(`latitude`)) * cos(
									radians(`longitude`) - radians(' . $long . ')
								) + sin(radians(' . $lat . ')) * sin(radians(`latitude`))
							)
						) `distance`'))
            ->having('distance', '<', $radius)
            ->with(['contents' => function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            }])->where('city_id', $regionId);

        $formatter = new Formater($query);
        $formatter->withPagination();
        $data = $formatter->get();
        $count = $data->count();

        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->parseIncludes(['category']);
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new LocationsTransformer());
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }

    public function getLocation()
    {
        $regionId = $this->request->get('region_id');
        $languageId = $this->request->get('language_id');
        $keywords = $this->request->get('keywords');


        /*$query = Locations::with('category', 'contents.locationContentServices.service')
            ->where('city_id', $regionId)
            ->whereHas('contents', function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            })*/
        $query = Locations::with('category', 'contents.locationContentServices.service')
            ->where('city_id', $regionId)
            ->whereHas('contents.locationContentServices.service', function ($query) use ($keywords, $languageId) {
                $query->where('location_name', 'LIKE', '%' . $keywords . '%')
//                    ->where('language_id', $languageId)
                    ->orWhere('name', 'LIKE', '%' . $keywords . '%');
            });

//        DB::enableQueryLog();

        /*$query = Locations::with([
            'category',
            'contents'  => function($q) use ($languageId, $keywords) {
                $q->with(['locationContentServices' => function($q) use ($keywords) {
                    $q->with(['service' => function($q) use ($keywords) {
                        $q->where('name', 'LIKE', "%{$keywords}%");
                    }]);
                }]);

                $q->where('language_id', $languageId);
                $q->where('location_name', 'LIKE', "%{$keywords}%");
            }
        ])->where('city_id', $regionId);

        dd($query->get()->toArray());

        dd(DB::getQueryLog());*/

        /*$query = Locations::select('tbl_location.location_id')->join('tbl_location_content', 'tbl_location_content.location_id', '=', 'tbl_location.location_id')
            ->join('tbl_location_content_services', 'tbl_location_content_services.location_content_id', '=', 'tbl_location_content.id')
            ->join('tbl_services', 'tbl_services.id', '=', 'tbl_location_content_services.service_id')
            ->where(function($q) use ($regionId, $languageId) {
                $q->where('tbl_location.city_id', '=', $regionId);
                $q->where('tbl_location_content.language_id', '=', $languageId);
            })
            ->where(function($q) use ($keywords) {
                $q->where('tbl_location_content.location_name', 'like', "%{$keywords}%");
                $q->orWhere('tbl_services.name', 'like', "%{$keywords}%");
            })
            ->groupBy('tbl_location.location_id');*/
          //  ->get();

        //dd($query->toArray());

        /*->orWhereHas('locationServices.contents', function ($query) use ($keywords) {
            $query->where('name', 'LIKE', '%' . $keywords . '%');
        });*/
        /*->whereHas('contents', function ($query) use ($languageId, $keywords) {
            $query->where('location_name', 'LIKE', '%' . $keywords . '%');
        })
        ->orWhere('city_id', $regionId)->whereHas('contents.locationServices.contents', function ($query) use ($keywords) {
            $query->where('name', 'LIKE', '%' . $keywords . '%');
        });*/

        $formatter = new Formater($query);
        $formatter->withPagination();
        $data = $formatter->get();
        $count = $data->count();

        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->parseIncludes(['category', 'contents.locationContentServices.service']);
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new LocationsTransformer($languageId));
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }

    public function getLocationByService()
    {
        $regionId = $this->request->get('region_id');
        $languageId = $this->request->get('language_id');
        $serviceId = $this->request->get('service_id');


        $query = Locations::with('category', 'contents.locationContentServices.service')
            ->where('city_id', $regionId)
            ->whereHas('contents.locationContentServices.service', function ($query) use ($serviceId, $languageId) {
                //$query->where('language_id', $languageId);
                //$query->where('service_id', $serviceId);
            })/*->orWhereHas('locationServices.contents', function ($query) use ($keywords) {
                $query->where('name', 'LIKE', '%' . $keywords . '%');
            })*/
        ;
        /*->whereHas('locationServices.contents', function ($query) {
            //$query->where('name', 'LIKE', '%' . $keywords . '%');
        })->orWhereHas('contents', function ($query) use ($languageId) {
            //$query->where('location_name', 'LIKE', '%' . $keywords . '%');
        });*/

        /*$query = Locations::has('contents', 'locationServices.contents')
            ->where('city_id', $regionId);
            ->WhereHas('contents', function ($query) use ($languageId) {
                $query->where('language_id', $languageId);
            })
            ->whereHas('locationServices.contents', function ($query) use ($serviceId, $languageId) {
                $query->where('id', $serviceId);
               // $query->where('language_id', $languageId);
            });*/

        $formatter = new Formater($query);
        $formatter->withPagination();
        $data = $formatter->get();
        $count = $data->count();

        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->parseIncludes(['category', 'contents.locationContentServices.service']);
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new LocationsTransformer($languageId));
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }

    /*
     * public function getLocation()
    {
        $regionId = $this->request->get('region_id');
        $languageId = $this->request->get('language_id');
        $keywords = $this->request->get('keywords');


        $query = Locations::with('contents', 'locationServices.contents')
            ->where('city_id', $regionId)
            ->whereHas('locationServices.contents', function ($query) use ($keywords) {
                $query->where('name', 'LIKE', '%' . $keywords . '%');
            })->orWhereHas('contents', function ($query) use ($languageId, $keywords) {
                $query->where('location_name', 'LIKE', '%' . $keywords . '%');
            });

        $formatter = new Formater($query);
        $formatter->withPagination();
        $data = $formatter->get();
        $count = $data->count();

        $dataAll = [];
        if ($data) {
            $manager = new \League\Fractal\Manager();
            $manager->parseIncludes(['category', 'locationServices', 'locationServices.contents']);
            $manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
            $resource = new Fractal\Resource\Collection($data, new LocationsTransformer($languageId));
            $dataAll = $manager->createData($resource)->toArray();
        }

        return $this->response()->success($dataAll, ['meta.count' => $count]);
    }*/
}