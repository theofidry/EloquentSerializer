<?php

/*
 * This file is part of the EloquentSerializer package.
 * 
 * (c) Théo FIDRY <theo.fidry@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * @author Théo FIDRY <theo.fidry@gmail.com>
 */
class CreateAnotherDummiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('another_dummies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('address');
        });

        Schema::table('dummies', function (Blueprint $table) {
            $table->unsignedInteger('another_dummy_id')->nullable();
            $table->foreign('another_dummy_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('another_dummies');

        Schema::table('dummies', function (Blueprint $table) {
            $table->dropForeign('another_dummy_id');
        });
    }
}
