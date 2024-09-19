<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
#[Layout('components.layouts.empty')]
#[Title('Login')]
class extends Component {

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';

    public string $errorMessage = '';

    public bool $showError = false;

    public function mount()
    {
        if (auth()->user()) {
            return redirect('/');
        }
    }

    public function login()
    {
        $credentials = $this->validate();

        if (auth('web')->attempt($credentials)) {
            request()->session()->regenerate();

            return redirect()->intended('/');
        }

        $this->errorMessage = 'Hatalı e-posta veya parola!';
        $this->showError = true;
    }
};
?>

<div class="flex w-full h-screen">


    <!-- left side with login form -->
    <div class="flex items-center justify-center w-full md:w-1/2 lg:w-1/3 bg-white p-8 rounded-lg shadow-lg">
        <div class="w-full max-w-md mx-auto">
            <div class="mb-6 text-center">
                <img src="{{ asset('/assets/images/logo.png') }}" alt="Logo" class="mx-auto mb-4" style="width: 200px;">
                <h1 class="text-2xl font-bold">Güvenli Giriş</h1>
            </div>

            <x-form wire:submit.prevent="login">
                <x-alert x-show="$wire.showError" class="alert-warning" :title="$errorMessage" icon="o-exclamation-triangle" class="mb-4 p-3 bg-red-200 text-red-700 rounded"/>

                <div class="mb-4">
                    <x-input placeholder="E-Posta" wire:model="email" icon="o-envelope" inline class="w-full px-3 py-2 border rounded" />
                </div>
                <div class="mb-4">
                    <x-input placeholder="Parola" wire:model="password" type="password" icon="o-key" inline class="w-full px-3 py-2 border rounded" />
                </div>

                <div class="flex items-center justify-between mb-4">
                    <x-button label="Giriş Yap" type="submit" icon="o-paper-airplane" class="btn-primary px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700" spinner="login"/>
                </div>
            </x-form>
        </div>
    </div>

    <!-- right side with image -->
    <div class="hidden md:flex md:w-1/2 lg:w-2/3 items-center justify-center">
        <img src="{{ asset('/assets/images/login-bg.jpg') }}" alt="Placeholder Image" class="object-cover h-full w-full">
    </div>
</div>
