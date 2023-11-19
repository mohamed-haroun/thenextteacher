<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'school'];

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_grades');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }
}
