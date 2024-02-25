<?php

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', Roles::toArray());
            $table->tinyInteger('is_active')->default(true);
            $table->tinyInteger('can_create_user')->default(false);
            $table->tinyInteger('can_create_video')->default(false);
            $table->rememberToken();
            $table->timestamp('last_login_at')->default(null);
            $table->timestamps();
        });

        $this->createDefaultAdmin();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }

    public function createDefaultAdmin()
    {
        User::create([
            'first_name' => 'Master',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('Pa$$w0rd!@#'),
            'email_verified_at' => now(),
            'role' => Roles::ADMIN,
            'is_active' => true,
            'can_create_user' => true,
            'can_create_video' => true,
        ]);
    }
};
