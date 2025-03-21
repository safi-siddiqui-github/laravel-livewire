<?php

use function Livewire\Volt\{state};

//

?>


<div class="flex flex-wrap w-full items-center gap-2">

    <a href="{{route('auth.google.login')}}" class="outlined-link-with-svg flex-1 justify-center min-w-fit">
        <livewire:svg.google class="normal-svg" />
        <p class="">Continue with Google</p>
    </a>

    <a href="{{route('auth.github.login')}}" class="outlined-link-with-svg flex-1 justify-center min-w-fit">
        <livewire:svg.github class="normal-svg" />
        <p class="">Continue with Github</p>
    </a>

</div>