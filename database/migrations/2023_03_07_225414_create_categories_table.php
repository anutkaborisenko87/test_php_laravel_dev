<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50)->unique();
            $table->string('description', 250);
        });

        Schema::create('category_lot', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('lot_id')->constrained('lots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('category_lot');
    }
}
