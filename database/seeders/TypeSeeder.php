<?php

namespace Database\Seeders;

use App\Models\QuestionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QuestionType::create([
            'title' => 'mcq',
            'header' => 'Choose the correct answer from all of the following'
        ]);
        QuestionType::create([
            'title' => 'complete',
            'header' => 'Complete the following'
        ]);
        QuestionType::create([
            'title' => 'correct',
            'header' => 'Correct the underlined word'
        ]);
        QuestionType::create([
            'title' => 'check',
            'header' => 'Put True or False'
        ]);
        QuestionType::create([
            'title' => 'give reason',
            'header' => 'Give reason for'
        ]);
        QuestionType::create([
            'title' => 'what happens',
            'header' => 'What happens when'
        ]);
        QuestionType::create([
            'title' => 'scientific term',
            'header' => 'Write the scientific term for all of the following'
        ]);
        QuestionType::create([
            'title' => 'generic',
            'header' => null
        ]);
    }
}
