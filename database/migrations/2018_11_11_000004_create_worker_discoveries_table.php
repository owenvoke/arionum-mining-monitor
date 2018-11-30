<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateWorkerDiscoveriesTable
 */
class CreateWorkerDiscoveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('worker_discoveries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('worker_id');
            $table->integer('difficulty');
            $table->integer('dl');
            $table->string('nonce');
            $table->string('argon');
            $table->tinyInteger('retries');
            $table->boolean('confirmed');
            $table->timestamps();

            $table->foreign('worker_id')->references('id')->on('workers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('worker_discoveries', function (Blueprint $table) {
            $table->dropForeign(['worker_id']);
        });
        Schema::dropIfExists('worker_discoveries');
    }
}
