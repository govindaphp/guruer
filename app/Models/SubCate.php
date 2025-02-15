<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCate extends Model
{
    use HasFactory;

    protected $table = 'sub_category';
    protected $primaryKey = 'id';


    public function Category()
{
    
    return $this->belongsTo(Category::class, 'category_id', 'category_id');
}

}
