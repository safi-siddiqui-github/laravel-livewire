<?php

use App\Http\Controllers\RateLimiterController;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\{computed, layout, state, title};

layout('livewire.layout.auth');
title('Email Verification Notice');

$resendLink = function () {

    $key = 'resend-link:' . auth()->id();

    $attempt = RateLimiter::attempt(
        $key,
        $perMinute = 1,
        function () {
            request()->user()->sendEmailVerificationNotification();
        }
    );

    $availableIn = RateLimiter::availableIn($key);
    
    if (!$attempt) {
        throw ValidationException::withMessages([
            'throttle' => "Email has already been sent. New email will be sent in $availableIn seconds",
        ]);
    }

    // Verifiaction Link Sent

}

?>

<div class="flex flex-col justify-center items-center md:h-screen md:overflow-y-auto md:min-h-[700px]">

    <div class="flex flex-col gap-6 max-w-lg px-4 py-8 w-full">

        <livewire:util.light-dark-mode />

        <div class="flex flex-col items-center gap-2">
            <h2 class="normal-heading">EMAIL VERIFICATION</h2>
            <p class="normal-text">Email Verification Link Sent</p>
            @error('throttle') <span class="">{{$message}}</span> @enderror
        </div>

        <button type="submit" class="filled-btn" wire:click="resendLink">Resend Link</button>
    </div>

</div>