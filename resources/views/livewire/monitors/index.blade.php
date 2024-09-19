<?php

namespace App\Livewire;

use App\Models\Monitor;
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

    public Monitor|Model|null $editingModel = null;
    public Monitor|Model|null $modelToDelete = null;

    #[Validate('required')]
    public string $team_id;

    #[Validate('nullable')]
    public ?string $name = null;

    #[Validate('nullable')]
    public ?string $params = null;

    #[Validate('required')]
    public string $endpoint;

    #[Validate('required')]
    public string $monitor_type;

    #[Validate('required')]
    public bool $status;

    #[Validate('nullable')]
    public ?string $on_call_methods = null;

    #[Validate('nullable')]
    public ?string $escalation_waiting_period = null;

    #[Validate('nullable')]
    public ?string $check_frequency_period = null;

    #[Validate('nullable')]
    public ?string $domain_expiration_period = null;

    #[Validate('nullable')]
    public ?bool $verify_ssl = null;

    #[Validate('nullable')]
    public ?string $ssl_expiration_period = null;

    #[Validate('nullable')]
    public ?string $maintenance_start_time = null;

    #[Validate('nullable')]
    public ?string $maintenance_finish_time = null;

    #[Validate('nullable')]
    public ?string $timezone = null;

    #[Validate('nullable')]
    public ?string $created_by = null;

    #[Validate('nullable')]
    public ?string $updated_by = null;

    #[Validate('nullable')]
    public ?bool $last_status = null;

    #[Validate('nullable')]
    public ?string $frequency_type = null;

    #[Validate('nullable')]
    public ?string $frequency = null;

    #[Validate('nullable')]
    public ?string $alert_count = null;

    #[Validate('nullable')]
    public ?string $total_alert_count = null;

    #[Validate('nullable')]
    public ?string $first_alerted_at = null;

    #[Validate('nullable')]
    public ?string $last_incident_at = null;

    #[Validate('nullable')]
    public ?string $last_resolved_at = null;

    #[Validate('nullable')]
    public ?string $last_seen_at = null;

    #[Validate('nullable')]
    public ?string $last_run_at = null;

    #[Validate('nullable')]
    public ?string $first_seen_at = null;

    #[Validate('nullable')]
    public ?string $created_at = null;

    #[Validate('nullable')]
    public ?string $updated_at = null;

    #[Validate('nullable')]
    public ?string $screenshot_at = null;


    public function openEditModal(string $modelId): void
    {
        $this->editingModel = Monitor::findOrFail($modelId);
        $this->fill($this->editingModel->toArray());
        $this->isEditModalOpen = true;
    }

    public function openCreateModal(): void
    {
        $this->reset();
        $this->isCreateModalOpen = true;
    }

    public function openDeleteModal(Monitor $model): void
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
            Monitor::create($validated);
            $this->success('Record created successfully.');
        }
        $this->closeModal();
    }

    public function headers(): array
    {
        return [
            ['key' => 'team_id', 'label' => 'Takım Kimliği', 'sortable' => true],
            ['key' => 'name', 'label' => 'İsim', 'sortable' => true],
            ['key' => 'params', 'label' => 'Parametreler', 'sortable' => true],
            ['key' => 'attributes', 'label' => 'Nitelikler', 'sortable' => true],
            ['key' => 'endpoint', 'label' => 'Uç nokta', 'sortable' => true],
            ['key' => 'monitor_type', 'label' => 'Monitör Tipi', 'sortable' => true],
            ['key' => 'status', 'label' => 'Durum', 'sortable' => true],
            ['key' => 'on_call_methods', 'label' => 'Çağrı Yöntemleri', 'sortable' => true],
            ['key' => 'escalation_waiting_period', 'label' => 'Eskalasyon Bekleme Süresi', 'sortable' => true],
            ['key' => 'check_frequency_period', 'label' => 'Sıklık Dönemini Kontrol Edin', 'sortable' => true],
            ['key' => 'domain_expiration_period', 'label' => 'Alan Adı Sona Erme Süresi', 'sortable' => true],
            ['key' => 'verify_ssl', 'label' => 'SSL\'yi doğrulayın', 'sortable' => true],
            ['key' => 'ssl_expiration_period', 'label' => 'SSL Sona Erme Süresi', 'sortable' => true],
            ['key' => 'maintenance_start_time', 'label' => 'Bakım Başlangıç ​​Zamanı', 'sortable' => true],
            ['key' => 'maintenance_finish_time', 'label' => 'Bakım Bitiş Zamanı', 'sortable' => true],
            ['key' => 'timezone', 'label' => 'Saat dilimi', 'sortable' => true],
            ['key' => 'created_by', 'label' => 'Oluşturan', 'sortable' => true],
            ['key' => 'updated_by', 'label' => 'Güncelleyen', 'sortable' => true],
            ['key' => 'last_status', 'label' => 'Son Durum', 'sortable' => true],
            ['key' => 'frequency_type', 'label' => 'Frekans Tipi', 'sortable' => true],
            ['key' => 'frequency', 'label' => 'Sıklık', 'sortable' => true],
            ['key' => 'alert_count', 'label' => 'Uyarı Sayısı', 'sortable' => true],
            ['key' => 'total_alert_count', 'label' => 'Toplam Uyarı Sayısı', 'sortable' => true],
            ['key' => 'first_alerted_at', 'label' => 'İlk Uyarı Tarihi:', 'sortable' => true],
            ['key' => 'last_incident_at', 'label' => 'Son Olay', 'sortable' => true],
            ['key' => 'last_resolved_at', 'label' => 'Son Çözümlenme Tarihi:', 'sortable' => true],
            ['key' => 'last_seen_at', 'label' => 'Son Görülme Tarihi', 'sortable' => true],
            ['key' => 'last_run_at', 'label' => 'Son Çalıştırma Tarihi', 'sortable' => true],
            ['key' => 'first_seen_at', 'label' => 'İlk Görüldüğü Yer', 'sortable' => true],
            ['key' => 'created_at', 'label' => 'Oluşturulma Tarihi', 'sortable' => true],
            ['key' => 'updated_at', 'label' => 'Güncelleme Tarihi:', 'sortable' => true],
            ['key' => 'screenshot_at', 'label' => 'Ekran Görüntüsü Tarihi', 'sortable' => true],
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

    public function monitors(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Monitor::query()
            ->when($this->search, fn(Builder $q) => $q->mgLike(['id', 'team_id', 'name', 'params', 'attributes', 'endpoint', 'monitor_type', 'status', 'on_call_methods', 'escalation_waiting_period', 'check_frequency_period', 'domain_expiration_period', 'verify_ssl', 'ssl_expiration_period', 'maintenance_start_time', 'maintenance_finish_time', 'timezone', 'created_by', 'updated_by', 'last_status', 'frequency_type', 'frequency', 'alert_count', 'total_alert_count', 'first_alerted_at', 'last_incident_at', 'last_resolved_at', 'last_seen_at', 'last_run_at', 'first_seen_at', 'created_at', 'updated_at', 'screenshot_at'], $this->search))
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(15);
    }

    public function with(): array
    {
        return [
            'headers' => $this->headers(),
            'monitors' => $this->monitors(),
        ];
    }
}
?>

<div>
    <x-header title="Monitörler" subtitle="İzleme Listesi" separator progress-indicator class="mb-8">
        <x-slot:middle class="!justify-end">
            <x-input icon="o-magnifying-glass" placeholder="Aramak..." wire:model.live.debounce="search"
                     class="w-64 bg-white/70 backdrop-blur-sm border-violet-200 focus:border-violet-400 focus:ring focus:ring-violet-200 focus:ring-opacity-50"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-button icon="o-plus" wire:click="openCreateModal"
                      class="btn-primary">
                Yeni Monitör Ekle
            </x-button>
        </x-slot:actions>
    </x-header>

    <x-table :headers="$headers" :rows="$monitors" :sort-by="$sortBy" with-pagination class="w-full table-auto">
        @php
            /** @var Monitor $monitor */
        @endphp
        @scope('cell_actions', $monitor)
        <div class="flex items-center space-x-2">
            <x-button tooltip="Düzenlemek" icon="o-pencil" wire:click="openEditModal('{{ $monitor->id }}')"/>
            <x-button tooltip="Silmek" icon="o-trash" wire:click="openDeleteModal('{{ $monitor->id }}')"/>
        </div>
        @endscope
    </x-table>

    @if ($isEditModalOpen)
        <x-modal wire:model="isEditModalOpen">
            <x-card title="Monitörü güncelle">
                <p class="text-gray-600">
                    Monitörün ayrıntılarını düzenleyin.
                </p>
                <div class="mt-4 grid gap-3">
                    <x-input wire:model="team_id" required label="Takım Kimliği"/>
                    <x-input wire:model="name" label="İsim"/>
                    <x-textarea wire:model="params" label="Parametreler"/>
                    <x-textarea wire:model="attributes" label="Nitelikler"/>
                    <x-input wire:model="endpoint" required label="Uç nokta"/>
                    <x-input wire:model="monitor_type" required label="Monitör Tipi"/>
                    <x-checkbox wire:model="status" icon="o-check-circle" required label="Durum"/>
                    <x-input wire:model="on_call_methods" label="Çağrı Yöntemleri"/>
                    <x-input wire:model="escalation_waiting_period" label="Eskalasyon Bekleme Süresi"/>
                    <x-input wire:model="check_frequency_period" label="Sıklık Dönemini Kontrol Edin"/>
                    <x-input wire:model="domain_expiration_period" label="Alan Adı Sona Erme Süresi"/>
                    <x-checkbox wire:model="verify_ssl" label="SSL'yi doğrulayın"/>
                    <x-input wire:model="ssl_expiration_period" label="SSL Sona Erme Süresi"/>
                    <x-datepicker wire:model="maintenance_start_time" icon="o-clock" label="Bakım Başlangıç ​​Zamanı"/>
                    <x-datepicker wire:model="maintenance_finish_time" icon="o-clock" label="Bakım Bitiş Zamanı"/>
                    <x-input wire:model="timezone" icon="o-clock" label="Saat dilimi"/>
                    <x-input wire:model="created_by" label="Oluşturan"/>
                    <x-input wire:model="updated_by" label="Güncelleyen"/>
                    <x-checkbox wire:model="last_status" icon="o-check-circle" label="Son Durum"/>
                    <x-input wire:model="frequency_type" label="Frekans Tipi"/>
                    <x-input wire:model="frequency" label="Sıklık"/>
                    <x-input wire:model="alert_count" label="Uyarı Sayısı"/>
                    <x-input wire:model="total_alert_count" label="Toplam Uyarı Sayısı"/>
                    <x-datepicker wire:model="first_alerted_at" label="İlk Uyarı Tarihi:"/>
                    <x-datepicker wire:model="last_incident_at" label="Son Olay"/>
                    <x-datepicker wire:model="last_resolved_at" label="Son Çözümlenme Tarihi:"/>
                    <x-datepicker wire:model="last_seen_at" label="Son Görülme Tarihi"/>
                    <x-datepicker wire:model="last_run_at" label="Son Çalıştırma Tarihi"/>
                    <x-datepicker wire:model="first_seen_at" label="İlk Görüldüğü Yer"/>
                    <x-datepicker wire:model="created_at" label="Oluşturulma Tarihi"/>
                    <x-datepicker wire:model="updated_at" label="Güncelleme Tarihi:"/>
                    <x-datepicker wire:model="screenshot_at" label="Ekran Görüntüsü Tarihi"/>

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
            <x-card title="Yeni Monitör Oluştur">
                <p class="text-gray-600">
                    Yeni monitörün ayrıntılarını girin.
                </p>
                <div class="mt-4 grid gap-3">
                    <x-input wire:model="team_id" required label="Takım Kimliği"/>
                    <x-input wire:model="name" label="İsim"/>
                    <x-textarea wire:model="params" label="Parametreler"/>
                    <x-textarea wire:model="attributes" label="Nitelikler"/>
                    <x-input wire:model="endpoint" required label="Uç nokta"/>
                    <x-input wire:model="monitor_type" required label="Monitör Tipi"/>
                    <x-checkbox wire:model="status" icon="o-check-circle" required label="Durum"/>
                    <x-input wire:model="on_call_methods" label="Çağrı Yöntemleri"/>
                    <x-input wire:model="escalation_waiting_period" label="Eskalasyon Bekleme Süresi"/>
                    <x-input wire:model="check_frequency_period" label="Sıklık Dönemini Kontrol Edin"/>
                    <x-input wire:model="domain_expiration_period" label="Alan Adı Sona Erme Süresi"/>
                    <x-checkbox wire:model="verify_ssl" label="SSL'yi doğrulayın"/>
                    <x-input wire:model="ssl_expiration_period" label="SSL Sona Erme Süresi"/>
                    <x-datepicker wire:model="maintenance_start_time" icon="o-clock" label="Bakım Başlangıç ​​Zamanı"/>
                    <x-datepicker wire:model="maintenance_finish_time" icon="o-clock" label="Bakım Bitiş Zamanı"/>
                    <x-input wire:model="timezone" icon="o-clock" label="Saat dilimi"/>
                    <x-input wire:model="created_by" label="Oluşturan"/>
                    <x-input wire:model="updated_by" label="Güncelleyen"/>
                    <x-checkbox wire:model="last_status" icon="o-check-circle" label="Son Durum"/>
                    <x-input wire:model="frequency_type" label="Frekans Tipi"/>
                    <x-input wire:model="frequency" label="Sıklık"/>
                    <x-input wire:model="alert_count" label="Uyarı Sayısı"/>
                    <x-input wire:model="total_alert_count" label="Toplam Uyarı Sayısı"/>
                    <x-datepicker wire:model="first_alerted_at" label="İlk Uyarı Tarihi:"/>
                    <x-datepicker wire:model="last_incident_at" label="Son Olay"/>
                    <x-datepicker wire:model="last_resolved_at" label="Son Çözümlenme Tarihi:"/>
                    <x-datepicker wire:model="last_seen_at" label="Son Görülme Tarihi"/>
                    <x-datepicker wire:model="last_run_at" label="Son Çalıştırma Tarihi"/>
                    <x-datepicker wire:model="first_seen_at" label="İlk Görüldüğü Yer"/>
                    <x-datepicker wire:model="created_at" label="Oluşturulma Tarihi"/>
                    <x-datepicker wire:model="updated_at" label="Güncelleme Tarihi:"/>
                    <x-datepicker wire:model="screenshot_at" label="Ekran Görüntüsü Tarihi"/>

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
        <x-modal wire:model="isDeleteModalOpen" title="Monitörü sil">
            <div>Bu kaydı silmek istediğinizden emin misiniz?</div>

            <x-slot:actions>
                <x-button label="HAYIR" @click="$wire.isDeleteModalOpen = false"/>
                <x-button label="Evet" wire:click="deleteModel" class="btn-primary"/>
            </x-slot:actions>
        </x-modal>
    @endif
</div>
