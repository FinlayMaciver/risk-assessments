<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMicroOrganismsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micro_organisms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained();
            $table->string('micro_organism');
            $table->string('classification');
            $table->string('risk');
            $table->string('single_acute_effect');
            $table->string('repeated_low_effect');
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
        Schema::dropIfExists('micro_organisms');
    }
}
