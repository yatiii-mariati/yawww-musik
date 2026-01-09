<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('album_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');
            $table->integer('duration')->default(0);
            $table->string('audio_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
