<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component {
    use \Livewire\WithPagination;
    use \Mary\Traits\Toast;

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];
    public int $perPage = 10;
    public string $search = '';

    public bool $isEditModalOpen = false;
    public bool $isCreateModalOpen = false;
    public bool $isDeleteModalOpen = false;

    public ActivityLog|Model|null $editingModel = null;
    public ActivityLog|Model|null $modelToDelete = null;

    #[Validate('required')]
    public string $check_id;

    #[Validate('required')]
    public string $monitor_type;

    #[Validate('nullable')]
    public ?string $alert_log_id = null;

    #[Validate('nullable')]
    public ?string $event = null;

    #[Validate('nullable')]
    public ?string $result_text = null;

    #[Validate('nullable')]
    public ?string $created_at = null;

    #[Validate('nullable')]
    public ?string $response_time = null;


    public function openEditModal(string $modelId): void
    {
        $this->editingModel = ActivityLog::findOrFail($modelId);
        $this->fill($this->editingModel->toArray());
        $this->isEditModalOpen = true;
    }

    public function openCreateModal(): void
    {
        $this->reset();
        $this->isCreateModalOpen = true;
    }

    public function openDeleteModal(ActivityLog $model): void
    {
        $this->modelToDelete = $model;
        $this->isDeleteModalOpen = true;
    }

    public function closeModal(): void
    {
        $this->isEditModalOpen = false;
        $this->isCreateModalOpen = false;
        $this->editingModel = null;
    }

    public function deleteModel(): void
    {
        $this->modelToDelete->delete();

        $this->isDeleteModalOpen = false;
    }

    public function saveModel(): void
    {
        $validated = $this->validate();

        if ($this->editingModel) {
            $this->editingModel->update($validated);
            $this->success('Record updated successfully.');
        } else {
            ActivityLog::create($validated);
            $this->success('Record created successfully.');
        }
        $this->closeModal();
    }

    public function headers(): array
    {
        return [
            ['key' => 'check_id', 'label' => 'Kimliği Kontrol Et', 'sortable' => true],
            ['key' => 'monitor_type', 'label' => 'Monitör Tipi', 'sortable' => true],
            ['key' => 'alert_log_id', 'label' => 'Uyarı Günlüğü Kimliği', 'sortable' => true],
            ['key' => 'event', 'label' => 'Etkinlik', 'sortable' => true],
            ['key' => 'result_text', 'label' => 'Sonuç Metni', 'sortable' => true],
            ['key' => 'created_at', 'label' => 'Oluşturulma Tarihi', 'sortable' => true],
            ['key' => 'response_time', 'label' => 'Tepki Süresi', 'sortable' => true],
            ['key' => 'actions', 'label' => 'Actions', 'sortable' => false],
        ];
    }

    public function sort($column): void
    {
        $this->sortBy['direction'] = ($this->sortBy['column'] === $column)
            ? ($this->sortBy['direction'] === 'asc' ? 'desc' : 'asc')
            : 'asc';
        $this->sortBy['column'] = $column;
    }

    public function activityLogs(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return ActivityLog::query()
            ->when($this->search, fn(Builder $q) => $q->mgLike(['id', 'check_id', 'monitor_type', 'alert_log_id', 'event', 'result_text', 'created_at', 'response_time'], $this->search))
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(15);
    }

    public function with(): array
    {
        return [
            'headers' => $this->headers(),
            'activityLogs' => $this->activityLogs(),
        ];
    }
}
?>

<div>
    <x-header title="Etkinlik günlükleri" subtitle="Etkinlik Günlüğü Listesi" separator progress-indicator class="mb-8">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Aramak..." wire:model.live.debounce="search"
                     class="w-64 bg-white/70 backdrop-blur-sm border-violet-200 focus:border-violet-400 focus:ring focus:ring-violet-200 focus:ring-opacity-50"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-plus" wire:click="openCreateModal"
                      class="btn-primary">
                Yeni ActivityLog Ekle
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-table :headers="$headers" :rows="$activityLogs" :sort-by="$sortBy" with-pagination class="w-full table-auto">
        @php
            /** @var ActivityLog $activityLog */
        @endphp
        @scope('cell_actions', $activityLog)
        <div class="flex items-center space-x-2">
            <x-button tooltip="Düzenlemek" icon="o-pencil" wire:click="openEditModal({{ $activityLog->id }})"/>
            <x-button tooltip="Silmek" icon="o-trash" wire:click="openDeleteModal({{ $activityLog->id }})"/>
        </div>
        @endscope
    </x-table>

    @if ($isEditModalOpen)
        <x-modal wire:model="isEditModalOpen">
            <x-card title="Etkinlik günlüğünü güncelle">
                <p class="text-gray-600">
                    Etkinlik günlüğünün ayrıntılarını düzenleyin.
                </p>
                <div class="mt-4 grid gap-3">
                    <x-input wire:model="check_id" required label="Kimliği Kontrol Et"/>
                    <x-input wire:model="monitor_type" required label="Monitör Tipi"/>
                    <x-input wire:model="alert_log_id" label="Uyarı Günlüğü Kimliği"/>
                    <x-input wire:model="event" label="Etkinlik"/>
                    <x-textarea wire:model="result_text" label="Sonuç Metni"/>
                    <x-datepicker wire:model="created_at" label="Oluşturulma Tarihi"/>
                    <x-input wire:model="response_time" icon="o-clock" label="Tepki Süresi"/>

                </div>
                <x-slot name="actions">
                    <div class="flex justify-end gap-x-4">
                        <x-button label="İptal etmek" wire:click="closeModal" icon="o-x-mark"/>
                        <x-button label="Kaydetmek" wire:click="saveModel" spinner class="btn-primary"
                                  icon="o-check-circle"/>
                    </div>
                </x-slot>
            </x-card>
        </x-modal>
    @endif


    @if ($isCreateModalOpen)
        <x-modal wire:model="isCreateModalOpen">
            <x-card title="Yeni ActivityLog Oluştur">
                <p class="text-gray-600">
                    Yeni etkinlik günlüğünün ayrıntılarını girin.
                </p>
                <div class="mt-4 grid gap-3">
                    <x-input wire:model="check_id" required label="Kimliği Kontrol Et"/>
                    <x-input wire:model="monitor_type" required label="Monitör Tipi"/>
                    <x-input wire:model="alert_log_id" label="Uyarı Günlüğü Kimliği"/>
                    <x-input wire:model="event" label="Etkinlik"/>
                    <x-textarea wire:model="result_text" label="Sonuç Metni"/>
                    <x-datepicker wire:model="created_at" label="Oluşturulma Tarihi"/>
                    <x-input wire:model="response_time" icon="o-clock" label="Tepki Süresi"/>

                </div>
                <x-slot name="actions">
                    <div class="flex justify-end gap-x-4">
                        <x-button label="İptal etmek" wire:click="closeModal" icon="o-x-mark"/>
                        <x-button label="Yaratmak" wire:click="saveModel" spinner class="btn-primary"
                                  icon="o-plus-circle"/>
                    </div>
                </x-slot>
            </x-card>
        </x-modal>
    @endif

    @if ($isDeleteModalOpen)
        <x-modal wire:model="isDeleteModalOpen" title="Etkinlik günlüğünü sil">
            <div>Bu kaydı silmek istediğinizden emin misiniz?</div>

            <x-slot:actions>
                <x-button label="HAYIR" @click="$wire.isDeleteModalOpen = false"/>
                <x-button label="Evet" wire:click="deleteModel" class="btn-primary"/>
            </x-slot:actions>
        </x-modal>
    @endif
</div>
