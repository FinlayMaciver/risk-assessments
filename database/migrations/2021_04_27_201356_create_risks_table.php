<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')->constrained()->onDelete('cascade');
            $table->string('hazard');
            $table->string('consequences');
            $table->foreignId('likelihood_without')->constrained('likelihoods')->onDelete('cascade');
            $table->foreignId('impact_without')->constrained('impacts')->onDelete('cascade');
            $table->string('control_measures')->nullable();
            $table->foreignId('likelihood_with')->constrained('likelihoods')->onDelete('cascade');
            $table->foreignId('impact_with')->constrained('impacts')->onDelete('cascade');
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('risks');
    }
};
