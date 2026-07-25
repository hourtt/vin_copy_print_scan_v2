@props(['user' => null])

<div class="font-noto-khmer grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <x-form.input name="first_name" label="First Name" :required="true" :value="old('first_name', $user?->first_name)" />
    <x-form.input name="name" label="Last Name" :required="true" :value="old('name', $user?->last_name)" />
    
    <div class="md:col-span-2">
        <x-form.input type="email" name="email" label="Email" :required="true" :value="old('email', $user?->email)" />
    </div>
    
    <div class="md:col-span-2">
        <x-form.input type="tel" name="phone_number" label="Phone Number" :required="true" :value="old('phone_number', $user?->phone_number)" />
    </div>
    
    <div class="md:col-span-2">
        <x-form.input name="address" label="Address" :required="true" :value="old('address', $user?->address)" />
    </div>
    
    <x-form.input name="city" label="City" :required="true" :value="old('city', $user?->city)" />
    <x-form.input name="state_province" label="State / Province" :required="true" :value="old('state_province', $user?->state)" />
    <x-form.input name="zip_code" label="Zip Code" :required="true" :value="old('zip_code', $user?->zip_code)" />
    
    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-1">Order Notes (Optional)</label>
        <textarea name="order_notes" rows="3" class="form-input">{{ old('order_notes') }}</textarea>
    </div>
</div>
