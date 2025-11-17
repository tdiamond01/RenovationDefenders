<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoProgress extends Model
{
    protected $table = 'VIDEO_PROGRESS';

    protected $primaryKey = 'ID';

    const CREATED_AT = 'CREATED_AT';
    const UPDATED_AT = 'UPDATED_AT';

    protected $fillable = [
        'USER_ID',
        'VIDEO_ID',
        'COMPLETED',
        'WATCH_TIME',
        'WATCHED_DURATION',
        'TOTAL_DURATION',
        'COMPLETED_AT',
        'LAST_WATCHED_AT',
    ];

    protected $casts = [
        'COMPLETED' => 'boolean',
        'WATCH_TIME' => 'integer',
        'WATCHED_DURATION' => 'integer',
        'TOTAL_DURATION' => 'integer',
        'COMPLETED_AT' => 'datetime',
        'LAST_WATCHED_AT' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID', 'ID');
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'VIDEO_ID', 'ID');
    }
}
