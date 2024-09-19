<?php

namespace App\Concerns;

use JetBrains\PhpStorm\Pure;

trait MetricsStatColors
{
    #[Pure]
    public function ramColorWhen(float $value): string
    {
        return $this->ramUsagePercentage() > $value ? 'red' : '#87CEEB';
    }

    #[Pure]
    public function diskColorWhen(float $value): string
    {
        return $this->total_disk_used_percentage > $value ? 'red' : '#87CEEB';
    }
}
