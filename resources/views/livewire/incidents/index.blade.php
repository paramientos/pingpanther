<?php

namespace App\Livewire;

use Livewire\Volt\Component;
use App\Models\Incident;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Validate;

new class extends Component
{
    use \Livewire\WithPagination;
    use \Mary\Traits\Toast;

    public array $sortBy = ['column' => 'id', 'direction' => 'desc'];
    public int $perPage = 10;
    public string $search = '';

    public bool $isEditModalOpen = false;
    public bool $isCreateModalOpen = false;
    public bool $isDeleteModalOpen = false;

    public Incident|Model|null $editingModel = null;
    public Incident|Model|null $modelToDelete = null;

    #[Validate('required')]
public string $check_id;

#[Validate('required')]
public string $event;

#[Validate('required')]
public string $occurred_at;

#[Validate('nullable')]
public ?string $resolved_at= null;



    public function openEditModal(string $modelId): void
    {
        $this->editingModel = Incident::findOrFail($modelId);
        $this->fill($this->editingModel->toArray());
        $this->isEditModalOpen = true;
    }

    public function openCreateModal(): void
    {
        $this->reset();
        $this->isCreateModalOpen = true;
    }

    public function openDeleteModal(Incident $model): void
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
            Incident::create($validated);
            $this->success('Record created successfully.');
        }
        $this->closeModal();
    }

    public function headers(): array
    {
        return [
['key' => 'check_id', 'label' => 'Kimliği Kontrol Et', 'sortable' => true],
['key' => 'event', 'label' => 'Etkinlik', 'sortable' => true],
['key' => 'occurred_at', 'label' => 'Meydana Gelme Tarihi', 'sortable' => true],
['key' => 'resolved_at', 'label' => 'Çözümlenme Tarihi:', 'sortable' => true],
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

    public function incidents(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Incident::query()
             ->when($this->search, fn(Builder $q) => $q->mgLike(['id','check_id','event','occurred_at','resolved_at'], $this->search))
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(15);
    }

    public function with(): array
    {
        return [
            'headers' => $this->headers(),
            'incidents' => $this->incidents(),
        ];
    }
}
?>

<div>
    <x-header title="Olaylar" subtitle="Olay Listesi" separator progress-indicator class="mb-8">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Aramak..." wire:model.live.debounce="search"
                     class="w-64 bg-white/70 backdrop-blur-sm border-violet-200 focus:border-violet-400 focus:ring focus:ring-violet-200 focus:ring-opacity-50"/>
        </x-slot:middle>
        <x-slot:actions>
          <x-button icon="o-plus" wire:click="openCreateModal"
                      class="btn-primary">
                Yeni Olay Ekle
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-table :headers="$headers" :rows="$incidents" :sort-by="$sortBy" with-pagination class="w-full table-auto">
        @php
            /** @var Incident $incident */
        @endphp
        @scope('cell_actions', $incident)
        <div class="flex items-center space-x-2">
            <x-button tooltip="Düzenlemek" icon="o-pencil" wire:click="openEditModal('{{ $incident->id }}')"/>
            <x-button tooltip="Silmek" icon="o-trash" wire:click="openDeleteModal('{{ $incident->id }}')"/>
        </div>
        @endscope
    </x-table>

     @if ($isEditModalOpen)
         <x-modal wire:model="isEditModalOpen">
            <x-card title="Olayı güncelle">
                <p class="text-gray-600">
                    Olayın ayrıntılarını düzenleyin.
                </p>
                <div class="mt-4 grid gap-3">
                    <x-input  wire:model="check_id"  required label="Kimliği Kontrol Et" />
<x-input  wire:model="event"  required label="Etkinlik" />
<x-datepicker  wire:model="occurred_at"  required label="Meydana Gelme Tarihi" />
<x-datepicker  wire:model="resolved_at"   label="Çözümlenme Tarihi:" />

                </div>
                <x-slot name="actions">
                    <div class="flex justify-end gap-x-4">
                        <x-button label="İptal etmek" wire:click="closeModal" icon="o-x-mark" />
                        <x-button label="Kaydetmek" wire:click="saveModel" spinner class="btn-primary" icon="o-check-circle"/>
                    </div>
                </x-slot>
            </x-card>
        </x-modal>
    @endif


    @if ($isCreateModalOpen)
        <x-modal wire:model="isCreateModalOpen">
            <x-card title="Yeni Olay Yarat">
                <p class="text-gray-600">
                    Yeni olayın ayrıntılarını girin.
                </p>
                <div class="mt-4 grid gap-3">
                    <x-input  wire:model="check_id"  required label="Kimliği Kontrol Et" />
<x-input  wire:model="event"  required label="Etkinlik" />
<x-datepicker  wire:model="occurred_at"  required label="Meydana Gelme Tarihi" />
<x-datepicker  wire:model="resolved_at"   label="Çözümlenme Tarihi:" />

                </div>
                <x-slot name="actions">
                    <div class="flex justify-end gap-x-4">
                        <x-button label="İptal etmek" wire:click="closeModal" icon="o-x-mark" />
                        <x-button label="Yaratmak" wire:click="saveModel" spinner class="btn-primary" icon="o-plus-circle"/>
                    </div>
                </x-slot>
            </x-card>
        </x-modal>
    @endif

    @if ($isDeleteModalOpen)
         <x-modal wire:model="isDeleteModalOpen" title="Olayı sil">
            <div>Bu kaydı silmek istediğinizden emin misiniz?</div>

            <x-slot:actions>
                <x-button label="HAYIR" @click="$wire.isDeleteModalOpen = false"/>
                <x-button label="Evet" wire:click="deleteModel" class="btn-primary"/>
            </x-slot:actions>
        </x-modal>
    @endif
</div>