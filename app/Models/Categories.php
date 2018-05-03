<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{

    protected $table = 'tbl_categories';

    protected $primaryKey = 'category_id';

    public function contents()
    {
        return $this->hasMany(CategoriesContent::class, 'category_id', 'category_id');
    }
}
