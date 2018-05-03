<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 9/20/17
 * Time: 5:32 PM
 */
class Notices extends Model
{
    protected $table = 'tbl_notices';
    protected $primaryKey = 'id';

    public function contents()
    {
        return $this->hasMany(NoticesContent::class, 'notice_id', 'id');
    }

    /*public function contents()
    {
        return $this->hasMany(LocationsContent::class, 'location_id', 'location_id');
    }
    public function category()
    {
        return $this->hasOne(Categories::class, 'category_id', 'category_id');
    }*/
}