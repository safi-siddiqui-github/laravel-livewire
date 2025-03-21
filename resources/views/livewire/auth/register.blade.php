<?php

use App\Models\User;
use function Livewire\Volt\{layout, rules, state, title};

layout('livewire.layout.auth');
title('Register');

state([
    "username" => "",
    "email" => "",
    "password" => "",
    "remember" => true,
    "showPassword" => false,
    "passwordType" => "password",
]);

rules([
    "username" => ["required", "string", "unique:users,username", "max:100"],
    "email" => ["required", "string", "email", "unique:users,email", "max:100"],
    "password" => ["required", "string", "min:5", "max:100"],
    "remember" => ["boolean"],
]);

$register = function () {
    $this->validate();

    $user = new User();
    $user->username = $this->username;
    $user->email = $this->email;
    $user->password = $this->password;
    $user->save();

    $this->redirectRoute('auth.login');

};

$togglePassword = function () {
    $this->showPassword = !$this->showPassword;
    $this->passwordType = $this->showPassword ? "text" : "password";
};

?>

<div class="flex flex-col justify-center md:items-center md:h-screen md:overflow-y-auto md:min-h-[700px]">

    <div class="flex flex-col gap-6 max-w-lg px-4 py-8">

        <livewire:util.light-dark-mode />

        <div class="flex flex-col items-center gap-2">
            <h2 class="normal-heading">REGISTER</h2>

            <div class="flex flex-wrap gap-1 items-center">
                <p class="normal-text">Already have an account?</p>
                <a href="{{route('auth.login')}}" class="normal-link">Sign In</a>
            </div>

        </div>

        <livewire:auth.social-login />

        <form wire:submit="register" class="flex flex-col gap-4 w-full">

            <div class="flex flex-col gap-1">
                <label for="email" class="normal-label">Email</label>
                <input type="text" id="email" wire:model="email" class="outlined-input" placeholder="safi@gmail.com" autocomplete="TRUE" />
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex flex-col gap-1">
                <label for="username" class="normal-label">Username</label>
                <input type="text" id="username" wire:model="username" class="outlined-input" placeholder="safi.siddiqui" autocomplete="TRUE" />
                @error('username') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex flex-col gap-1">

                <label for="password" class="normal-label">Password</label>

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

            <button type="submit" class="filled-btn">Sign Up</button>
        </form>

    </div>

</div>