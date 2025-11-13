<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'COURSES';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'TITLE',
        'DESCRIPTION',
        'IS_ACTIVE',
    ];

    protected $casts = [
        'IS_ACTIVE' => 'boolean',
    ];

    public function videos()
    {
        return $this->hasMany(Video::class, 'COURSE_ID', 'ID');
    }
}
