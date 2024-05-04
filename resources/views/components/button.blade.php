@props(['href' => '#', 'classes' => '', 'wire_navigate' => false, 'color' => 'violet'])

<button href="{{$href}}" @if($wire_navigate) wire:navigate="wire:navigate" @endif class="button button-{{$color}} {{$classes}}">
    {{ $slot }}
</button>
