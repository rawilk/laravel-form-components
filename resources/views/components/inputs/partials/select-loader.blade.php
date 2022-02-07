@props(['target' => 'handleSearch'])

<div class="w-full px-3 py-2.5 hidden" wire:loading.delay.class.remove="hidden" wire:target="{{ $target }}">
    <div class="animate-pulse">
        <div class="space-y-3 py-1">
            <div class="h-3 bg-gray-200 rounded"></div>
            <div class="h-3 bg-gray-200 rounded"></div>
            <div class="h-3 bg-gray-200 rounded"></div>
        </div>
    </div>
</div>
