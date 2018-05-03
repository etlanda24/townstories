<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model 
{
    
     protected $table = 'tbl_slideshows';

    protected $primaryKey = 'id';

    public function notice()
    {
        return $this->hasOne(Notices::class, 'id', 'link');
    }

    public function location()
    {
        return $this->hasOne(Locations::class, 'location_id', 'link');
    }

}
