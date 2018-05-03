<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use Tymon\JWTAuth\JWTAuth;
use DB;
use Validator;
use App\Transformers\PlaceCommentTransformer;
use App\Models\PlaceComment;


class CommentController extends ApiController
{
	public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    public function place(JWTAuth $JWTAuth)
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

		$place_id = $this->request->get('place_id');
		$user =  $JWTAuth->parseToken()->authenticate();
		$data = [];
		$placeComment = PlaceComment::where("place_id", $place_id)->get();
		if($placeComment) {
			$manager = new \League\Fractal\Manager();
			$manager->parseIncludes(['user']);
			$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer('comment'));
			$resource = new Fractal\Resource\Collection($placeComment, new PlaceCommentTransformer($user->id));
			$data =  $manager->createData($resource)->toArray();
		}

		
		$token = $JWTAuth->fromUser($user);
		return $this->response()->success($data, ['meta.token' => $token]);
    } 
}