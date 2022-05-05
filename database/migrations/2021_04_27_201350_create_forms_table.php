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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('title');
            $table->string('management_unit');
            $table->string('location');
            $table->timestamp('review_date');
            $table->string('description');
            $table->string('type');
            $table->string('status')->default('Pending');
            $table->boolean('multi_user')->default(false);

            //Supervisor
            $table->foreignId('supervisor_id')->nullable()->constrained('users');

            //Approval
            $table->boolean('supervisor_approval')->nullable()->default(null);
            $table->string('supervisor_comments')->nullable();

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
        Schema::dropIfExists('forms');
    }
};
