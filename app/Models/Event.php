<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $guarded = [];


    protected $casts = [
        'guest_list' => 'array',
        'guest_options' => 'array',
    ];
}
