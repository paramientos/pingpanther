<?php

namespace App\Livewire\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Alert extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public ?string $description = null,
        public ?bool $shadow = false,

        // Slots
        public mixed $actions = null
    ) {
        $this->uuid = "mary" . md5(serialize($this));
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
                <div wire:key="{{ $uuid }}"class='alert rounded-md'>
                    @if($icon)
                        <x-mary-icon :name="$icon" />
                    @endif

                    @if($title)
                        <div>
                            <div class="font-bold">{!! $title !!}</div>
                            <div class="text-xs">{!! $description !!}</div>
                        </div>
                    @else
                        <span>{{ $slot }}</span>
                    @endif

                    <div class="flex items-center gap-3">
                        {{ $actions }}
                    </div>
                </div>
            HTML;
    }
}
