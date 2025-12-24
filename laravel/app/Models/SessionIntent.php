<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionIntent extends Model
{
    protected $table = 'session_intent';

    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'status',
        'time',
        'intent',
    ];

    protected $casts = [
        'status' => 'boolean',
        'time' => 'datetime',
    ];
}
