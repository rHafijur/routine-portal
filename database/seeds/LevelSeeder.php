<?php

use Illuminate\Database\Seeder;
use App\Level;
class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Level::create(['title'=>'Level 1 Term 1']);
        Level::create(['title'=>'Level 1 Term 2']);
        Level::create(['title'=>'Level 1 Term 3']);
        Level::create(['title'=>'Level 2 Term 1']);
        Level::create(['title'=>'Level 2 Term 2']);
        Level::create(['title'=>'Level 2 Term 3']);
        Level::create(['title'=>'Level 3 Term 1']);
        Level::create(['title'=>'Level 3 Term 2']);
        Level::create(['title'=>'Level 3 Term 3']);
        Level::create(['title'=>'Level 4 Term 1']);
        Level::create(['title'=>'Level 4 Term 2']);
        Level::create(['title'=>'Level 4 Term 3']);
    }
}
