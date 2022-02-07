@if ($multiple)
    <template x-for="singleValue in value"
              :key="singleValue"
    >
        <div class="inline-block pt-1 pr-1 align-top">
            <div class="bg-blue-100 text-blue-700 inline-table py-1 rounded-md text-xs align-top font-medium"
                 x-bind:class="{ 'cursor-pointer group focus:ring-2 focus:ring-blue-400': _canDeSelectAnOption() }"
                 x-bind:role="_canDeSelectAnOption() ? 'button' : null"
                 x-on:click.stop="() => { if (_canDeSelectAnOption()) { $el.focus(); toggleOptionByValue(singleValue); } }"
                 tabindex="-1"
            >
                <span class="pr-1 table-cell align-middle px-2" x-text="labelForValue(singleValue)" x-cloak></span>
                <span class="table-cell pl-1 pr-2 align-middle text-blue-400 group-hover:text-blue-600 transition-colors" x-show="_canDeSelectAnOption()">
                    <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                        <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                    </svg>
                </span>
            </div>
        </div>
    </template>
@else
    <span class="inline-block max-w-full truncate align-middle" x-show="! open && value" x-html="valueLabel"></span>
@endif
