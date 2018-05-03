<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{

    protected $table = 'tbl_jobs';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function contents()
    {
        return $this->hasMany(JobsContent::class, 'job_id', 'id');
    }

}
