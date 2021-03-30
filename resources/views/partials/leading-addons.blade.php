@if ($leadingAddon)
    <span class="leading-addon inline-flex items-center px-3 rounded-l-md border border-r-0 border-blue-gray-300 bg-blue-gray-50 text-blue-gray-500 sm:text-sm">
        <span class="text-blue-gray-400">
            {!! $leadingAddon !!}
        </span>
    </span>
@elseif ($inlineAddon)
    <div class="inline-addon absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="text-blue-gray-500 sm:text-sm sm:leading-5">{!! $inlineAddon !!}</span>
    </div>
@elseif ($leadingIcon)
    <div class="leading-icon absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <span class="h-5 w-5 text-blue-gray-400">
            {!! $leadingIcon !!}
        </span>
    </div>
@endif
