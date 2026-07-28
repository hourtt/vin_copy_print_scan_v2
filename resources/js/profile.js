window.ieOpen = function (field) {
    const row = document.querySelector(`[data-inline-field="${field}"]`);
    if (!row) return;

    // Hide the display slots (value text + Edit button)
    row.querySelectorAll(".ie-display").forEach(
        (el) => (el.style.display = "none"),
    );

    // Show the editor
    const editor = document.getElementById(`ie-editor-${field}`);
    if (editor) {
        editor.style.display = "block";
        // Focus the first focusable input inside
        const firstInput = editor.querySelector('input:not([type="hidden"])');
        if (firstInput) firstInput.focus();
    }
};

/**
 * Close the inline editor for a given field key, reverting to display mode.
 *
 * @param {string} field  e.g. 'name' | 'email'
 */
window.ieClose = function (field) {
    const row = document.querySelector(`[data-inline-field="${field}"]`);
    if (!row) return;

    // Hide the editor
    const editor = document.getElementById(`ie-editor-${field}`);
    if (editor) editor.style.display = "none";

    // Show the display slots again
    row.querySelectorAll(".ie-display").forEach(
        (el) => (el.style.display = ""),
    );
};



/*
 * Modal Helpers (unchanged — still used by Address Book,
 * Payment Methods, Login & Security, and Logout)
 *  */

window.openModal = function (id) {
    const overlay = document.getElementById(id);
    if (!overlay) return;
    overlay.classList.add("active");
    document.body.style.overflow = "hidden";
};

window.closeModal = function (id) {
    const overlay = document.getElementById(id);
    if (!overlay) return;
    overlay.classList.remove("active");
    document.body.style.overflow = "";
};

// Close on backdrop click
document.querySelectorAll('[role="dialog"]').forEach((overlay) => {
    overlay.addEventListener("click", function (e) {
        if (e.target === this) {
            closeModal(this.id);
        }
    });
});

// Close on Escape key
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        // Close any open modals
        document
            .querySelectorAll('[role="dialog"].active')
            .forEach((overlay) => {
                closeModal(overlay.id);
            });
    }
});
