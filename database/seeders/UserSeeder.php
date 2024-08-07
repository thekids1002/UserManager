<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash};
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $lastNames = ['Nguyen', 'Tran', 'Le', 'Pham', 'Hoang'];
        $firstNames = ['John', 'Jane', 'Michael', 'Emily', 'David', 'Sophia'];

        $data = [];
        for ($i = 1; $i <= 100; $i++) {
            $randomLastName = $lastNames[array_rand($lastNames)];
            $randomFirstName = $firstNames[array_rand($firstNames)];

            $randomFullName = $randomLastName . ' ' . $randomFirstName;
            $data[] = [
                'email' => Str::lower($randomLastName . $randomFirstName) . $i . '@test.com',
                'password' => Hash::make('123456'),
                'name' => $randomFullName,
                'group_id' => rand(0, 10),
                'started_date' => Carbon::now(),
                'position_id' => rand(0, 3),
                'created_date' => Carbon::now(),
                'updated_date' => Carbon::now(),
                'deleted_date' => null,
            ];
        }
        DB::table('user')->insert($data);
    }
}
