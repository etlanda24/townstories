<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 9/20/17
 * Time: 6:25 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LocationsContent extends model
{
    protected $table = 'tbl_location_content';

    protected $primaryKey = 'location_id';


    public function location()
    {
        return $this->belongsTo(Locations::class, "location_id", "location_id");
    }

    public function locationContentServices()
    {
        return $this->hasMany(LocationContentServices::class, 'location_content_id', 'id');
    }
}