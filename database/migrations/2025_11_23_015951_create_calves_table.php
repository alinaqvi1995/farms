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
        Schema::create('calves', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('mother_id')->nullable();  // animal who gave birth
            $table->unsignedBigInteger('farm_id')->nullable();

            $table->string('tag_number')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');

            $table->decimal('birth_weight', 8, 2)->nullable();
            $table->decimal('current_weight', 8, 2)->nullable();
            $table->date('weaning_date')->nullable();

            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('mother_id')->references('id')->on('animals')->nullOnDelete();
            $table->foreign('farm_id')->references('id')->on('farms')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calves');
    }
};
