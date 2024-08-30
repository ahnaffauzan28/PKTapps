<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate([
            'username' => 'superadmin'
        ],[
            'name' => 'Superadmin',
            'npk' => 'superadmin',
            'ms_komparteman_id' => 1,
            'ms_departeman_id' => 1,
            'email' => 'superadmin@app.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Superadmin');
    }
}
