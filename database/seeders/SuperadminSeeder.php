<?php

namespace Database\Seeders;

use App\Models\Aggregator;
use App\Models\Department;
use App\Models\User;
use App\Traits\UploadFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SuperadminSeeder extends Seeder
{
    use UploadFile;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = $this->GetApiImage('people', 1);

        $data = [
            'name'                  => 'super_admin',
            'email'                 => 'super_admin@ivas.com',
            'password'              => 123,
            'aggregator_id'         => Aggregator::first()->id,
            'department_id'         => Department::first()->id,
            'annual_credit'         => 100,
            'finger_print_id'       => 1,
            'salary_per_monthly'    => 4000,
            'insurance_deduction'   => 190,
            'email_verified_at'     => now(),
            'remember_token'        => Str::random(10),
            'image'                 => $this->uploadApiImage($images[0]['src']['medium'], 'users')
        ];

        $user = User::firstOrCreate(['email' => $data['email']], $data);
        Department::get()->each(function($row) use($user) {
            $row->update(['manager_id' => $user->id, 'manager_of_manager_id' => $user->id]);
        });
        $user->assignRole('super admin');
    }
}
