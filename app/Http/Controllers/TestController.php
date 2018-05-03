<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Marker;
use App\Models\Place;
use App\Models\Comunitie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Transformers\UserTransformer;
use App\Transformers\MarkerTransformer;
use App\Transformers\PlaceTransformer;
use App\Transformers\ComunityTransformer;
use League\Fractal;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use Tymon\JWTAuth\JWTAuth;
use DB;
use Validator;


class TestController extends ApiController
{

	public function __construct(Request $request)
    {
        parent::__construct($request);
    }

	public function test(JWTAuth $JWTAuth)
	{
		$requestData = json_decode($this->request->data);
		$token_gg = $this->request->get('token_gg');
		$email = $this->request->get('email');
	
    	$validator = Validator::make(
    		$this->request->all(),
    		array(
    				'email' => array('required'),
    				'token_gg' => array('required')
    			)
		);

		if ($validator->fails())
		{
			return $this->response()->error($validator->errors()->all());
		}

		$user  = User::where('email', $email)->first();
		if(! $user){
			$client = new \GuzzleHttp\Client(['http_errors' => false]);
			$res = $client->request('GET', 'https://gate.co.id/api/users/me', ['headers' => ['Authorization' => 'Bearer '.$token_gg]]);
			$response =  json_decode($res->getBody());
			if($res->getStatusCode() != 200) 
			{
				return $this->response()->error($response, $res->getStatusCode());
			}

			if($response->email != $email) 
			{
				return $this->response()->error("Email not same with user registration in gg_id");
			}
			
			$user = new User();
			$user->id_gg 	= $response->id;
			$user->password 	= Hash::make('secret');
			$user->url 	= $response->url;
			$user->email  = $response->email;
			$user->name = $response->name;
			$user->dob = $response->dob;
			$user->about = $response->about;
			$user->gender = $response->gender;
			$user->city = $response->city;
			$user->intersport_passport = $response->intersport_passport;
			$user->address = $response->address;
			$user->website = $response->website;
			$user->phone = $response->phone;
			$user->photo = $response->photo;
			$user->photo_thumbnail = $response->photo_thumbnail;
			$user->valid_identification = $response->valid_identification;
			$user->followers = $response->followers;
			$user->followees = $response->followees;
			$user->statuses = $response->statuses;
			$user->total_points = $response->total_points;
			$user->points = $response->points;
			$user->profession = $response->profession;
			$user->institution = $response->institution;
			$user->friends_count = $response->friends_count;
			$user->unread_notifications_count = $response->unread_notifications_count;
			$user->cover_image = $response->cover_image;
			$user->followers_count = $response->followers_count;
			//$user->social_connections = $response->social_connections;
			$user->is_official = $response->is_official;
			$user->is_community = $response->is_community;
			$user->is_email_verified = $response->is_email_verified;

			$user->save();
		} 

		$manager = new Manager();
		$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer('users'));
		$resource = new Fractal\Resource\Item($user, new UserTransformer());
		$data =  $manager->createData($resource)->toArray();
		$token = $JWTAuth->fromUser($user);
		return $this->response()->success($data, ['meta.token' => $token]);
	}

	public function detail(JWTAuth $JWTAuth)
	{
		$user =  $JWTAuth->parseToken()->authenticate();
		$marker_id = $this->request->get('marker_id');
		$type = $this->request->get('type');
		$data = [];
		if($type == 1) {

			$place = Place::where('marker_id', $marker_id)->first();
			if($place) {
				$manager = new \League\Fractal\Manager();
				$manager->parseIncludes(['address', 'featured_users', 'featured_users.user', 'photos']);
				$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
				$resource = new Fractal\Resource\Item($place, new PlaceTransformer($user->id));
				$data =  $manager->createData($resource)->toArray();
			}
		} else {
			$comunity = Comunitie::where('marker_id', $marker_id)->first();
			if($comunity) {
				$manager = new \League\Fractal\Manager();
				$manager->parseIncludes(['photos', 'address', 'featured_users', 'featured_users.user']);
				$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer());
				$resource = new Fractal\Resource\Item($comunity, new ComunityTransformer($user->id));
				$data =  $manager->createData($resource)->toArray();
			}
		}

		$token = $JWTAuth->fromUser($user);
		return $this->response()->success($data, ['meta.token' => $token]);
	}

	public function long(JWTAuth $JWTAuth)
	{
		// Marker::insert([
  //       	[
	 //            'name' => 'place 1',
	 //            'type' => 1,
	 //            'lat' => 37.386339,
	 //            'long' => -122.085823,
	 //            'full_address'	=> 'tanah abang'
	 //        ],
	 //        [
	 //            'name' => 'place 2',
	 //            'type' => 2,
	 //            'lat' => 37.38714,
	 //            'full_address'	=> 'tanah abang',
	 //            'long' => -122.083235,
	 //        ],
	 //        [
	 //            'name' => 'place 3',
	 //            'type' => 1,
	 //            'lat' => 37.393885,
	 //            'full_address'	=> 'tanah abang',
	 //            'long' => -122.078916,
	 //        ],
	 //        [
	 //            'name' => 'place 4',
	 //            'type' => 2,
	 //            'lat' => 37.402653,
	 //            'full_address'	=> 'tanah abang',
	 //            'long' => -122.079354,
	 //        ],
	 //        [
	 //            'name' => 'place 5',
	 //            'type' => 1,
	 //            'lat' => 37.394011,
	 //            'long' => -122.095528,
	 //            'full_address'	=> 'tanah abang',
	 //        ],
	 //        [
	 //            'name' => 'place 6',
	 //            'type' => 2,
	 //            'lat' => 37.401724,
	 //            'long' => -122.114646,
	 //            'full_address'	=> 'tanah abang'
	 //        ]
  //       ]);

		$long = $this->request->get('long');
		$lat = $this->request->get('lat');	
		$radius = $this->request->get('radius');	
		$radius += 5;

		$marker = DB::table('markers')
                     ->select(DB::raw('`id`, `long`, `lat`, `name`, `type`, `full_address`,
						(
							3959  * acos(
								cos(radians('.$lat.')) * cos(radians(`lat`)) * cos(
									radians(`LONG`) - radians('.$long.')
								) + sin(radians('.$lat.')) * sin(radians(`lat`))
							)
						) `distance`'))
                    ->having('distance', '<', $radius)
                    ->get();


		$markerUser = DB::table('users')
                 ->select(DB::raw('`id` , `long`, `lat`, 3 AS type, name ,
					(
						3959  * acos(
							cos(radians('.$lat.')) * cos(radians(`lat`)) * cos(
								radians(`LONG`) - radians('.$long.')
							) + sin(radians('.$lat.')) * sin(radians(`lat`))
						)
					) `distance`'))
                ->having('distance', '<', $radius)
                ->get();

        $merger = array_merge($marker, $markerUser);



	    $manager = new Manager();
		$manager->setSerializer(new \App\Repositories\CostumeDataArraySerializer('markers'));
		$resource = new Fractal\Resource\Collection($merger, new MarkerTransformer());
		$data =  $manager->createData($resource)->toArray();

		return $this->response()->success($data);
	}
}