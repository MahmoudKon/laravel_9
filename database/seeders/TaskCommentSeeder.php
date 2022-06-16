<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $posts = DB::table('task_posts')->pluck('id', 'id')->toArray();

        for ($i = 0; $i < 120; $i++) {
            DB::table('task_comments')->insert([
                'comment' => $faker->sentence,
                'task_post_id' => array_rand($posts),
                'created_at' => $faker->dateTimeBetween('-30 days', '+30 days'),
            ]);
        }
    }
}
