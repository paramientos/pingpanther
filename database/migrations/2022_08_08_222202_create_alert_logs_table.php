<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('alert_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('check_id');
            $table->text('params')->nullable();
            $table->string('event');
            $table->boolean('is_initial')->default(false);
            $table->text('result')->nullable();
            $table->string('notified_to')->nullable();
            $table->string('notified_with')->nullable();
            $table->text('alert_message')->nullable();
            $table->timestamp('created_at');

            $table->index([
                'check_id', 'event', 'params', 'created_at'
            ]);

            $table->foreign('check_id')->references('id')->on('monitors');
        });
    }


    public function down()
    {
        Schema::dropIfExists('alert_logs');
    }
};
