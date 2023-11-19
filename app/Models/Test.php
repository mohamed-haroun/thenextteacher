<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['test_type_id', 'user_id', 'subject_id', 'grade_id', 'duration', 'degree'];

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'test_lessons');
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'test_questions');
    }

    public function test_type(): BelongsTo
    {
        return $this->belongsTo(TestType::class, 'test_type_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function studentAnswers(): HasMany
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
