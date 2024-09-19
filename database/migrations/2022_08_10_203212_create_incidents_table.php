<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('check_id');

            $table->string('event');
            $table->timestamp('occurred_at');
            $table->timestamp('resolved_at')->nullable();

            $table->index([
                'check_id', 'occurred_at', 'resolved_at',
            ]);

            $table->foreign('check_id')->references('id')->on('monitors');
        });
    }


    public function down()
    {
        Schema::dropIfExists('incidents');
    }
};
