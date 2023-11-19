<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Grade::create([
            'title' => 'Grade 1',
            'school' => 'primary'
        ]);

        Grade::create([
            'title' => 'Grade 2',
            'school' => 'primary'
        ]);

        Grade::create([
            'title' => 'Grade 3',
            'school' => 'primary'
        ]);

        Grade::create([
            'title' => 'Grade 4',
            'school' => 'primary'
        ]);

        Grade::create([
            'title' => 'Grade 5',
            'school' => 'primary'
        ]);

        Grade::create([
            'title' => 'Grade 6',
            'school' => 'primary'
        ]);

        Grade::create([
            'title' => 'Grade 7',
            'school' => 'preparatory'
        ]);

        Grade::create([
            'title' => 'Grade 8',
            'school' => 'preparatory'
        ]);

        Grade::create([
            'title' => 'Grade 9',
            'school' => 'preparatory'
        ]);

        Grade::create([
            'title' => 'Grade 10',
            'school' => 'secondary'
        ]);

        Grade::create([
            'title' => 'Grade 11',
            'school' => 'secondary'
        ]);

        Grade::create([
            'title' => 'Grade 12',
            'school' => 'secondary'
        ]);
    }
}
