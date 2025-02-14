<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSharedFile extends Model
{
    use HasFactory;

    protected $table = "chat_shared_file";
    protected $primaryKey = 'id';
    public $timestamps = false;
}
