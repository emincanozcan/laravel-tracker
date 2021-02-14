<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackerActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracker_activities', function (Blueprint $table) {
            $table->id();
            $table->string('request_id', 20);
            $table->unsignedBigInteger('trackable_id')->nullable(); # null for visitors.
            $table->string('trackable_type', 255);
            $table->ipAddress('ip_address')->nullable();
            $table->string('action')->nullable();
            $table->text('message')->nullable();
            $table->json('additional_data')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracker_activities');
    }
}
