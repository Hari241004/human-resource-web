<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use App\Models\Recruitment;
use App\Models\Department;
use Faker\Factory as Faker;

class RecruitmentSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Ambil semua departemen yang punya posisi
        $depts = Department::with('positions')
                   ->get()
                   ->filter(fn($d) => $d->positions->isNotEmpty());

        if ($depts->isEmpty()) {
            $this->command->info('Tidak ada department/position terdaftar.');
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            $dept = $depts->random();
            $pos  = $dept->positions->random();

            // 1. Generate nama & email
            $name = $faker->name();
            // ubah spasi jadi titik, lowercase, tambahkan suffix acak agar unik
            $localPart = strtolower(str_replace(' ', '.', $name))
                         . '.' . $faker->unique()->numberBetween(1,999);
            $email = $localPart . '@example.com';

            // data lain
            $gender      = $faker->randomElement(['Laki-laki','Perempuan']);
            $dob         = $faker->date('Y-m-d', '-18 years');
            $tmt         = $faker->date('Y-m-d', '-1 years');
            $contractEnd = $faker->date('Y-m-d', '+1 year');
            $salary      = $faker->numberBetween(4_000_000, 12_000_000);
            $phone       = $faker->numerify('08##########');

            // 2. Buat User
            $user = User::create([
                'name'     => $name,
                'email'    => $email,
                'password' => Hash::make('password'),
                'role'     => 'user',
            ]);

            // 3. Buat Employee
            $employee = Employee::create([
                'user_id'             => $user->id,
                'name'                => $name,
                'nik'                 => $faker->unique()->numerify('################'),
                'email'               => $email,
                'gender'              => $gender,
                'title'               => $pos->name,
                'photo'               => null,
                'phone'               => $phone,
                'date_of_birth'       => $dob,
                'tmt'                 => $tmt,
                'contract_end_date'   => $contractEnd,
                'department_id'       => $dept->id,
                'position_id'         => $pos->id,
                'bank_name'           => 'Mandiri',
                'bank_account_name'   => $name,
                'bank_account_number' => $faker->numerify('############'),
                // sinkron salary ke employees
                'salary'              => $salary,
            ]);

            // 4. Buat Recruitment
            Recruitment::create([
                'user_id'             => $user->id,
                'employee_id'         => $employee->id,
                'name'                => $name,
                'address'             => $faker->address,
                'place_of_birth'      => $faker->city,
                'date_of_birth'       => $dob,
                'kk_number'           => $faker->numerify('################'),
                'religion'            => $faker->randomElement(['ISLAM','KRISTEN','KATHOLIK','HINDU','BUDDHA']),
                'gender'              => $gender,
                'department_id'       => $dept->id,
                'position_id'         => $pos->id,
                'tmt'                 => $tmt,
                'contract_end_date'   => $contractEnd,
                'phone'               => $phone,
                'marital_status'      => $faker->randomElement(['Sudah Kawin','Belum Kawin']),
                'education'           => $faker->randomElement(['S1','S2','S3']),
                'salary'              => $salary,
                'photo'               => null,
                'title'               => $pos->name,
                'bank_account_name'   => $name,
                'bank_account_number' => $employee->bank_account_number,
                'email'               => $email,
                'password'            => Hash::make('password'),
            ]);
        }

        $this->command->info('Berhasil membuat 10 recruitment records baru.');
    }
}
