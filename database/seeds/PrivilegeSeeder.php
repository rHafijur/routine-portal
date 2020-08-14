<?php

use Illuminate\Database\Seeder;
use App\Privilege;
class PrivilegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Privilege::create(['name'=>'Admin']);
        Privilege::create(['name'=>'Teacher']);
        Privilege::create(['name'=>'Student']);
    }
}
