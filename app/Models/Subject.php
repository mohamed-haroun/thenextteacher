<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'school_lang'];

    public function grades(): BelongsToMany
    {
        return $this->belongsToMany(Grade::class, 'subject_grades');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }

}
