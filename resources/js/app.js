import "bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
    Alpine.data("addToCart", (url, isAvailable) => ({
        adding: false,
        added: false,
        isAvailable: isAvailable,
        add() {
            if (this.adding || !this.isAvailable) return;
            this.adding = true;

            const csrfToken = document.querySelector(
                'meta[name="csrf-token"]',
            )?.content;

            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    Accept: "application/json",
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    if (data.success) {
                        window.dispatchEvent(
                            new CustomEvent("cart-updated", {
                                detail: { count: data.count },
                            }),
                        );
                        this.added = true;
                        setTimeout(() => (this.added = false), 2000);
                    }
                })
                .finally(() => (this.adding = false));
        },
    }));

    Alpine.data("productCarousel", () => ({
        scrollContainer: null,
        canScrollLeft: false,
        canScrollRight: true,
        autoplay: null,
        init() {
            this.scrollContainer = this.$refs.track;
            setTimeout(() => {
                this.updateButtons();
                this.startAutoplay();
            }, 100);
        },
        updateButtons() {
            if (!this.scrollContainer) return;
            const el = this.scrollContainer;
            this.canScrollLeft = el.scrollLeft > 1;
            this.canScrollRight =
                Math.ceil(el.scrollLeft) < el.scrollWidth - el.clientWidth - 1;
        },
        scrollBy(direction) {
            if (!this.scrollContainer) return;
            const cardWidth =
                this.scrollContainer.querySelector("[data-carousel-card]")
                    ?.offsetWidth || 300;
            const gap = 24;
            this.scrollContainer.scrollBy({
                left: direction * (cardWidth + gap),
                behavior: "smooth",
            });
            setTimeout(() => this.updateButtons(), 350);
        },
        startAutoplay() {
            this.autoplay = setInterval(() => {
                if (!this.canScrollRight) {
                    this.scrollContainer.scrollTo({
                        left: 0,
                        behavior: "smooth",
                    });
                    setTimeout(() => this.updateButtons(), 350);
                } else {
                    this.scrollBy(1);
                }
            }, 4000);
        },
        pauseAutoplay() {
            clearInterval(this.autoplay);
        },
        resumeAutoplay() {
            this.startAutoplay();
        },
    }));

    Alpine.data('cartItemHandler', (initialQty, productId) => ({
        qty: initialQty,
        loading: false,
        async updateCart() {
            if (this.qty < 1) return;
            this.loading = true;
            try {
                let formData = new FormData(this.$refs.updateForm);
                formData.set('quantity', this.qty);
                let response = await fetch(this.$refs.updateForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (response.ok) {
                    let html = await response.text();
                    let doc = new DOMParser().parseFromString(html, 'text/html');
                    
                    // Update Order Summary
                    let newSummary = doc.querySelector('#order-summary-card');
                    if (newSummary) document.querySelector('#order-summary-card').innerHTML = newSummary.innerHTML;
                    
                    // Update Item Price
                    let newItemPrice = doc.querySelector('#item-price-' + productId);
                    if (newItemPrice) document.querySelector('#item-price-' + productId).innerHTML = newItemPrice.innerHTML;
                    
                    // Update Nav Badge globally
                    let inputs = doc.querySelectorAll('input[name=\'quantity\']');
                    let newCount = 0;
                    inputs.forEach(input => newCount += parseInt(input.value || 0));
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: newCount } }));
                }
            } catch(e) {
                // Ignore errors silently in production
            } finally {
                this.loading = false;
            }
        }
    }));

    Alpine.data("addressManager", (addressesData = [], updateUrl = "", csrfToken = "", userName = "") => ({
        addresses: addressesData,
        viewState: 'EMPTY',
        selectedAddressId: null,
        editingId: null,
        addressToDelete: null,
        errors: {},
        formData: {
            phone_number: '',
            address: '',
            city: '',
            state: '',
            zip_code: ''
        },
        init() {
            this.updateViewState();
        },
        formatPhone(event) {
            const input = event ? event.target : null;
            let cursorPosition = input ? input.selectionStart : 0;
            const originalValue = this.formData.phone_number;
            const valueBeforeCursor = originalValue.substring(0, cursorPosition);
            const digitsBeforeCursor = valueBeforeCursor.replace(/\D/g, '').length;

            let cleaned = originalValue.replace(/\D/g, '').substring(0, 10);
            let match = cleaned.match(/^(\d{0,3})(\d{0,3})(\d{0,4})$/);
            let formatted = '';
            
            if (match) {
                formatted = !match[2] ? match[1] : match[1] + ' ' + match[2] + (match[3] ? ' ' + match[3] : '');
            }
            this.formData.phone_number = formatted;

            if (input) {
                let newCursorPosition = 0;
                let digitCount = 0;
                for (let i = 0; i < formatted.length; i++) {
                    if (digitCount === digitsBeforeCursor) break;
                    if (/\d/.test(formatted[i])) digitCount++;
                    newCursorPosition++;
                }
                this.$nextTick(() => {
                    input.setSelectionRange(newCursorPosition, newCursorPosition);
                });
            }
        },
        updateViewState() {
            if (this.addresses.length > 0) {
                this.viewState = 'LIST';
                if (!this.selectedAddressId || !this.addresses.find(a => a.id === this.selectedAddressId)) {
                    this.selectedAddressId = this.addresses[0].id;
                }
            } else {
                this.viewState = 'EMPTY';
                this.selectedAddressId = null;
            }
        },
        openForm(address = null) {
            if (address) {
                this.editingId = address.id;
                this.formData = { ...address, is_default: Boolean(address.is_default) };
                this.formatPhone();
            } else {
                this.editingId = null;
                this.formData = {
                    phone_number: '',
                    address: '',
                    city: '',
                    state: '',
                    zip_code: '',
                    is_default: false
                };
            }
            this.viewState = 'FORM';
        },
        goBack() {
            if (this.addresses.length === 0) {
                this.viewState = 'EMPTY';
            } else {
                this.viewState = 'LIST';
            }
        },
        closeModalAndReset() {
            window.closeModal('modal-address');
            setTimeout(() => {
                this.goBack();
            }, 300);
        },
        promptDelete(id) {
            this.addressToDelete = id;
            this.viewState = 'DELETE_CONFIRM';
        },
        executeDelete() {
            if (!this.addressToDelete) return;

            fetch(updateUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    inline_field: 'address',
                    address_id: this.addressToDelete,
                    delete: true
                })
            })
            .then(async res => {
                if (!res.ok) {
                    let errMsg = `HTTP ${res.status} ${res.statusText}`;
                    try {
                        const errData = await res.json();
                        errMsg = errData.message || errMsg;
                    } catch (e) {}
                    throw new Error(errMsg);
                }
                
                this.addresses = this.addresses.filter(a => a.id !== this.addressToDelete);
                this.addressToDelete = null;
                this.selectedAddressId = null;
                this.updateViewState();
            })
            .catch(error => {
                console.error('Error deleting address:', error.message);
                alert('An error occurred while trying to delete the address. Please try again.');
            });
        },
        saveAddress() {
            this.errors = {}; // Clear any previous error state
            fetch(updateUrl, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    inline_field: 'address',
                    address_id: this.editingId,
                    phone_number: this.formData.phone_number.replace(/\D/g, ''),
                    address: this.formData.address,
                    city: this.formData.city,
                    state: this.formData.state,
                    zip_code: this.formData.zip_code,
                    is_default: this.formData.is_default
                })
            })
            .then(async response => {
                if (!response.ok) {
                    let errMsg = 'Failed to save to database';
                    try {
                        const errData = await response.json();
                        if (errData.errors) {
                            this.errors = errData.errors;
                            errMsg = 'Please fix the errors below.';
                        } else if (errData.message) {
                            errMsg = errData.message;
                        }
                    } catch(e) {}
                    throw new Error(errMsg);
                }
                return response.json();
            })
            .then(data => {
                const updatedAddress = {
                    name: userName,
                    ...data.address
                };

                if (this.editingId) {
                    const index = this.addresses.findIndex(a => a.id === this.editingId);
                    if (index !== -1) this.addresses[index] = updatedAddress;
                } else {
                    this.addresses.push(updatedAddress);
                }

                if (updatedAddress.is_default) {
                    this.addresses.forEach(a => {
                        if (a.id !== updatedAddress.id) a.is_default = false;
                    });
                }

                this.selectedAddressId = updatedAddress.id;
                this.updateViewState();
            })
            .catch(error => {
                alert('Validation Error:\n' + error.message);
                console.error(error);
            });
        },
        confirmAddress() {
            if (this.selectedAddressId) {
                let address = this.addresses.find(a => a.id === this.selectedAddressId);
                if (address) {
                    fetch(this.updateUrl, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            inline_field: 'address',
                            address_id: address.id,
                            phone_number: address.phone_number,
                            address: address.address,
                            city: address.city,
                            state: address.state,
                            zip_code: address.zip_code,
                            is_default: true
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.addresses.forEach(a => a.is_default = (a.id === address.id));
                            let html = address.address + '<br>' + address.city + (address.state ? ', ' + address.state : '') + ' ' + address.zip_code;
                            window.dispatchEvent(new CustomEvent('update-default-address', { detail: html }));
                            window.closeModal('modal-address');
                        } else {
                            alert(data.message || 'Error updating default address');
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Failed to update default address.');
                    });
                } else {
                    window.closeModal('modal-address');
                }
            }
        }
    }));
    Alpine.data("phoneMask", (initialValue = "") => ({
        displayPhone: "",
        init() {
            this.formatInitial(initialValue);
        },
        formatInitial(val) {
            if (!val) return;
            let cleaned = val.replace(/\D/g, "").substring(0, 10);
            let match = cleaned.match(/^(\d{0,3})(\d{0,3})(\d{0,4})$/);
            if (match) {
                this.displayPhone = !match[2]
                    ? match[1]
                    : match[1] +
                      " " +
                      match[2] +
                      (match[3] ? " " + match[3] : "");
            }
        },
        formatPhone(event) {
            const input = event.target;
            let cursorPosition = input.selectionStart;
            const originalValue = this.displayPhone;
            const valueBeforeCursor = originalValue.substring(
                0,
                cursorPosition,
            );
            const digitsBeforeCursor = valueBeforeCursor.replace(
                /\D/g,
                "",
            ).length;

            let cleaned = originalValue.replace(/\D/g, "").substring(0, 10);
            let match = cleaned.match(/^(\d{0,3})(\d{0,3})(\d{0,4})$/);
            let formatted = "";

            if (match) {
                formatted = !match[2]
                    ? match[1]
                    : match[1] +
                      " " +
                      match[2] +
                      (match[3] ? " " + match[3] : "");
            }

            this.displayPhone = formatted;

            let newCursorPosition = 0;
            let digitCount = 0;
            for (let i = 0; i < formatted.length; i++) {
                if (digitCount === digitsBeforeCursor) {
                    break;
                }
                if (/\d/.test(formatted[i])) {
                    digitCount++;
                }
                newCursorPosition++;
            }

            this.$nextTick(() => {
                input.setSelectionRange(newCursorPosition, newCursorPosition);
            });
        },
        get rawPhone() {
            return this.displayPhone.replace(/\D/g, "");
        },
    }));
});
Alpine.start();
