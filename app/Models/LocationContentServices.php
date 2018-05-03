<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 10/4/17
 * Time: 5:18 PM
 */

namespace App\Models;


use Barryvdh\Reflection\DocBlock\Location;
use Illuminate\Database\Eloquent\Model;

class LocationContentServices extends Model
{
    protected $table = 'tbl_location_content_services';
    protected $primaryKey = 'id';

    public function service()
    {
        return $this->hasOne(Services::class, 'id', 'service_id');
    }

    public function locationContent()
    {
        return $this->belongsTo(LocationsContent::class, 'id', 'location_content_id');
    }
}