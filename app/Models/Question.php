<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image','question_type_id', 'rating', 'lesson_id', 'user_id'];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }

    public function completions(): HasMany
    {
        return $this->hasMany(Completion::class);
    }

    public function checks(): HasOne
    {
        return $this->hasOne(Check::class);
    }

    public function correct(): HasOne
    {
        return $this->hasOne(Correct::class);
    }

    public function answerImages(): HasMany
    {
        return $this->hasMany(AnswerImage::class);
    }

    public function answer(): HasOne
    {
        return $this->hasOne(Answer::class);
    }
}
