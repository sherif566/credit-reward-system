<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditPackage extends Model
{
    protected $fillable =[
        'name',
        'price',
        'reward_points',
        'credits'
    ];


}
