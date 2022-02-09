<div class="file-upload flex items-center space-x-5 {{ $attributes['class'] ?? '' }}">
    {{ $slot }}

    <div x-data="{ focused: false, isUploading: false, progress: 0 }"
         @if ($canShowUploadProgress($attributes))
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
         @endif
        class="space-y-4 w-full"
    >
        <span class="file-upload__input rounded-md">
            <input x-on:focus="focused = true"
                   x-on:blur="focused = false"
                   class="sr-only"
                   type="file"
                   @if ($multiple) multiple @endif
                   @if ($name) name="{{ $name }}" @endif
                   @if ($id) id="{{ $id }}" @endif
                   @if ($accepts()) accept="{{ $accepts() }}" @endif

                   {!! $ariaDescribedBy() !!}
                   @if ($hasErrorsAndShow($name))
                       aria-invalid="true"
                   @endif

                   {{ $attributes->except('class') }}
                   {{ $extraAttributes }}
            />

            <label for="{{ $id }}"
                   x-bind:class="{ 'file-upload__label--focused outline-none border-blue-300 ring-blue-300': focused }"
                   class="file-upload__label cursor-pointer py-2 px-3 border border-slate-300 rounded-md text-sm leading-4 font-medium text-slate-700 transition shadow-sm hover:text-slate-500 active:bg-slate-50 active:text-slate-800"
            >
                <span role="button"
                      aria-controls="{{ $id }}"
                      tabindex="0"
                      class="outline-none"
                >
                    {{ $label }}
                </span>
            </label>
        </span>

        {{-- Upload progress --}}
        @if ($canShowUploadProgress($attributes))
        <div class="relative" x-show="isUploading" x-transition x-cloak>
            <div class="flex mb-2 items-center justify-between">
                <div class="file-upload__badge inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium leading-4 bg-green-100 text-green-800">
                    {{ __('form-components::messages.file_upload_processing') }}
                </div>

                <div class="text-right">
                    <span class="text-xs font-semibold inline-block text-green-600"
                          x-text="progress + '%'"
                    >
                    </span>
                </div>
            </div>

            <div class="file-upload__progress overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-200">
                <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"
                     x-bind:style="'width: ' + progress + '%;'"
                >
                </div>
            </div>
        </div>
        @endif
    </div>

    {{ $after ?? '' }}
</div>
