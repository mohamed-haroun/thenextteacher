<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create(['title' => 'Arabic', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'Math', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'English', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'Religion', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'Social Studies', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'Science', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'ICT', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'French', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'Geology', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'Chemistry', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'Physics', 'school_lang' => 'Arabic']);
        Subject::create(['title' => 'Biology', 'school_lang' => 'Arabic']);
    }
}
