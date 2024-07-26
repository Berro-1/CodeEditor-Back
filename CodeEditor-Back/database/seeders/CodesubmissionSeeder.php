<?php

namespace Database\Seeders;

use App\Models\Codesubmission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CodesubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Codesubmission::factory(50)->create();
        
    }
}
