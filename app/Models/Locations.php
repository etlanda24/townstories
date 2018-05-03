<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 9/20/17
 * Time: 5:32 PM
 */
class Locations extends Model
{
    protected $table = 'tbl_location';
    protected $primaryKey = 'location_id';



    public function contents()
    {
        return $this->hasMany(LocationsContent::class, 'location_id', 'location_id');
    }


    /*public function content()
    {
//        return $this->hasOne(LocationsContent::class, 'location_id', 'location_id')->where('language_id', 2);
        return $this->hasOne(LocationsContent::class, 'location_id', 'location_id');
    }*/

    public function category()
    {
        return $this->hasOne(Categories::class, 'category_id', 'category_id');
    }
    /*public function locationContentServices()
    {
        return $this->hasMany(LocationContentServices::class, 'location_content_id', 'location_id');
    }*/
}