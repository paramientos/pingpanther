<?php

namespace App\Livewire;

use App\Models\AlertLog;
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

    public AlertLog|Model|null $editingModel = null;
    public AlertLog|Model|null $modelToDelete = null;

    #[Validate('required')]
    public string $check_id;

    #[Validate('nullable')]
    public ?string $params = null;

    #[Validate('required')]
    public string $event;

    #[Validate('required')]
    public bool $is_initial;

    #[Validate('nullable')]
    public ?string $result = null;

    #[Validate('nullable')]
    public ?string $notified_to = null;

    #[Validate('nullable')]
    public ?string $notified_with = null;

    #[Validate('nullable')]
    public ?string $alert_message = null;

    #[Validate('required')]
    public string $created_at;

    #[Validate('nullable')]
    public ?string $updated_at = null;


    public function openEditModal(string $modelId): void
    {
        $this->editingModel = AlertLog::findOrFail($modelId);
        $this->fill($this->editingModel->toArray());
        $this->isEditModalOpen = true;
    }

    public function openCreateModal(): void
    {
        $this->reset();
        $this->isCreateModalOpen = true;
    }

    public function openDeleteModal(AlertLog $model): void
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
            AlertLog::create($validated);
            $this->success('Record created successfully.');
        }
        $this->closeModal();
    }

    public function headers(): array
    {
        return [
            ['key' => 'check_id', 'label' => 'Kimliği Kontrol Et', 'sortable' => true],
            ['key' => 'params', 'label' => 'Parametreler', 'sortable' => true],
            ['key' => 'event', 'label' => 'Etkinlik', 'sortable' => true],
            ['key' => 'is_initial', 'label' => 'Başlangıç ​​mı', 'sortable' => true],
            ['key' => 'result', 'label' => 'Sonuç', 'sortable' => true],
            ['key' => 'notified_to', 'label' => 'Bildirilen Kişi', 'sortable' => true],
            ['key' => 'notified_with', 'label' => 'Şununla bilgilendirildi:', 'sortable' => true],
            ['key' => 'alert_message', 'label' => 'Uyarı Mesajı', 'sortable' => true],
            ['key' => 'created_at', 'label' => 'Oluşturulma Tarihi', 'sortable' => true],
            ['key' => 'updated_at', 'label' => 'Güncelleme Tarihi:', 'sortable' => true],
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

    public function alertLogs(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return AlertLog::query()
            ->when($this->search, fn(Builder $q) => $q->mgLike(['id', 'check_id', 'params', 'event', 'is_initial', 'result', 'notified_to', 'notified_with', 'alert_message', 'created_at', 'updated_at'], $this->search))
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(15);
    }

    public function with(): array
    {
        return [
            'headers' => $this->headers(),
            'alertLogs' => $this->alertLogs(),
        ];
    }
}
?>

<div>
    <x-header title="Uyarı günlükleri" subtitle="Uyarı Günlüğü Listesi" separator progress-indicator class="mb-8">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Aramak..." wire:model.live.debounce="search"
                     class="w-64 bg-white/70 backdrop-blur-sm border-violet-200 focus:border-violet-400 focus:ring focus:ring-violet-200 focus:ring-opacity-50"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-plus" wire:click="openCreateModal"
                      class="btn-primary">
                Yeni AlertLog Ekle
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-table :headers="$headers" :rows="$alertLogs" :sort-by="$sortBy" with-pagination class="w-full table-auto">
        @php
            /** @var AlertLog $alertLog */
        @endphp
        @scope('cell_actions', $alertLog)
        <div class="flex items-center space-x-2">
            <x-button tooltip="Düzenlemek" icon="o-pencil" wire:click="openEditModal('{{ $alertLog->id }}')"/>
            <x-button tooltip="Silmek" icon="o-trash" wire:click="openDeleteModal('{{ $alertLog->id }}')"/>
        </div>
        @endscope
    </x-table>

    @if ($isEditModalOpen)
        <x-modal wire:model="isEditModalOpen">
            <x-card title="Uyarı günlüğünü güncelle">
                <p class="text-gray-600">
                    Uyarı günlüğünün ayrıntılarını düzenleyin.
                </p>
                <div class="mt-4 grid gap-3">
                    <x-input wire:model="check_id" required label="Kimliği Kontrol Et"/>
                    <x-textarea wire:model="params" label="Parametreler"/>
                    <x-input wire:model="event" required label="Etkinlik"/>
                    <x-checkbox wire:model="is_initial" required label="Başlangıç ​​mı"/>
                    <x-textarea wire:model="result" label="Sonuç"/>
                    <x-input wire:model="notified_to" label="Bildirilen Kişi"/>
                    <x-input wire:model="notified_with" label="Şununla bilgilendirildi:"/>
                    <x-textarea wire:model="alert_message" label="Uyarı Mesajı"/>
                    <x-datepicker wire:model="created_at" required label="Oluşturulma Tarihi"/>
                    <x-datepicker wire:model="updated_at" label="Güncelleme Tarihi:"/>

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
            <x-card title="Yeni AlertLog Oluştur">
                <p class="text-gray-600">
                    Yeni uyarı günlüğünün ayrıntılarını girin.
                </p>
                <div class="mt-4 grid gap-3">
                    <x-input wire:model="check_id" required label="Kimliği Kontrol Et"/>
                    <x-textarea wire:model="params" label="Parametreler"/>
                    <x-input wire:model="event" required label="Etkinlik"/>
                    <x-checkbox wire:model="is_initial" required label="Başlangıç ​​mı"/>
                    <x-textarea wire:model="result" label="Sonuç"/>
                    <x-input wire:model="notified_to" label="Bildirilen Kişi"/>
                    <x-input wire:model="notified_with" label="Şununla bilgilendirildi:"/>
                    <x-textarea wire:model="alert_message" label="Uyarı Mesajı"/>
                    <x-datepicker wire:model="created_at" required label="Oluşturulma Tarihi"/>
                    <x-datepicker wire:model="updated_at" label="Güncelleme Tarihi:"/>

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
        <x-modal wire:model="isDeleteModalOpen" title="Uyarı günlüğünü sil">
            <div>Bu kaydı silmek istediğinizden emin misiniz?</div>

            <x-slot:actions>
                <x-button label="HAYIR" @click="$wire.isDeleteModalOpen = false"/>
                <x-button label="Evet" wire:click="deleteModel" class="btn-primary"/>
            </x-slot:actions>
        </x-modal>
    @endif
</div>
