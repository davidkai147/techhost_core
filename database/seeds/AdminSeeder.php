<?php

use App\Models\Admin;
use App\Models\AdminGroups;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Admin::class, 1000)->create();
    }
}
