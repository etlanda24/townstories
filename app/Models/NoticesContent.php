<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 9/29/17
 * Time: 2:35 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NoticesContent extends model
{
    protected $table = 'tbl_notices_content';

    protected $primaryKey = 'id';


    public function content()
    {
        return $this->belongsTo(Notices::class, "id", "notice_id");
    }
}