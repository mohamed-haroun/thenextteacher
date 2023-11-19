<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['test_id', 'question_id', 'answer', 'correctness'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
