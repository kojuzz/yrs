<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $fillable = [
        'slug',
        'title',
        'description',
        'direction',
    ];
    public function stations()
    {
        return $this->belongsToMany(Station::class, 'route_stations', 'route_id', 'station_id')->withPivot('time');
    }
    public function acsrDirection(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                switch ($attributes['direction']) {
                    case 'clockwise':
                        $text = 'Clockwise';
                        $color = '16a34a';
                        break;
                    case 'anticlockwise':
                        $text = 'AntiClockwise';
                        $color = '2563eb';
                        break;
                    default:
                        $text = '';
                        $color = '4b5563';
                        break;
                }
                return [
                    'text' => $text,
                    'color' => $color
                ];
            }
        );
    }
}
