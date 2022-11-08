<?php

use App\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();
        DB::table('admin_wallet')->truncate();
        $users = Admin::create([
            'name' => 'Mobub Admin',
            'email' => 'admin@admin.com',
            'mobile' => '(99)9 9999-9999',
            'password' => bcrypt('123456'),
        ]);

        //$role = Role::where('name', 'ADMIN')->first();

        $users->assignRole(2);


        $users = Admin::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'cpf' => '00000000000',
            'mobile' => '9999999-9999',
            'password' => bcrypt('123aB'),
        ]);

        $users->assignRole(1);

    }
}
