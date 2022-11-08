<?php

use App\Fleet;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class FleetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fleets')->truncate();
        DB::table('fleet_cards')->truncate();
        DB::table('fleet_wallet')->truncate();

        Fleet::create([
            'name' => 'Franquia Demo',
            'commission' => 15.0,
            'city_id' => 767,
            'admin_id' => 1,
        ]);

    }
}
