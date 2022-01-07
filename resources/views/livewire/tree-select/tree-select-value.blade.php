@if ($multiple)
    @php($canDeselect = $this->canDeSelectAnOption())
    @foreach ($value as $singleValue)
        <div class="inline-block pt-1 pr-1 align-top"
             wire:key="treeSelect{{ $name }}SelectedOption-{{ $singleValue }}"
        >
            <div @class([
                'bg-blue-100 text-blue-700 inline-table py-1 rounded-md text-xs align-top font-medium',
                'cursor-pointer group focus:ring-2 focus:ring-blue-400' => $canDeselect,
            ])
            @if ($canDeselect)
                 role="button"
                 x-on:click.stop="$el.focus(); $wire.toggleOption('{{ $singleValue }}')"
                 tabindex="-1"
            @endif
            >
                <span class="pr-1 table-cell align-middle px-2">{{ $this->labelForValue($singleValue) }}</span>
                @if ($canDeselect)
                    <span class="table-cell pl-1 pr-2 align-middle text-blue-400 group-hover:text-blue-600 transition-colors">
                        <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                        </svg>
                    </span>
                @endif
            </div>
        </div>
    @endforeach
@else
    <span class="inline-block max-w-full truncate align-middle" x-show="! open">{{ $this->labelForValue($value) }}</span>
@endif
