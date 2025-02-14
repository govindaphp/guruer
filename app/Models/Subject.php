<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $primaryKey = 'id';

    public function category()

    {
        return $this->belongsTo(Category::class ,'category_id', 'category_id');
    }

    public function subcategory()

    {
        return $this->belongsTo(subCategory::class ,'subcategory_id', 'id');
    }

}
