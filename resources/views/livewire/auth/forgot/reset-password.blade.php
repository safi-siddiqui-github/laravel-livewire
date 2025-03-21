<?php

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

use function Livewire\Volt\{layout, rules, state, title};

layout('livewire.layout.auth');
title('Reset Password');
state([
    'token' => '',
    'password' => '',
    "showPassword" => false,
    "passwordType" => "password",
]);

state(['email'])->url()->locked();

rules([
    'email' => ['required', 'string', 'email', 'exists:users,email'],
    "password" => ["required", "string", "min:5"],
]);

$password_reset = function () {
    $this->validate();

    $status = Password::reset(
        [
            'token' => $this->token,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ],
        // $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );
    
    if ($status === Password::PasswordReset) {
        return $this->redirectRoute('auth.login');
    }
    
    return $this->redirectRoute('password.request');
};


?>

<div class="flex flex-col justify-center items-center h-screen overflow-y-auto min-h-[500px]">

    <div class="flex flex-col gap-6 max-w-lg px-4 py-8 w-full">

        <livewire:util.light-dark-mode />

        <div class="flex flex-col items-center gap-2">
            <h2 class="normal-heading">PASSWORD RESET</h2>
            <p class="normal-text">Password Reset Form</p>
        </div>

        <form wire:submit="password_reset" class="flex flex-col gap-4 w-full">

            <div class="flex flex-col gap-1">
                <label for="email" class="normal-label">Email</label>
                <input type="text" id="email" wire:model="email" class="outlined-input bg-slate-100" value="{{$this->email}}" autocomplete="TRUE" readonly />
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
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

            <button type="submit" class="filled-btn">Change Password</button>
        </form>

    </div>
</div>