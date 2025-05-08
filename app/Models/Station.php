<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'title',
        'description',
        'latitude',
        'longitude',
    ];
    public function routes()
    {
        return $this->belongsToMany(Route::class, 'route_stations', 'station_id', 'route_id')->withPivot('time');
    }
}
