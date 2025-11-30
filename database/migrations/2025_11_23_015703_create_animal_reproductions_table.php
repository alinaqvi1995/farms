<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animal_reproductions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('animal_id');
            $table->unsignedBigInteger('farm_id');

            $table->enum('type', ['heat', 'mating', 'ai', 'pregnancy_check', 'calving']);
            $table->date('event_date');

            $table->unsignedBigInteger('male_animal_id')->nullable(); // for natural mating
            $table->string('semen_batch')->nullable(); // for AI

            $table->enum('pregnancy_result', ['positive', 'negative', 'unknown'])->nullable();
            $table->string('calf_tag')->nullable();
            $table->enum('calf_gender', ['male', 'female'])->nullable();

            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
            $table->foreign('male_animal_id')->references('id')->on('animals')->nullOnDelete();
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_reproductions');
    }
};
