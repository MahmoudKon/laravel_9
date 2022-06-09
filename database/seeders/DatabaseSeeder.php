<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Post;
use App\Models\User;
use App\Traits\UploadFile;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use UploadFile;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $truncate_tables = ['menus', 'categories', 'countries', 'operators', 'aggregators', 'content_types', 'departments',
                            'roles', 'permissions', 'routes', 'users', 'settings', 'notifications', 'contents', 'posts'];

        Schema::disableForeignKeyConstraints();
            foreach ($truncate_tables as $table) {
                if (File::isDirectory(public_path("uploads/$table"))) {
                    File::deleteDirectory(public_path("uploads/$table"));
                }

                if (Schema::hasTable($table)) {
                    DB::table($table)->truncate();
                    echo "table $table truncated \n";
                } else {
                    echo "table $table doesn't exists \n";
                }
            }
        Schema::enableForeignKeyConstraints();

        $this->call(MenuSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(OperatorSeeder::class);
        $this->call(RouteSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AggregatorSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(SuperadminSeeder::class);
        $this->call(ContentTypeSeeder::class);
        Content::factory(10)->create();
        Post::factory(30)->create();

        $images = $this->GetApiImage('people');
        User::factory(30)->create()->each(function ($user) use($images) {
            try {
                $index = array_rand($images);
                $user->update(['image' => $this->uploadApiImage($images[$index]['src']['medium'], 'users')]);
                $user->roles()->attach(Role::where('id', '!=', 1)->inRandomOrder()->first()->id);
            } catch (Exception $e) {}
        });
    }
}
