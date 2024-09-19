<?php

namespace App\Concerns;

use Illuminate\Database\Schema\Blueprint;

trait AuditDB
{
    public function addAuditColumns(Blueprint $table): void
    {
        $table->uuid('created_by')->nullable();
        $table->uuid('updated_by')->nullable();
    }
}
