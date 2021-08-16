<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'address',
        'user_id',
        'profile_picture',
        'experience',
        'previous_school',
        'current_school',
        'expertise_in_subjects',
    ];

    protected $casts = [
        'expertise_in_subjects' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
