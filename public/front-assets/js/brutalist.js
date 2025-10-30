/**
 * BRUTALIST UI COMPONENT LIBRARY
 * Vanilla JavaScript Behavior Module
 * No dependencies, pure ES6+
 */

class BrutalistUI {
    constructor() {
        this.modals = new Map();
        this.dropdowns = new Map();
        this.toasts = [];
        this.init();
    }

    init() {
        this.initModals();
        this.initDropdowns();
        this.initTabs();
        this.initAccordions();
        this.initToggles();
        this.initNavbar();
        this.initSidebar();
        this.initFileUpload();
        this.initSearch();
        this.initFormValidation();
        this.initTableSorting();
        this.initKeyboardNavigation();
    }

    // ============================================
    // MODALS
    // ============================================

    initModals() {
        document.querySelectorAll("[data-modal-trigger]").forEach((trigger) => {
            trigger.addEventListener("click", (e) => {
                e.preventDefault();
                const modalId = trigger.getAttribute("data-modal-trigger");
                this.openModal(modalId);
            });
        });

        document.querySelectorAll("[data-modal-close]").forEach((closeBtn) => {
            closeBtn.addEventListener("click", () => {
                const modal = closeBtn.closest(".brutalist-modal-overlay");
                if (modal) {
                    this.closeModal(modal.id);
                }
            });
        });

        // Close modal on overlay click
        document
            .querySelectorAll(".brutalist-modal-overlay")
            .forEach((overlay) => {
                overlay.addEventListener("click", (e) => {
                    if (e.target === overlay) {
                        this.closeModal(overlay.id);
                    }
                });
            });

        // Keyboard: Escape to close
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                document
                    .querySelectorAll(".brutalist-modal-overlay.active")
                    .forEach((modal) => {
                        this.closeModal(modal.id);
                    });
            }
        });
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add("active");
            this.trapFocus(modal);
        }
    }

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove("active");
            this.releaseFocus();
        }
    }

    trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        element.addEventListener("keydown", (e) => {
            if (e.key !== "Tab") return;

            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    lastElement.focus();
                    e.preventDefault();
                }
            } else {
                if (document.activeElement === lastElement) {
                    firstElement.focus();
                    e.preventDefault();
                }
            }
        });

        firstElement?.focus();
    }

    releaseFocus() {
        // Reset focus management
    }

    // ============================================
    // DROPDOWNS
    // ============================================

    initDropdowns() {
        document.querySelectorAll("[data-dropdown]").forEach((dropdown) => {
            const trigger = dropdown.querySelector("[data-dropdown-trigger]");
            const menu = dropdown.querySelector("[data-dropdown-menu]");

            if (trigger && menu) {
                trigger.addEventListener("click", (e) => {
                    e.stopPropagation();
                    menu.classList.toggle("active");
                });

                menu.querySelectorAll("[data-dropdown-item]").forEach(
                    (item) => {
                        item.addEventListener("click", () => {
                            menu.classList.remove("active");
                        });

                        item.addEventListener("keydown", (e) => {
                            if (e.key === "Enter" || e.key === " ") {
                                e.preventDefault();
                                item.click();
                            }
                        });
                    }
                );
            }
        });

        // Close dropdowns on outside click
        document.addEventListener("click", () => {
            document
                .querySelectorAll("[data-dropdown-menu].active")
                .forEach((menu) => {
                    menu.classList.remove("active");
                });
        });
    }

    // ============================================
    // TABS
    // ============================================

    initTabs() {
        document.querySelectorAll("[data-tabs]").forEach((tabsContainer) => {
            const buttons = tabsContainer.querySelectorAll("[data-tab-button]");
            const contents =
                tabsContainer.querySelectorAll("[data-tab-content]");

            buttons.forEach((button, index) => {
                button.addEventListener("click", () => {
                    buttons.forEach((btn) => btn.classList.remove("active"));
                    contents.forEach((content) =>
                        content.classList.remove("active")
                    );

                    button.classList.add("active");
                    contents[index].classList.add("active");
                });

                // Keyboard navigation
                button.addEventListener("keydown", (e) => {
                    let nextIndex = index;

                    if (e.key === "ArrowRight" || e.key === "ArrowDown") {
                        nextIndex = (index + 1) % buttons.length;
                        e.preventDefault();
                    } else if (e.key === "ArrowLeft" || e.key === "ArrowUp") {
                        nextIndex =
                            (index - 1 + buttons.length) % buttons.length;
                        e.preventDefault();
                    }

                    if (nextIndex !== index) {
                        buttons[nextIndex].click();
                        buttons[nextIndex].focus();
                    }
                });
            });

            // Set first tab as active
            if (buttons.length > 0) {
                buttons[0].classList.add("active");
                contents[0].classList.add("active");
            }
        });
    }

    // ============================================
    // ACCORDIONS
    // ============================================

    initAccordions() {
        document.querySelectorAll("[data-accordion]").forEach((accordion) => {
            const triggers = accordion.querySelectorAll(
                "[data-accordion-trigger]"
            );

            triggers.forEach((trigger) => {
                trigger.addEventListener("click", () => {
                    const content = trigger.nextElementSibling;
                    const isActive = trigger.classList.contains("active");

                    // Close all other items
                    triggers.forEach((t) => {
                        if (t !== trigger) {
                            t.classList.remove("active");
                            t.nextElementSibling.classList.remove("active");
                        }
                    });

                    // Toggle current item
                    trigger.classList.toggle("active");
                    content.classList.toggle("active");
                });

                // Keyboard navigation
                trigger.addEventListener("keydown", (e) => {
                    if (e.key === "Enter" || e.key === " ") {
                        e.preventDefault();
                        trigger.click();
                    }
                });
            });
        });
    }

    // ============================================
    // TOGGLES / SWITCHES
    // ============================================

    initToggles() {
        document.querySelectorAll("[data-toggle]").forEach((toggle) => {
            toggle.addEventListener("change", (e) => {
                const event = new CustomEvent("toggle-change", {
                    detail: { checked: e.target.checked },
                });
                e.target.dispatchEvent(event);
            });
        });
    }

    // ============================================
    // NAVBAR
    // ============================================

    initNavbar() {
        const navbarToggle = document.querySelector("[data-navbar-toggle]");
        const navbarMenu = document.querySelector("[data-navbar-menu]");

        if (navbarToggle && navbarMenu) {
            navbarToggle.addEventListener("click", () => {
                navbarMenu.classList.toggle("active");
            });

            // Close menu on link click
            navbarMenu.querySelectorAll("a").forEach((link) => {
                link.addEventListener("click", () => {
                    navbarMenu.classList.remove("active");
                });
            });
        }
    }

    // ============================================
    // SIDEBAR
    // ============================================

    initSidebar() {
        const sidebarToggle = document.querySelector("[data-sidebar-toggle]");
        const sidebar = document.querySelector("[data-sidebar]");
        const sidebarClose = document.querySelector("[data-sidebar-close]");

        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener("click", () => {
                sidebar.classList.toggle("active");
            });
        }

        if (sidebarClose && sidebar) {
            sidebarClose.addEventListener("click", () => {
                sidebar.classList.remove("active");
            });
        }

        // Close sidebar on link click
        if (sidebar) {
            sidebar.querySelectorAll("a").forEach((link) => {
                link.addEventListener("click", () => {
                    sidebar.classList.remove("active");
                });
            });
        }
    }

    // ============================================
    // FILE UPLOAD
    // ============================================

    initFileUpload() {
        document
            .querySelectorAll("[data-file-upload]")
            .forEach((uploadArea) => {
                const input = uploadArea.querySelector('input[type="file"]');
                const fileList = uploadArea.querySelector("[data-file-list]");

                if (!input) return;

                // Click to upload
                uploadArea.addEventListener("click", () => input.click());

                // Drag and drop
                uploadArea.addEventListener("dragover", (e) => {
                    e.preventDefault();
                    uploadArea.classList.add("dragover");
                });

                uploadArea.addEventListener("dragleave", () => {
                    uploadArea.classList.remove("dragover");
                });

                uploadArea.addEventListener("drop", (e) => {
                    e.preventDefault();
                    uploadArea.classList.remove("dragover");
                    this.handleFiles(input.files, fileList);
                });

                // File input change
                input.addEventListener("change", () => {
                    this.handleFiles(input.files, fileList);
                });
            });
    }

    handleFiles(files, fileList) {
        if (!fileList) return;

        fileList.innerHTML = "";
        Array.from(files).forEach((file) => {
            const item = document.createElement("li");
            item.className = "brutalist-file-upload__item";
            item.innerHTML = `
        <span>${file.name}</span>
        <button type="button" class="brutalist-btn brutalist-btn--ghost brutalist-btn--icon" data-remove-file>×</button>
      `;
            fileList.appendChild(item);

            item.querySelector("[data-remove-file]").addEventListener(
                "click",
                () => {
                    item.remove();
                }
            );
        });
    }

    // ============================================
    // SEARCH
    // ============================================

    initSearch() {
        document.querySelectorAll("[data-search]").forEach((search) => {
            const input = search.querySelector("[data-search-input]");
            const suggestions = search.querySelector(
                "[data-search-suggestions]"
            );

            if (!input || !suggestions) return;

            input.addEventListener("input", (e) => {
                const query = e.target.value.toLowerCase();

                if (query.length > 0) {
                    suggestions.classList.add("active");
                    // Filter suggestions based on query
                    suggestions
                        .querySelectorAll("[data-search-suggestion]")
                        .forEach((item) => {
                            const text = item.textContent.toLowerCase();
                            item.style.display = text.includes(query)
                                ? "block"
                                : "none";
                        });
                } else {
                    suggestions.classList.remove("active");
                }
            });

            suggestions
                .querySelectorAll("[data-search-suggestion]")
                .forEach((item) => {
                    item.addEventListener("click", () => {
                        input.value = item.textContent;
                        suggestions.classList.remove("active");
                    });
                });
        });
    }

    // ============================================
    // FORM VALIDATION
    // ============================================

    initFormValidation() {
        document.querySelectorAll("[data-form-validate]").forEach((form) => {
            form.addEventListener("submit", (e) => {
                if (!this.validateForm(form)) {
                    e.preventDefault();
                }
            });

            form.querySelectorAll("input, textarea, select").forEach(
                (field) => {
                    field.addEventListener("blur", () => {
                        this.validateField(field);
                    });
                }
            );
        });
    }

    validateForm(form) {
        let isValid = true;
        form.querySelectorAll("input, textarea, select").forEach((field) => {
            if (!this.validateField(field)) {
                isValid = false;
            }
        });
        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute("required");
        const type = field.type;
        let isValid = true;

        // Remove previous error state
        field.classList.remove(
            "brutalist-input--error",
            "brutalist-textarea--error",
            "brutalist-select--error"
        );
        const errorMsg = field.parentElement.querySelector(
            ".brutalist-helper-text--error"
        );
        if (errorMsg) errorMsg.remove();

        // Validation logic
        if (isRequired && !value) {
            isValid = false;
        } else if (type === "email" && value && !this.isValidEmail(value)) {
            isValid = false;
        } else if (type === "number" && value && isNaN(value)) {
            isValid = false;
        }

        if (!isValid) {
            field.classList.add(
                `brutalist-${field.tagName.toLowerCase()}--error`
            );
            const errorMsg = document.createElement("div");
            errorMsg.className =
                "brutalist-helper-text brutalist-helper-text--error";
            errorMsg.textContent = `Please enter a valid ${type}`;
            field.parentElement.appendChild(errorMsg);
        }

        return isValid;
    }

    isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // ============================================
    // TABLE SORTING
    // ============================================

    initTableSorting() {
        document.querySelectorAll("[data-table-sortable]").forEach((table) => {
            const headers = table.querySelectorAll("th[data-sortable]");

            headers.forEach((header, index) => {
                header.style.cursor = "pointer";
                header.addEventListener("click", () => {
                    this.sortTable(table, index, header);
                });
            });
        });
    }

    sortTable(table, columnIndex, header) {
        const tbody = table.querySelector("tbody");
        const rows = Array.from(tbody.querySelectorAll("tr"));
        const isAsc = header.classList.contains("asc");

        // Remove sort indicators from all headers
        table.querySelectorAll("th").forEach((th) => {
            th.classList.remove("asc", "desc");
        });

        // Sort rows
        rows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent.trim();
            const bValue = b.cells[columnIndex].textContent.trim();

            const aNum = Number.parseFloat(aValue);
            const bNum = Number.parseFloat(bValue);

            if (!isNaN(aNum) && !isNaN(bNum)) {
                return isAsc ? bNum - aNum : aNum - bNum;
            }

            return isAsc
                ? bValue.localeCompare(aValue)
                : aValue.localeCompare(bValue);
        });

        // Re-append sorted rows
        rows.forEach((row) => tbody.appendChild(row));

        // Add sort indicator
        header.classList.add(isAsc ? "desc" : "asc");
    }

    // ============================================
    // KEYBOARD NAVIGATION
    // ============================================

    initKeyboardNavigation() {
        // Global keyboard shortcuts
        document.addEventListener("keydown", (e) => {
            // Alt + T: Toggle sidebar
            if (e.altKey && e.key === "t") {
                const sidebar = document.querySelector("[data-sidebar]");
                if (sidebar) {
                    sidebar.classList.toggle("active");
                }
            }
        });
    }

    // ============================================
    // TOAST NOTIFICATIONS
    // ============================================

    showToast(message, type = "info", duration = 3000) {
        const container =
            document.querySelector(".brutalist-toast-container") ||
            this.createToastContainer();

        const toast = document.createElement("div");
        toast.className = `brutalist-toast brutalist-toast--${type}`;

        const icons = {
            success: "✓",
            error: "✕",
            warning: "⚠",
            info: "ℹ",
        };

        toast.innerHTML = `
      <div class="brutalist-toast__icon">${icons[type]}</div>
      <div class="brutalist-toast__content">${message}</div>
      <button class="brutalist-toast__close" aria-label="Close notification">×</button>
    `;

        container.appendChild(toast);

        const closeBtn = toast.querySelector(".brutalist-toast__close");
        closeBtn.addEventListener("click", () => {
            this.removeToast(toast);
        });

        if (duration > 0) {
            setTimeout(() => {
                this.removeToast(toast);
            }, duration);
        }

        return toast;
    }

    removeToast(toast) {
        toast.classList.add("removing");
        setTimeout(() => {
            toast.remove();
        }, 200);
    }

    createToastContainer() {
        const container = document.createElement("div");
        container.className = "brutalist-toast-container";
        document.body.appendChild(container);
        return container;
    }
}

// Initialize on DOM ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", () => {
        window.brutalistUI = new BrutalistUI();
    });
} else {
    window.brutalistUI = new BrutalistUI();
}

// Export for use in modules
if (typeof module !== "undefined" && module.exports) {
    module.exports = BrutalistUI;
}

document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".brutalist-sidebar");
    const mobileToggle = document.querySelector("#mobile-sidebar-toggle");

    if (sidebar && mobileToggle) {
        mobileToggle.addEventListener("click", function () {
            sidebar.classList.toggle("open");
        });
    }
});
