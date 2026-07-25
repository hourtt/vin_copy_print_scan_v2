<script>
    document.addEventListener('alpine:init', () => {
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
    });
</script>
