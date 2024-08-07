<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            
            $data[] = [
                'name' => 'Group'.$i,
                'note' => '',
                'group_leader_id' => $i,
                'group_floor_number' => rand(0, 10),
                'created_date' => Carbon::now(),
                'updated_date' => Carbon::now(),
                'updated_date' => Carbon::now(),
            ];
        }
        DB::table('group')->insert($data);
    }
}
