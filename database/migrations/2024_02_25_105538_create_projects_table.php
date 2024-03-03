<?php

use App\Models\Developer;
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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->foreignIdFor(Developer::class)->constrained()->cascadeOnDelete();
            $table->string('tag', 191);
            $table->text('description');
            $table->tinyInteger('is_active')->default(true);
            $table->string('logo', 191);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
