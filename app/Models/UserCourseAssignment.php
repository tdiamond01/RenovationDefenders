<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCourseAssignment extends Model
{
    protected $table = 'USER_COURSE_ASSIGNMENTS';

    protected $primaryKey = 'ID';

    const CREATED_AT = 'CREATED_AT';
    const UPDATED_AT = 'UPDATED_AT';

    protected $fillable = [
        'USER_ID',
        'COURSE_ID',
        'ASSIGNED_AT',
        'COMPLETED_AT',
        'PROGRESS_PERCENTAGE',
    ];

    protected $casts = [
        'ASSIGNED_AT' => 'datetime',
        'COMPLETED_AT' => 'datetime',
        'PROGRESS_PERCENTAGE' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'USER_ID', 'ID');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'COURSE_ID', 'ID');
    }

    public function isCompleted()
    {
        return $this->PROGRESS_PERCENTAGE >= 100 || !is_null($this->COMPLETED_AT);
    }
}
