<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            'Mobile Apps',
            'QA',
            'Full Stack',
            'Backend',
            'Frontend',
            'UI/UX Designer'
        ];

        foreach ($divisions as $division) {
            DB::table('divisions')->insert([
                'id' => Str::uuid(),
                'name' => $division,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
    }
}
