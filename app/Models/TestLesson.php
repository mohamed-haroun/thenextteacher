<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestLesson extends Model
{
    use HasFactory;

    protected $fillable = ['lesson_id', 'test_id'];
}
