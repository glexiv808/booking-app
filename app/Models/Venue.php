<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MatanYadaev\EloquentSpatial\Objects\Point;

class Venue extends Model
{
    use HasFactory;

    protected $casts = [
        'coordinates' => Point::class,
    ];

    protected $table = 'venues';
    protected $primaryKey = 'venue_id';
    protected $keyType = 'string';
    protected $fillable = [
        'venue_id',
        'owner_id',
        'name',
        'address',
        'longitude',
        'latitude',
        'coordinates',
        'status',
    ];
}
