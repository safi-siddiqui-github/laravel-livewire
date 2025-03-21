<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\{computed, layout, rules, state, title};

layout('livewire.layout.auth');
title('Login');

state([
    "emailUsername" => "",
    "password" => "",
    "remember" => true,
    "showPassword" => false,
    "passwordType" => "password",
]);

rules([
    "emailUsername" => ["required", "string"],
    "password" => ["required", "string", "min:5"],
    "remember" => ["boolean"],
]);

$login = function () {
    $this->validate();

    $user = User::orWhere('username', $this->emailUsername)
        ->orWhere('email', $this->emailUsername)
        ->first();

    if (!$user) {
        throw ValidationException::withMessages([
            'emailUsername' => 'Email/Username is not valid.'
        ]);
    }

    $passEmail = false;
    $passUsername = false;

    if (Auth::attempt(
        [
            'email' => $this->emailUsername,
            'password' => $this->password,
            // 'active' => 1
        ],
        $this->remember
    )) {
        $passEmail = true;
    }

    if (Auth::attempt(
        [
            'username' => $this->emailUsername,
            'password' => $this->password,
            // 'active' => 1
        ],
        $this->remember
    )) {
        $passUsername = true;
    }

    if ($passEmail || $passUsername) {
        request()->session()->regenerate();
        return $this->redirectIntended(route('home'));
    }

    throw ValidationException::withMessages([
        'password' => 'Password is incorrect.'
    ]);
};

$togglePassword = function () {
    $this->showPassword = !$this->showPassword;
    $this->passwordType = $this->showPassword ? "text" : "password";
};

?>

<div class="flex flex-col justify-center items-center md:h-screen md:overflow-y-auto md:min-h-[600px]">

    <div class="flex flex-col gap-6 max-w-lg px-4 py-8 w-full">

        <livewire:util.light-dark-mode />

        <div class="flex flex-col items-center gap-2">
            <h2 class="normal-heading">LOGIN</h2>

            <div class="flex flex-wrap gap-1 items-center">
                <p class="normal-text">Create your new account?</p>
                <a href="{{route('auth.register')}}" class="normal-link">Sign Up</a>
            </div>

        </div>

        <livewire:auth.social-login />

        <form wire:submit="login" class="flex flex-col gap-4 w-full">

            <div class="flex flex-col gap-1">
                <label for="emailUsername" class="normal-label">Email/Username</label>
                <input type="text" id="emailUsername" wire:model="emailUsername" class="outlined-input" placeholder="safi@gmail.com/safi.siddiqui" autocomplete="TRUE" />
                @error('emailUsername') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex flex-col gap-1">

                <div class="flex flex-wrap justify-between">
                    <label for="password" class="normal-label">Password</label>
                    <a href="{{route('password.request')}}" class="normal-link">Forgot Password?</a>
                </div>

                <div class="flex gap-2 items-center border dark:border-white p-2 rounded">
                    <input type="{{$passwordType}}" id="password" wire:model="password" class="normal-input w-full" placeholder="**********" />

                    <button class="cursor-pointer" type="button" wire:click="togglePassword">
                        @if(!$showPassword)
                        <livewire:svg.eye-slash class="normal-svg" />
                        @else
                        <livewire:svg.eye class="normal-svg" />
                        @endif
                    </button>
                </div>

                @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex gap-2 items-center">
                <input type="checkbox" id="remember" wire:model="remember" class="normal-checkbox" />
                <label for="remember" class="normal-label">Remember me</label>
            </div>

            <button type="submit" class="filled-btn">Sign In</button>
        </form>

    </div>
</div>