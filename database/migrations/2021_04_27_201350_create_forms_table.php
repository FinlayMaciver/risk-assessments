<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
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
            $table->string('type');
            $table->string('title');
            $table->string('status');
            $table->boolean('multi_user')->default(false);
            $table->string('location');
            $table->string('description');
            $table->string('control_measures');
            $table->string('work_site');
            $table->string('further_risks')->nullable();
            $table->string('disposal_methods');

            //Equipment
            $table->boolean('eye_protection')->default(false);
            $table->boolean('face_protection')->default(false);
            $table->boolean('hand_protection')->default(false);
            $table->boolean('foot_protection')->default(false);
            $table->boolean('respiratory_protection')->default(false);
            $table->string('other_protection')->nullable();

            //Emergencies
            $table->boolean('instructions')->default(false);
            $table->boolean('spill_neutralisation')->default(false);
            $table->boolean('eye_irrigation')->default(false);
            $table->boolean('body_shower')->default(false);
            $table->boolean('first_aid')->default(false);
            $table->boolean('breathing_apparatus')->default(false);
            $table->boolean('external_services')->default(false);
            $table->boolean('poison_antidote')->default(false);
            $table->string('other_emergency')->nullable();

            //Supervision
            $table->boolean('routine_approval')->default(false);
            $table->boolean('specific_approval')->default(false);
            $table->boolean('personal_supervision')->default(false);

            //Monitoring
            $table->boolean('airborne_monitoring')->default(false);
            $table->boolean('biological_monitoring')->default(false);

            //Informing
            $table->boolean('inform_lab_occupants')->default(false);
            $table->boolean('inform_cleaners')->default(false);
            $table->boolean('inform_contractors')->default(false);
            $table->string('inform_other')->nullable();

            //Supervisor/Guardians
            $table->foreignId('supervisor_id')->constrained('users');
            $table->foreignId('lab_guardian_id')->constrained('users');

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
}
