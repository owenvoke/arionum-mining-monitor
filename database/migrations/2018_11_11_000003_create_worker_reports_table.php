<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateWorkerReportsTable
 */
class CreateWorkerReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('worker_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('worker_id');
            $table->integer('hashes');
            $table->integer('elapsed');
            $table->decimal('rate', 20, 3);
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
        Schema::table('worker_reports', function (Blueprint $table) {
            $table->dropForeign(['worker_id']);
        });
        Schema::dropIfExists('worker_reports');
    }
}
