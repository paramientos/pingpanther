<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('check_id');
            $table->string('monitor_type');
            $table->uuid('alert_log_id')->nullable();
            $table->string('event')->nullable();
            $table->text('result_text')->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index([
                'check_id', 'monitor_type', 'alert_log_id', 'event'
            ]);

            $table->foreign('check_id')->references('id')->on('monitors');
            $table->foreign('alert_log_id')->references('id')->on('alert_logs');
        });
    }

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
