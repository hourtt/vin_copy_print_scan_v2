@props(['user' => null, 'addresses' => collect()])

<div x-data="{
    addresses: {{ $addresses->toJson() }},
    selectedAddressId: '',
    isNewAddress: true,
    form: {
        first_name: '{{ old('first_name', $user?->first_name) }}',
        last_name: '{{ old('name', $user?->last_name) }}',
        email: '{{ old('email', $user?->email) }}',
        phone_number: '{{ old('phone_number', $user?->phone_number) }}',
        address: '{{ old('address', $user?->address) }}',
        city: '{{ old('city', $user?->city) }}',
        state_province: '{{ old('state_province', $user?->state) }}',
        zip_code: '{{ old('zip_code', $user?->zip_code) }}'
    },
    selectAddress() {
        if (this.selectedAddressId === 'new' || this.selectedAddressId === '') {
            this.isNewAddress = true;
            this.form.phone_number = '';
            this.form.address = '';
            this.form.city = '';
            this.form.state_province = '';
            this.form.zip_code = '';
        } else {
            this.isNewAddress = false;
            let addr = this.addresses.find(a => a.id == this.selectedAddressId);
            if (addr) {
                this.form.phone_number = addr.phone_number || '';
                this.form.address = addr.address || '';
                this.form.city = addr.city || '';
                this.form.state_province = addr.state || '';
                this.form.zip_code = addr.zip_code || '';
            }
        }
        // Dispatch event so phone mask can update
        this.$dispatch('address-selected', this.form.phone_number);
    },
    init() {
        let defaultAddr = this.addresses.find(a => a.is_default);
        if (defaultAddr && '{{ old('address') }}' === '') {
            this.selectedAddressId = defaultAddr.id;
            this.selectAddress();
        } else if (this.addresses.length > 0 && '{{ old('address') }}' === '') {
            this.selectedAddressId = this.addresses[0].id;
            this.selectAddress();
        } else if (this.addresses.length > 0) {
            this.selectedAddressId = 'new';
        }
    }
}">

    @if($addresses->count() > 0)
        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Select a Saved Address</label>
            <select x-model="selectedAddressId" @change="selectAddress" class="form-input w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block p-2.5">
                @foreach($addresses as $address)
                    <option value="{{ $address->id }}">
                        {{ $address->address }}, {{ $address->city }} {{ $address->state }} {{ $address->zip_code }}
                        @if($address->is_default) (Default) @endif
                    </option>
                @endforeach
                <option value="new">+ Use a new address</option>
            </select>
        </div>
    @endif

    <div class="font-noto-khmer grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div>
            <label class="block text-sm font-medium mb-1">First Name <span class="text-red-500">*</span></label>
            <input type="text" name="first_name" x-model="form.first_name" required class="form-input w-full rounded-md border-gray-300">
        </div>
        
        <div>
            <label class="block text-sm font-medium mb-1">Last Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" x-model="form.last_name" required class="form-input w-full rounded-md border-gray-300">
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
            <input type="email" name="email" x-model="form.email" required class="form-input w-full rounded-md border-gray-300">
        </div>
        
        <div class="md:col-span-2" x-data="phoneMask(form.phone_number)" @address-selected.window="formatInitial($event.detail)">
            <label class="block text-sm font-medium mb-1">Phone Number <span class="text-red-500">*</span></label>
            <input type="tel" 
                x-model="displayPhone" 
                @input="formatPhone($event); form.phone_number = rawPhone" 
                required 
                class="form-input w-full rounded-md border-gray-300" 
                placeholder=" " 
                pattern="[0-9\s]+" 
                minlength="8" 
                maxlength="20" />
            <input type="hidden" name="phone_number" :value="rawPhone">
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1">Address <span class="text-red-500">*</span></label>
            <input type="text" name="address" x-model="form.address" required class="form-input w-full rounded-md border-gray-300">
        </div>
        
        <div>
            <label class="block text-sm font-medium mb-1">City <span class="text-red-500">*</span></label>
            <input type="text" name="city" x-model="form.city" required class="form-input w-full rounded-md border-gray-300">
        </div>
        
        <div>
            <label class="block text-sm font-medium mb-1">State / Province <span class="text-red-500">*</span></label>
            <input type="text" name="state_province" x-model="form.state_province" required class="form-input w-full rounded-md border-gray-300">
        </div>
        
        <div>
            <label class="block text-sm font-medium mb-1">Zip Code <span class="text-red-500">*</span></label>
            <input type="text" name="zip_code" x-model="form.zip_code" required class="form-input w-full rounded-md border-gray-300">
        </div>
        
        <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1">Order Notes (Optional)</label>
            <textarea name="order_notes" rows="3" class="form-input w-full rounded-md border-gray-300">{{ old('order_notes') }}</textarea>
        </div>

        <div class="md:col-span-2" x-show="isNewAddress" x-transition>
            <div class="flex items-center">
                <input type="checkbox" id="save_address" name="save_address" value="1"
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" checked>
                <label for="save_address" class="ml-2 block text-sm text-gray-900">
                    Save this address to my profile for future orders
                </label>
            </div>
        </div>
    </div>
</div>
