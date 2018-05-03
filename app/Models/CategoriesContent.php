<?php
/**
 * Created by PhpStorm.
 * User: cahaya
 * Date: 9/29/17
 * Time: 4:18 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CategoriesContent extends model
{
    protected $table = 'tbl_categories_content';

    protected $primaryKey = 'id';


    public function content()
    {
        return $this->belongsTo(Categories::class, "id", "category_id");
    }


}