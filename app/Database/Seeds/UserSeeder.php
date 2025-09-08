<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        // $faker = \Faker\Factory::create();
        $data = [
            'username' => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
        ];
        $this->db->table('users')->insert($data);
    }
}
