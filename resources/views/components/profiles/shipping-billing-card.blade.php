<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
    <h3 class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-900 bg-gray-50/50">
        Shipping &amp; Billing</h3>

    {{-- Row 3: Shipping Address --}}
    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row gap-4">
        <div class="md:w-1/3 text-sm font-medium text-gray-700 md:mt-1">Default Address</div>
        <div class="flex-1 text-sm text-gray-900 leading-relaxed">
            <template x-if="defaultAddressHtml">
                <div x-html="defaultAddressHtml"></div>
            </template>
            <template x-if="!defaultAddressHtml">
                <span class="text-gray-400 italic">No address saved</span>
            </template>
        </div>
        <div class="md:text-right">
            <button type="button"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors md:mt-1"
                onclick="openModal('modal-address')"><span
                    x-text="defaultAddressHtml ? 'Edit' : 'Add'"></span></button>
        </div>
    </div>

    {{-- Row 4: Language & Currency --}}
    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row gap-4">
        <div class="md:w-1/3 text-sm font-medium text-gray-700 md:mt-1">Preferences</div>
        <div class="flex-1 text-sm text-gray-900 leading-relaxed">
            English (US)<br>
            USD ($)
        </div>
        <div class="md:text-right">
            <button type="button"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors md:mt-1">Edit</button>
        </div>
    </div>
</div>
