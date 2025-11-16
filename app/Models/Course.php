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

    public function assignments()
    {
        return $this->hasMany(UserCourseAssignment::class, 'COURSE_ID', 'ID');
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'USER_COURSE_ASSIGNMENTS', 'COURSE_ID', 'USER_ID', 'ID', 'ID')
            ->withPivot(['ASSIGNED_AT', 'COMPLETED_AT', 'PROGRESS_PERCENTAGE'])
            ->withTimestamps();
    }
}
