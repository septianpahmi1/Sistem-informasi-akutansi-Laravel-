function onlyNumberInput() {
    document.querySelectorAll("input#number").forEach((input) => {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    });
}

document.addEventListener("DOMContentLoaded", onlyNumberInput);
document.addEventListener("livewire:load", onlyNumberInput);
document.addEventListener("livewire:update", onlyNumberInput);
