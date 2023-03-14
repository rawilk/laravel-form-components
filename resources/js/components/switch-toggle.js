export default options => ({
    value: false,
    onValue: true,
    offValue: false,
    ...options,

    get isPressed() {
        if (Array.isArray(this.value)) {
            return this.value.includes(this.onValue);
        }

        return this.value === this.onValue;
    },

    toggle() {
        if (Array.isArray(this.value)) {
            this.isPressed
                ? this.value.splice(this.value.indexOf(this.onValue), 1)
                : this.value.push(this.onValue);
        } else {
            this.value = this.isPressed ? this.offValue : this.onValue;
        }

        this.$dispatch('input', this.value);
    },
});
