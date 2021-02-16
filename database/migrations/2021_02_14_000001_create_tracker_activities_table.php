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
            $table->string('request_id');
            $table->unsignedBigInteger('trackable_id')->nullable();
            $table->string('trackable_type');
            $table->ipAddress('ip_address')->nullable();
            $table->string('action')->nullable();
            $table->text('message')->nullable();
            $table->json('additional_data')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index('ip_address');
            $table->index('trackable_id');
            $table->index('request_id');
            $table->index('trackable_type');
            $table->index('action');
            $table->index(['trackable_type', 'action']);
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
