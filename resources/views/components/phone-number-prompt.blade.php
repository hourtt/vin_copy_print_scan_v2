<x-modal name="phone-prompt" maxWidth="md">
    <div
        x-data="{
            pendingProductId: null,
            phoneNumber: '',
            loading: false,
            error: null,

            init() {
                window.addEventListener('phone-prompt', (e) => {
                    this.pendingProductId = e.detail.productId;
                    this.phoneNumber = '';
                    this.error = null;
                    $dispatch('open-modal', 'phone-prompt');
                    setTimeout(() => this.$refs.phoneInput.focus(), 100);
                });
            },

            async save() {
                if (!this.phoneNumber) {
                    this.error = 'Please enter your phone number';
                    return;
                }

                this.loading = true;
                this.error = null;

                try {
                    const res = await fetch('{{ route('profile.updateField', 'phone_number') }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ phone_number: this.phoneNumber }),
                    });

                    if (!res.ok) {
                        const data = await res.json();
                        throw new Error(data.message || 'Failed to save phone number');
                    }

                    // Success
                    $dispatch('close-modal', 'phone-prompt');
                    
                    // Tell the correct inquire button to open its language picker
                    $dispatch('phone-saved', { productId: this.pendingProductId });

                } catch (err) {
                    this.error = err.message;
                } finally {
                    this.loading = false;
                }
            }
        }"
        class="p-6"
    >
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 rounded-full bg-[#2563EB]/10 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
            </div>
            <div>
                <h3 class="font-serif text-xl font-bold text-[#0D0D0B]">One more step</h3>
                <p class="text-sm text-[#6B6B6B]">Add your phone number to continue.</p>
            </div>
        </div>

        <p class="text-sm text-[#6B6B6B] mb-6">
            Your phone number helps the owner respond to you faster via Telegram.
        </p>

        <div class="space-y-4">
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="tel" id="phone" x-model="phoneNumber" x-ref="phoneInput" @keydown.enter="save()"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#2563EB] focus:ring-[#2563EB] sm:text-sm"
                       placeholder="e.g. 012345678">
                <p x-show="error" x-text="error" class="mt-2 text-sm text-red-600" x-cloak></p>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" @click="$dispatch('close-modal', 'phone-prompt')"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2563EB]">
                    Cancel
                </button>
                <button type="button" @click="save()" :disabled="loading"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-[#2563EB] border border-transparent rounded-lg hover:bg-[#1d4ed8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2563EB] disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg x-show="loading" class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24" x-cloak>
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    Save & Continue
                </button>
            </div>
        </div>
    </div>
</x-modal>

