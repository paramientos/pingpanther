<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('domains', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('monitor_id');
            $table->mediumText('domain_name');

            $table->boolean('notified')->nullable()->default(false);

            $table->mediumText('whois_server');
            $table->mediumText('name_servers')->nullable();
            $table->mediumText('owner')->nullable();
            $table->mediumText('registrar')->nullable();
            $table->mediumText('dnssec')->nullable();

            $table->dateTime('creation_date');
            $table->dateTime('expiration_date');
            $table->dateTime('updated_date')->nullable();

            $table->timestamps();

            $table->index([
                'monitor_id', 'domain_name',
            ]);

            $table->foreign('monitor_id')->references('id')->on('monitors');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
