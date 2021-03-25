@if ($trailingAddon)
    <div class="trailing-addon absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
        <span class="text-blue-gray-500 sm:text-sm sm:leading-5">{!! $trailingAddon !!}</span>
    </div>
@elseif ($trailingIcon)
    <div class="trailing-icon pr-3 flex items-center absolute inset-y-0 right-0">
        <span class="h-5 w-5 text-blue-gray-400">
            {!! $trailingIcon !!}
        </span>
    </div>
@endif
