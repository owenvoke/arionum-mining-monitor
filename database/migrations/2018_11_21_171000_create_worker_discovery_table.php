<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateWorkerDiscoveryTable
 */
class CreateWorkerDiscoveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_discovery', function (Blueprint $table) {
            $table->unsignedInteger('worker');
            $table->date('date');
            $table->integer('difficulty');
            $table->integer('dl');
            $table->string('nonce');
            $table->string('argon');
            $table->tinyInteger('retries');
            $table->boolean('confirmed');

            $table->foreign('worker')->references('id')->on('workers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('worker_discovery', function (Blueprint $table) {
            $table->dropForeign(['worker']);
        });
        Schema::dropIfExists('worker_discovery');
    }
}
