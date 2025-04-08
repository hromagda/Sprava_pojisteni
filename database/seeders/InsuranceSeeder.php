<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsuranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $insurances = [
            'Životní pojištění',
            'Cestovní pojištění',
            'Pojištění domácnosti',
            'Havarijní pojištění',
            'Úrazové pojištění',
            'Pojištění majetku',
            'Pojištění odpovědnosti',
            'Zdravotní pojištění'
        ];

        foreach ($insurances as $insurance) {
            DB::table('insurances')->insert([
                'name' => $insurance,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
