<?php

use function Livewire\Volt\{state};

$logout = function () {
    auth()->guard('web')->logout();

    session()->invalidate();
    session()->regenerateToken();

    $this->redirectRoute('auth.login');
}

?>

<header class="flex flex-wrap px-4 py-4 gap-4 justify-between items-center border-b border-slate-500">

    <a href="{{route('home')}}" class="font-medium">Safi Siddiqui</a>

    <div class="flex flex-wrap gap-2">
        
        @auth
        <button type="button" class="outlined-btn-with-svg min-w-fit">
            <p class="">{{ucfirst(auth()->user()->username)}}</p>
            <livewire:svg.menu class="normal-svg" />
        </button>
        <button type="button" wire:click="logout" class="outlined-btn">Logout</button>
        @endauth
        
        @guest
        <a href="{{route('auth.login')}}" class="">Login</a>
        @endguest

        <livewire:util.light-dark-mode />
    </div>

</header>