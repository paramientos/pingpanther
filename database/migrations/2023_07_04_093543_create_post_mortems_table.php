<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_mortems', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('monitor_id');
            $table->uuid('incident_id')->nullable();
            $table->text('notes');
            $table->boolean('is_resolved')->default(false);
            $table->uuid('created_by');
            $table->timestamp('created_at')->nullable();

            $table->index([
                'monitor_id', 'incident_id', 'is_resolved',
            ]);

            $table->foreign('monitor_id')->references('id')->on('monitors');
            $table->foreign('incident_id')->references('id')->on('incidents');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_mortems');
    }
};
