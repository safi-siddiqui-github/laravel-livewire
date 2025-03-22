<?php

use function Livewire\Volt\{layout, title};

layout('livewire.layout.app');
title('Laravel Home');

?>

<div class="flex flex-col items-start p-4">

    <a href="{{route('todo.app')}}" class="outlined-link-with-svg flex-1 justify-center min-w-fit">
        <livewire:svg.check class="normal-svg" />
        <p class="">Todo App</p>
    </a>

</div>