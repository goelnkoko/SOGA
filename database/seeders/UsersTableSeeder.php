<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Nzinga Kazi',
                'username' => 'nzingakazi',
                'email' => 'nzinga_kazi1@example.com',
                'telefone' => '123456789',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mosi Nlandu',
                'username' => 'mosinlandu',
                'email' => 'mosi_nlandu2@example.com',
                'telefone' => '234567890',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kafwunyi Mbemba',
                'username' => 'kafwunyimbemba',
                'email' => 'kafwunyi_mbemba3@example.com',
                'telefone' => '345678901',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nkosi Lukasu',
                'username' => 'nkosilukasu',
                'email' => 'nkosi_lukasu4@example.com',
                'telefone' => '456789012',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tshibanda Nkumu',
                'username' => 'tshibandankumu',
                'email' => 'tshibanda_nkumu5@example.com',
                'telefone' => '567890123',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lukasu Nzinga',
                'username' => 'lukasunzinga',
                'email' => 'lukasu_nzinga6@example.com',
                'telefone' => '678901234',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mbemba Mosi',
                'username' => 'mbembamosi',
                'email' => 'mbemba_mosi7@example.com',
                'telefone' => '789012345',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nkumu Kafwunyi',
                'username' => 'nkumukafwunyi',
                'email' => 'nkumu_kafwunyi8@example.com',
                'telefone' => '890123456',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kazi Tshibanda',
                'username' => 'kazitshibanda',
                'email' => 'kazi_tshibanda9@example.com',
                'telefone' => '901234567',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nlandu Nkosi',
                'username' => 'nlandunkosi',
                'email' => 'nlandu_nkosi10@example.com',
                'telefone' => '012345678',
                'password' => bcrypt('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);

            // Criar o perfil correspondente para cada usuário
            Profile::create([
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
