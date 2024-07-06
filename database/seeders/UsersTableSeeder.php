<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Education;
use App\Models\Work;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Kikongo Names
        $names = [
            'Nzinga Kazi', 'Mosi Nlandu', 'Kafwunyi Mbemba', 'Nkosi Lukasu',
            'Tshibanda Nkumu', 'Lukasu Nzinga', 'Mbemba Mosi', 'Nkumu Kafwunyi',
            'Kazi Tshibanda', 'Nlandu Nkosi', 'Nkembwa Nkumbo'
        ];

        $usernames = [
            'nzingakazi', 'mosinlandu', 'kafwunyimbemba', 'nkosilukasu',
            'tshibandankumu', 'lukasunzinga', 'mbembamosi', 'nkumukafwunyi',
            'kazitshibanda', 'nlandunkosi', 'nkembwa'
        ];

        $emails = [
            'nzinga_kazi1@example.com', 'mosi_nlandu2@example.com', 'kafwunyi_mbemba3@example.com', 'nkosi_lukasu4@example.com',
            'tshibanda_nkumu5@example.com', 'lukasu_nzinga6@example.com', 'mbemba_mosi7@example.com', 'nkumu_kafwunyi8@example.com',
            'kazi_tshibanda9@example.com', 'nlandu_nkosi10@example.com', 'nkembwa@gmail.com'
        ];

        for ($i = 0; $i < 11; $i++) {
            $user = User::create([
                'username' => $usernames[$i],
                'password' => bcrypt('password'),
            ]);

            $profileData = [
                'user_id' => $user->id,
                'name' => $names[$i],
                'birthdate' => $i === 10 ? '2003-03-16' : $faker->date(),
                'gender' => $faker->randomElement(['Masculino', 'Feminino']),
                'location' => 'Luanda, Angola',
                'biography' => $i === 10 ? 'Nkembwa é um programador júnior que gosta de diversos estilos de músicas, incluindo Kpop, Tems e Calema, está sempre disposto a programar, mesmo que não tenha muita experiência.' : 'Esta é a biografia de ' . $names[$i] . '.',
                'hobbies' => $i === 10 ? json_encode(['Xadrez', 'Leitura', 'Amar']) : json_encode([$faker->word, $faker->word]),
                'interests' => $i === 10 ? json_encode(['Martial Arts', 'Formula 1', 'Mulher']) : json_encode([$faker->word, $faker->word]),
            ];

            $profile = Profile::create($profileData);

            // Seeding educations, works, and contacts for Nkembwa and three other users
            if ($i === 10 || $i < 3) {
                Education::create([
                    'profile_id' => $profile->id,
                    'institution' => $i === 10 ? 'Instituto Superior de Administração e Finanças' : 'Universidade de ' . $faker->city,
                    'description' => $i === 10 ? 'Estou estudando' : $faker->sentence,
                    'course' => $i === 10 ? 'Informática de Gestão Financeira' : 'Curso de ' . $faker->word,
                    'startDate' => $i === 10 ? '2021-10-10' : $faker->date(),
                ]);

                if ($i === 10) {
                    Education::create([
                        'profile_id' => $profile->id,
                        'institution' => 'Liceu do Nzeto',
                        'description' => 'Estive estudando',
                        'course' => 'Ciências Físicas e Biológicas',
                        'startDate' => '2017-02-10',
                    ]);
                }

                Work::create([
                    'profile_id' => $profile->id,
                    'job' => $i === 10 ? 'Software Engineer' : $faker->jobTitle,
                    'organization' => $i === 10 ? 'Fafnir S.A.' : $faker->company,
                    'description' => $i === 10 ? 'desenvolvo software a medida' : $faker->sentence,
                    'startDate' => $i === 10 ? '2024-03-03' : $faker->date(),
                ]);

                if ($i === 10) {
                    Work::create([
                        'profile_id' => $profile->id,
                        'job' => 'Garçon',
                        'organization' => 'Restaurante Kaka',
                        'description' => 'sirvo aos queridos clientes',
                        'startDate' => '2024-06-30',
                    ]);

                    Work::create([
                        'profile_id' => $profile->id,
                        'job' => 'Ator Pornô',
                        'organization' => 'Inácio Videos',
                        'description' => 'sem legendas',
                        'startDate' => '2021-07-08',
                    ]);
                }

                Contact::create([
                    'profile_id' => $profile->id,
                    'type' => 'email',
                    'contact' => $i === 10 ? 'nkembwa@gmail.com' : $emails[$i],
                ]);

                Contact::create([
                    'profile_id' => $profile->id,
                    'type' => 'phone',
                    'contact' => $i === 10 ? '987654321' : $faker->phoneNumber,
                ]);
            }
        }
    }
}
