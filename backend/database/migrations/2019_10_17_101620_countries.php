<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Countries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            //
            // id`, `iso`, `name_en`, `name_de`, `nicename`, `iso3`, `numcode`, `phonecode`, `created_at`, `updated_at`
            //
            $table->bigIncrements('id');
            $table->json('name');
            $table->string('iso', 2);
            $table->string('iso3', 3)->nullable();
            $table->integer('numcode')->nullable();
            $table->integer('phonecode')->nullable();
            $table->timestamps();
        });

        $seeder = new CountriesSeeder;
        $seeder->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
