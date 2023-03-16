<div class="{{ $containerClass() }}">
    {{ $slot }}

    {{-- input/upload progress --}}
    <div
        x-data="{ isUploading: false, progress: 0 }"
        class="w-full flex-1"

        @if ($canShowUploadProgress())
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
        @endif
    >
        @include('form-components::components.files.partials.file-input')

        {{ $afterInput ?? '' }}

        @includeWhen($canShowUploadProgress(), 'form-components::components.files.partials.upload-progress')
    </div>

    {{ $after ?? '' }}
</div>
