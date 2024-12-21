<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessProfile extends Model
{

    use HasFactory;
    use SoftDeletes;


    protected $guarded = [];





    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
