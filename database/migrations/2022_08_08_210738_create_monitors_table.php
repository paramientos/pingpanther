<?php

use App\Concerns\AuditDB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    use AuditDB;

    public function up(): void
    {
        Schema::create('monitors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('team_id');

            $table->string('name')->nullable();
            $table->text('params')->nullable();
            $table->text('attributes')->nullable();

            $table->string('endpoint');
            $table->unsignedInteger('monitor_type')->comment(\App\Enums\MonitorType::class);

            $table->boolean('status')->default(true);

            $table->string('on_call_methods')->nullable();

            $table->unsignedInteger('escalation_waiting_period')->nullable();
            $table->unsignedInteger('check_frequency_period')->nullable();
            $table->unsignedInteger('domain_expiration_period')->nullable();
            $table->boolean('verify_ssl')->default(false)->nullable();
            $table->unsignedInteger('ssl_expiration_period')->nullable();

            $table->time('maintenance_start_time')->nullable();
            $table->time('maintenance_finish_time')->nullable();
            $table->string('timezone')->nullable();

            $this->addAuditColumns($table);

            $table->boolean('last_status')->nullable();
            $table->string('frequency_type')->nullable();
            $table->unsignedInteger('frequency')->nullable();
            $table->unsignedInteger('alert_count')->nullable()->default(0);
            $table->unsignedInteger('total_alert_count')->nullable()->default(0);
            $table->timestamp('first_alerted_at')->nullable();
            $table->timestamp('last_incident_at')->nullable();
            $table->timestamp('last_resolved_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamp('last_run_at')->nullable();
            $table->timestamp('first_seen_at')->nullable();

            $table->timestamps();

            $table->index(['team_id', 'monitor_type', 'on_call_methods']);

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitors');
    }
};
