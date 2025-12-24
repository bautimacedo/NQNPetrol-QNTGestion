<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherLog extends Model
{
    protected $table = 'weather_logs';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'recorded_at',
        'city_name',
        'temp_celsius',
        'wind_speed_ms',
        'wind_gust_ms',
        'visibility_meters',
        'condition_main',
        'condition_desc',
        'is_flyable',
    ];

    protected $casts = [
        'temp_celsius' => 'float',
        'wind_speed_ms' => 'float',
        'wind_gust_ms' => 'float',
        'visibility_meters' => 'integer',
        'recorded_at' => 'datetime',
        'is_flyable' => 'boolean',
    ];
}
