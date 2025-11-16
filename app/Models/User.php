<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'USERS';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'NAME',
        'EMAIL',
        'PASSWORD',
        'ROLE',
        'EMAIL_VERIFIED_AT',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'PASSWORD',
        'REMEMBER_TOKEN',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'EMAIL_VERIFIED_AT' => 'datetime',
            'PASSWORD' => 'hashed',
        ];
    }

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'CREATED_AT';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'UPDATED_AT';

    /**
     * Check if user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->ROLE === 'admin';
    }

    /**
     * Check if user is a regular user.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->ROLE === 'user';
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'EMAIL';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'REMEMBER_TOKEN';
    }

    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->EMAIL_VERIFIED_AT);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'EMAIL_VERIFIED_AT' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->EMAIL;
    }

    /**
     * Get the course assignments for the user.
     */
    public function courseAssignments()
    {
        return $this->hasMany(UserCourseAssignment::class, 'USER_ID', 'ID');
    }

    /**
     * Get the courses assigned to the user.
     */
    public function assignedCourses()
    {
        return $this->belongsToMany(Course::class, 'USER_COURSE_ASSIGNMENTS', 'USER_ID', 'COURSE_ID', 'ID', 'ID')
            ->withPivot(['ASSIGNED_AT', 'COMPLETED_AT', 'PROGRESS_PERCENTAGE'])
            ->withTimestamps();
    }

    /**
     * Get the video progress for the user.
     */
    public function videoProgress()
    {
        return $this->hasMany(VideoProgress::class, 'USER_ID', 'ID');
    }
}
