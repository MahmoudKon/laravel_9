<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskPostseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $data = [];
        for ($i = 0; $i < 100; $i++) {
            $data[$i] = [
                'title' => $faker->sentence,
                'user_id' => User::inRandomOrder()->first()->id,
                'category_id' => Category::inRandomOrder()->first()->id,
            ];
        }

        DB::table('task_posts')->insert($data);
    }
}
