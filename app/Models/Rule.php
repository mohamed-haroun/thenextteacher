<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = ['question_type_id', 'count', 'test_type_id'];

    public function test_type(): BelongsTo
    {
        return $this->belongsTo(TestType::class);
    }

    public function question_type(): BelongsTo
    {
        return $this->belongsTo(QuestionType::class);
    }
}
