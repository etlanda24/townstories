<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 9/29/17
 * Time: 6:24 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'tbl_services';
    protected $primaryKey = 'id';

    public function locationContentService()
    {
        return $this->belongsTo(LocationContentServices::class, 'id', 'location_content_id');
    }
}