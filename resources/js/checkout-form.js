document.addEventListener("alpine:init", () => {
    // 1. Renamed to 'checkout' to match x-data="checkout(...)" in index.blade.php
    // 2. Updated arguments to accept initialSubtotal and shippingMethods safely
    Alpine.data("checkout", (initialSubtotal = 0, shippingMethods = []) => ({
        step: 1,
        deliveryMethod: "delivery", // pickup | delivery
        paymentMethod: "stripe", // cod | stripe | aba
        customer: {
            name: "",
            phone: "",
            address: "",
            city: "",
            zip: "",
        },
        card: {
            // Kept for UI visual purposes if they type, but Stripe will handle real input
            number: "",
            expiry: "",
            cvv: "",
        },

        // Safely parse initialSubtotal whether passed as a number or an object
        baseSubtotal:
            typeof initialSubtotal === "object"
                ? initialSubtotal.subtotal || 0
                : parseFloat(initialSubtotal) || 0,
        baseShippingCost: 15.0,

        // 3. Named 'shippingFee' to match your cart-summary.blade.php template
        get shippingFee() {
            return this.deliveryMethod === "delivery"
                ? this.baseShippingCost
                : 0.0;
        },
        // Kept as a backup alias in case other views reference shippingCost
        get shippingCost() {
            return this.shippingFee;
        },
        get subtotal() {
            return parseFloat(this.baseSubtotal) || 0;
        },
        get tax() {
            return 0; // Or calculate if needed
        },
        get total() {
            return this.subtotal + this.shippingFee + this.tax;
        },

        // 4. Added formatPrice() required by x-text in cart-summary.blade.php
        formatPrice(amount) {
            const num = parseFloat(amount) || 0;
            return "$" + num.toFixed(2);
        },

        nextStep() {
            // Simple Validation before proceeding
            if (this.step === 1) {
                if (this.deliveryMethod === "delivery") {
                    if (
                        !this.customer.name ||
                        !this.customer.phone ||
                        !this.customer.address ||
                        !this.customer.city
                    ) {
                        alert("Please fill in all delivery details.");
                        return;
                    }
                }
            } else if (this.step === 2) {
                // We won't validate card here as Stripe Checkout handles it server-side via redirect
            }

            if (this.step < 3) this.step++;
            window.scrollTo({ top: 0, behavior: "smooth" });
        },
        prevStep() {
            if (this.step > 1) this.step--;
            window.scrollTo({ top: 0, behavior: "smooth" });
        },
    }));
});
