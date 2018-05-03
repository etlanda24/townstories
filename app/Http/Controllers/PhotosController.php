<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use Tymon\JWTAuth\JWTAuth;
use Validator;

class PhotosController extends ApiController
{
	public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function placeAll(JWTAuth $JWTAuth)
    {
    	$validator = Validator::make(
    		$this->request->all(),
    		array(
    				'place_id' => array('required')
    			)
		);

		if ($validator->fails())
		{
			return $this->response()->error($validator->errors()->all());
		}
    }
}