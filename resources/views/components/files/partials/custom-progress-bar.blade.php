<div class="file-upload__progress"
     role="progressbar"
     aria-valuemin="0"
     aria-valuemax="100"
     x-bind:aria-valuenow="progress"
     @if ($id) aria-labelledby="{{ $id }}-file-upload-process-label" @endif
>
    <div x-bind:style="{ width: `${progress}%` }"></div>
</div>
