<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerImage extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'image_path'];
}
