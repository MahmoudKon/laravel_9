<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_roles', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id();
            $table->string('name');
        });

        DB::table('task_roles')->insert([
            ['name' => 'super admin'],
            ['name' => 'admin'],
            ['name' => 'user'],
        ]);

        Schema::create('task_permissions', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->id();
            $table->string('name');
        });

        DB::table('task_permissions')->insert([
            ['name' => 'list users'],
            ['name' => 'list posts'],
            ['name' => 'list comments'],
            ['name' => 'list categories'],
        ]);

        Schema::create('task_role_permissions', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->foreignId('task_role_id')->constrained('task_roles')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('task_permission_id')->constrained('task_permissions')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::create('task_user_roles', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('task_role_id')->constrained('task_roles')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::create('task_user_permissions', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('task_permission_id')->constrained('task_permissions')->cascadeOnUpdate()->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_roles');
    }
};
