<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'VIDEOS';

    protected $primaryKey = 'ID';

    const CREATED_AT = 'CREATED_AT';
    const UPDATED_AT = 'UPDATED_AT';

    protected $fillable = [
        'COURSE_ID',
        'TITLE',
        'DESCRIPTION',
        'FILE_PATH',
        'STORAGE_DRIVER',
        'DURATION',
        'MODULE',
        'ORDER',
        'IS_ACTIVE',
        'REQUIRED',
    ];

    protected $casts = [
        'IS_ACTIVE' => 'boolean',
        'REQUIRED' => 'boolean',
        'DURATION' => 'integer',
        'ORDER' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'COURSE_ID', 'ID');
    }

    public function progress()
    {
        return $this->hasMany(VideoProgress::class, 'VIDEO_ID', 'ID');
    }

    public function userProgress($userId)
    {
        return $this->progress()->where('USER_ID', $userId)->first();
    }

    /**
     * Get the video URL based on storage driver
     */
    public function getVideoUrlAttribute()
    {
        if ($this->STORAGE_DRIVER === 's3') {
            return \Storage::disk('s3-videos')->url($this->FILE_PATH);
        }

        // For local storage
        return asset('storage/' . $this->FILE_PATH);
    }

    /**
     * Get the thumbnail URL if available
     */
    public function getThumbnailUrlAttribute()
    {
        if (empty($this->THUMBNAIL_PATH)) {
            return null;
        }

        if ($this->STORAGE_DRIVER === 's3') {
            return \Storage::disk('s3-videos')->url($this->THUMBNAIL_PATH);
        }

        return asset('storage/' . $this->THUMBNAIL_PATH);
    }
}
