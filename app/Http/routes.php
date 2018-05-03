<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', 'AuthController@getUser');
$app->get('users', 'AuthController@getUser');
$app->get('version', 'MasterController@getVersion');
$app->get('categories', 'MasterController@getCategories');
$app->get('region', 'MasterController@getRegion');
$app->get('slideshow', 'MasterController@getSlideshow');
$app->get('jobs', 'MasterController@getJobs');
$app->get('emergencyContact', 'MasterController@getContact');
$app->get('notices', 'MasterController@getNotices');
$app->get('services', 'MasterController@getServices');
$app->get('keywords', 'MasterController@getKeywords');
$app->get('nearby', 'LocationController@getPlaceNearby');
$app->get('location', 'LocationController@getLocation');
$app->get('locationByService', 'LocationController@getLocationByService');




