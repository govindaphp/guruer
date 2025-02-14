<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Authenticatable
{
    use HasFactory;
    protected $table = 'vendors';

    protected $primaryKey = 'vendor_id';
    
    public function getAuthIdentifierName()
    {
        return 'vendor_id'; // Tell Laravel to use `vendor_id` for authentication
    }
}
