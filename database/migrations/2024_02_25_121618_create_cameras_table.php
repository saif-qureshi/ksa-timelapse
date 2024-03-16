<?php

use App\Models\Developer;
use App\Models\Project;
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
        Schema::create('cameras', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('index')->unsigned();
            $table->string('name', 191);
            $table->string('access_token', 191);
            $table->text('description');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->foreignIdFor(Developer::class)->cascadeOnDelete();
            $table->foreignIdFor(Project::class)->cascadeOnDelete();
            $table->string('video_template_1', 191) ->nullable();
            $table->string('video_template_2', 191) ->nullable();
            $table->tinyInteger('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cameras');
    }
};
