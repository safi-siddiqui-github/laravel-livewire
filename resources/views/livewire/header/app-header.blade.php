<?php

use function Livewire\Volt\{state};

$logout = function () {
    auth()->guard('web')->logout();

    session()->invalidate();
    session()->regenerateToken();

    $this->redirectRoute('auth.login');
}

?>

<header class="flex px-4 py-4 justify-between items-center border-b dark:border-b-white">

    <a href="{{route('home')}}" class="large-link">Safi Siddiqui</a>

    <div class="flex gap-2">
        <livewire:util.light-dark-mode />

        @auth
        <button type="button" class="outlined-btn-with-svg">
            <p class="">{{ucfirst(auth()->user()->username)}}</p>
            <livewire:svg.menu class="normal-svg" />
        </button>
        <button type="button" wire:click="logout" class="outlined-btn">Logout</button>
        @endauth

        @guest
        <a href="{{route('auth.login')}}" class="filled-link">Login</a>
        <a href="{{route('auth.register')}}" class="outlined-link">Register</a>
        @endguest
    </div>

</header>