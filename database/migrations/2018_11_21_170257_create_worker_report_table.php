<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateWorkerReportTable
 */
class CreateWorkerReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_report', function (Blueprint $table) {
            $table->unsignedInteger('worker');
            $table->date('date');
            $table->integer('hashes');
            $table->integer('elapsed');
            $table->decimal('rate', 20, 3);

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
        Schema::table('worker_report', function (Blueprint $table) {
            $table->dropForeign(['worker']);
        });
        Schema::dropIfExists('worker_report');
    }
}
