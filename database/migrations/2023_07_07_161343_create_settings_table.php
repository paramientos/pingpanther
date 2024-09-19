<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->nullable();
            $table->string('type')->default('text')->nullable();
            $table->string('label')->nullable();
            $table->string('help_text')->nullable();
            $table->text('possible_values')->nullable();

            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index(['id', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
