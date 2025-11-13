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
}
