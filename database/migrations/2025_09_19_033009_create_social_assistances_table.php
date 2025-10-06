<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_assistances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('thumbnail');
            $table->enum('category', ['staple','cash','subsidized fuel','health'])->default('staple');
            $table->decimal('amount',10,2)->default(0);
            $table->string('provider');
            $table->longText('description')->nullable();
            $table->boolean('is_available')->default(true);
            $table->softDeletes();
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
        Schema::dropIfExists('social_assistances');
    }
};
