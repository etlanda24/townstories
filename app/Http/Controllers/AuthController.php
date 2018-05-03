<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use Tymon\JWTAuth\JWTAuth;
use DB;
use Validator;
use App\Transformers\UserSecondTransformer;
use App\Transformers\VersionTransformer;
use App\Models\Version;

class AuthController extends ApiController
{
	public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function getUser()
    {
    	$limit = isset($this->request->get('cursor')['limit']) ? $this->request->get('cursor')['limit'] : 5;
    	$offset = isset($this->request->get('cursor')['offset']) ? $this->request->get('cursor')['offset'] : 0;
    	$count = \App\Models\User::get()->count();

    	$user = \App\Models\User::select('id', 'name', 'email')->offset($offset)->limit($limit)->get();
    	$data = [];
    	if($user) {
			$manager = new \League\Fractal\Manager();
			$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
			$resource = new Fractal\Resource\Collection($user, new UserSecondTransformer());
			$data =  $manager->createData($resource)->toArray();
		}
		
		return $this->response()->success($data, ['meta.count' => $count]);
    }

}