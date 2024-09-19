<?php

namespace App\Livewire;

use Livewire\Volt\Component;
use App\Models\PostMortem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Validate;

new class extends Component
{
    use \Livewire\WithPagination;
    use \Mary\Traits\Toast;

    public array $sortBy = ['column' => 'created_at', 'direction' => 'desc'];
    public int $perPage = 10;
    public string $search = '';

    public bool $isEditModalOpen = false;
    public bool $isCreateModalOpen = false;
    public bool $isDeleteModalOpen = false;

    public PostMortem|Model|null $editingModel = null;
    public PostMortem|Model|null $modelToDelete = null;

    #[Validate('required')]
public string $monitor_id;

#[Validate('nullable')]
public ?string $incident_id= null;

#[Validate('required')]
public string $notes;

#[Validate('required')]
public bool $is_resolved;

#[Validate('required')]
public string $created_by;

#[Validate('nullable')]
public ?string $created_at= null;



    public function openEditModal(string $modelId): void
    {
        $this->editingModel = PostMortem::findOrFail($modelId);
        $this->fill($this->editingModel->toArray());
        $this->isEditModalOpen = true;
    }

    public function openCreateModal(): void
    {
        $this->reset();
        $this->isCreateModalOpen = true;
    }

    public function openDeleteModal(PostMortem $model): void
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
            PostMortem::create($validated);
            $this->success('Record created successfully.');
        }
        $this->closeModal();
    }

    public function headers(): array
    {
        return [
['key' => 'monitor_id', 'label' => 'Monitör Kimliği', 'sortable' => true],
['key' => 'incident_id', 'label' => 'Olay Kimliği', 'sortable' => true],
['key' => 'notes', 'label' => 'Notlar', 'sortable' => true],
['key' => 'is_resolved', 'label' => 'Çözüldü', 'sortable' => true],
['key' => 'created_by', 'label' => 'Oluşturan', 'sortable' => true],
['key' => 'created_at', 'label' => 'Oluşturulma Tarihi', 'sortable' => true],
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

    public function postMortems(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return PostMortem::query()
             ->when($this->search, fn(Builder $q) => $q->mgLike(['id','monitor_id','incident_id','notes','is_resolved','created_by','created_at'], $this->search))
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(15);
    }

    public function with(): array
    {
        return [
            'headers' => $this->headers(),
            'postMortems' => $this->postMortems(),
        ];
    }
}
?>

<div>
    <x-header title="Ölüm sonrası" subtitle="Ölüm Sonrası Listesi" separator progress-indicator class="mb-8">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Aramak..." wire:model.live.debounce="search"
                     class="w-64 bg-white/70 backdrop-blur-sm border-violet-200 focus:border-violet-400 focus:ring focus:ring-violet-200 focus:ring-opacity-50"/>
        </x-slot:middle>
        <x-slot:actions>
          <x-button icon="o-plus" wire:click="openCreateModal"
                      class="btn-primary">
                Yeni PostMortem Ekle
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-table :headers="$headers" :rows="$postMortems" :sort-by="$sortBy" with-pagination class="w-full table-auto">
        @php
            /** @var PostMortem $postMortem */
        @endphp
        @scope('cell_actions', $postMortem)
        <div class="flex items-center space-x-2">
            <x-button tooltip="Düzenlemek" icon="o-pencil" wire:click="openEditModal('{{ $postMortem->id }}')"/>
            <x-button tooltip="Silmek" icon="o-trash" wire:click="openDeleteModal('{{ $postMortem->id }}')"/>
        </div>
        @endscope
    </x-table>

     @if ($isEditModalOpen)
         <x-modal wire:model="isEditModalOpen">
            <x-card title="Ölüm sonrası güncelleme">
                <p class="text-gray-600">
                    Ölüm sonrası ayrıntıları düzenleyin.
                </p>
                <div class="mt-4 grid gap-3">
                    <x-input  wire:model="monitor_id"  required label="Monitör Kimliği" />
<x-input  wire:model="incident_id"   label="Olay Kimliği" />
<x-textarea  wire:model="notes"  required label="Notlar" />
<x-checkbox  wire:model="is_resolved"  required label="Çözüldü" />
<x-input  wire:model="created_by"  required label="Oluşturan" />
<x-datepicker  wire:model="created_at"   label="Oluşturulma Tarihi" />

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
            <x-card title="Yeni PostMortem Oluştur">
                <p class="text-gray-600">
                    Yeni otopsi için ayrıntıları girin.
                </p>
                <div class="mt-4 grid gap-3">
                    <x-input  wire:model="monitor_id"  required label="Monitör Kimliği" />
<x-input  wire:model="incident_id"   label="Olay Kimliği" />
<x-textarea  wire:model="notes"  required label="Notlar" />
<x-checkbox  wire:model="is_resolved"  required label="Çözüldü" />
<x-input  wire:model="created_by"  required label="Oluşturan" />
<x-datepicker  wire:model="created_at"   label="Oluşturulma Tarihi" />

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
         <x-modal wire:model="isDeleteModalOpen" title="Otopsiyi sil">
            <div>Bu kaydı silmek istediğinizden emin misiniz?</div>

            <x-slot:actions>
                <x-button label="HAYIR" @click="$wire.isDeleteModalOpen = false"/>
                <x-button label="Evet" wire:click="deleteModel" class="btn-primary"/>
            </x-slot:actions>
        </x-modal>
    @endif
</div>