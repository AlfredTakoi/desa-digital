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
        Schema::create('social_assistance_recipients', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('social_assistance_id');
            $table->foreign('social_assistance_id')->references('id')->on('social_assistances');
            $table->uuid('head_of_family_id');
            $table->foreign('head_of_family_id')->references('id')->on('head_of_families');
            $table->decimal('amount',10,2)->default(0);
            $table->longText('reason');
            $table->enum('bank', ['bca','bni','bri','mandiri'])->default('bca');
            $table->integer('account_number');
            $table->string('proof');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
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
        Schema::dropIfExists('social_assistance_recipients');
    }
};
