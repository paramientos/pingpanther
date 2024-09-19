<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ssl_certificates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('monitor_id');
            $table->mediumText('domain_name')->nullable();
            $table->string('issuer_name', 255)->nullable();
            $table->mediumText('tls_info')->nullable();
            $table->boolean('is_tls_valid')->nullable();
            $table->boolean('notified')->nullable()->default(false);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_to')->nullable();
            $table->timestamps();

            $table->index([
                'monitor_id', 'domain_name', 'notified',
            ]);

            $table->foreign('monitor_id')->references('id')->on('monitors');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ssl_certificates');
    }
};
