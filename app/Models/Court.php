<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'court_id',
        'venue_id',
        'name',
        'is_active',
    ];

}
