<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable= [
        'user_id',
        'credit_package_id'
    ];
}
