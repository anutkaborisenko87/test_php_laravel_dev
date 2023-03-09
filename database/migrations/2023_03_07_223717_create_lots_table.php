<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->string('description', 250);
            $table->decimal('start_price', 10, 2)->unsigned();
            $table->decimal('auction_price', 10, 2)->unsigned()->nullable();
            $table->boolean('sold')->default(false);
            $table->boolean('auction_active')->default(true);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lots');
    }
}
