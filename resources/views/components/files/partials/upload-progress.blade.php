<div
    class="relative mt-3 file-upload__progress-container"
    x-show="isUploading"
    x-transition
    x-cloak
>
    <div class="flex mb-2 items-center justify-between">
        <div class="file-upload__badge" @if ($id) id="{{ $id }}-file-upload-process-label" @endif>
            {{ __('form-components::messages.file_upload_processing') }}
        </div>

        <div class="file-upload__percent">
            <span x-text="`${progress}%`"></span>
        </div>
    </div>

    {{-- progress bar --}}
    @includeWhen($useNativeProgressBar, 'form-components::components.files.partials.native-progress-bar')
    @includeWhen(! $useNativeProgressBar, 'form-components::components.files.partials.custom-progress-bar')
</div>
