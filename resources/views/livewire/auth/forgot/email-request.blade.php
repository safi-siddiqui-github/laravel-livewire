<?php

use Illuminate\Support\Facades\Password;

use function Livewire\Volt\{layout, rules, state, title};

layout('livewire.layout.auth');
title('Email Request');
state(['email' => '']);
rules(['email' => ['required', 'string', 'email', 'exists:users,email']]);

$email_request = function () {
    $this->validate();

    $status = Password::sendResetLink(['email' => $this->email]);

    if ($status === Password::ResetLinkSent) {
        // ok
        return $this->redirectRoute('home');
    }

    dd($status, Password::ResetLinkSent);

    // return $status === Password::ResetLinkSent
    //     ? back()->with(['status' => __($status)])
    //     : back()->withErrors(['email' => __($status)]);
};

?>

<div class="flex flex-col justify-center items-center h-screen overflow-y-auto min-h-[400px] md:min-h-[600px]">

    <div class="flex flex-col gap-6 max-w-lg px-4 py-8 w-full">

        <livewire:util.light-dark-mode />

        <div class="flex flex-col items-center gap-2">
            <h2 class="normal-heading">REQUEST EMAIL</h2>
            <p class="normal-text">Password Reset Link</p>
        </div>

        <form wire:submit="email_request" class="flex flex-col gap-4 w-full">

            <div class="flex flex-col gap-1">
                <label for="email" class="normal-label">Email</label>
                <input type="text" id="email" wire:model="email" class="outlined-input" placeholder="safi@gmail.com" autocomplete="TRUE" />
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="filled-btn">Send Request</button>
        </form>

    </div>
</div>