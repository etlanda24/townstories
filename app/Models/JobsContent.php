<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobsContent extends Model
{

    protected $table = 'tbl_job_content';

    protected $primaryKey = 'id';


    public function job()
    {
        return $this->belongsTo(Jobs::class, "id", "job_id");
    }

}
