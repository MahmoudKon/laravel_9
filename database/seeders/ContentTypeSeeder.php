<?php

namespace Database\Seeders;

use App\Models\ContentType;
use Illuminate\Database\Seeder;

class ContentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            'Advanced Text',
            'Normal Text',
            'Image',
            'Audio',
            'Video',
            'external video link',
            'selector',
            'Time',
            'Week Days'
        ];

        foreach ($types as $type) ContentType::firstOrCreate(['name' => $type], ['name' => $type]);
    }
}
