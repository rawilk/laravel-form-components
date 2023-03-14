import formGroup from './form-group';
import textareaResize from './textarea-resize';

document.addEventListener('alpine:init', () => {
    formGroup(Alpine);
    Alpine.plugin(textareaResize);
});
