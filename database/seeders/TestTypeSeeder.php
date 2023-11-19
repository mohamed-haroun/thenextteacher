<?php

namespace Database\Seeders;

use App\Models\TestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TestType::create([
            'type' => 'exam'
        ]);

        TestType::create([
            'type' => 'quiz'
        ]);

        TestType::create([
            'type' => 'revision'
        ]);

        TestType::create([
            'type' => 'booklet'
        ]);

        TestType::create([
            'type' => 'custom'
        ]);
    }
}
