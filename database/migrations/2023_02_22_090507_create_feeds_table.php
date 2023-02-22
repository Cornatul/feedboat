<?php

use Cornatul\Feeds\Models\Feed;
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
        Schema::create('feeds', static function (Blueprint $table) {
            $table->id();
            $table->string('title')->index()->nullable();
            $table->string('url')->index()->nullable();
            $table->string('status')->index()->default(Feed::INITIAL);
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
        Schema::dropIfExists('feeds');
    }
};
