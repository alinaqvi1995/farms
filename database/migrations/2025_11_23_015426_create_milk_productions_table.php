<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('milk_productions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('animal_id');
            $table->unsignedBigInteger('farm_id');

            // Fixed sessions
            $table->enum('session', ['morning', 'afternoon', 'evening', 'night']);

            $table->decimal('litres', 8, 2)->default(0);

            $table->dateTime('recorded_at'); // date + time of milking
            $table->text('notes')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Foreign keys
            $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
            $table->foreign('farm_id')->references('id')->on('farms')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('milk_productions');
    }
};
