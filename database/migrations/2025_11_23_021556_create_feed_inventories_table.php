<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('feed_inventories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('farm_id')->constrained()->cascadeOnDelete();

            $table->enum('entry_type', ['stock_in', 'consumption']); // add or use
            $table->decimal('quantity', 10, 2); // kg
            $table->string('feed_name')->nullable(); // optional, free text
            $table->decimal('cost_per_unit', 10, 2)->nullable(); // only for stock_in
            $table->string('vendor')->nullable(); // only for stock_in
            $table->date('date'); // date of entry
            $table->text('remarks')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_inventories');
    }
};
