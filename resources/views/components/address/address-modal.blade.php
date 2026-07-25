{{-- Multi-state address modal with Empty, List, and Form views --}}
<div x-data="addressManager()">
    <x-profiles.modal id="modal-address">
        <x-slot name="headerTitle">
            <span x-text="viewState === 'FORM' ? (editingId ? 'Edit Address' : 'Add New Address') : 'Delivery Addresses'"></span>
        </x-slot>

        <div class="font-['Kantumruy_Pro',sans-serif]">

            {{-- Success Toast --}}
            @if (session('status') === 'profile-updated' && session('inline_field') === 'address')
                <div class="flex items-center gap-2 px-4 py-2.5 mb-4 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Address updated successfully!
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any() && session('inline_field') === 'address')
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200">
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- UI States -->
            @include('components.address.partials.empty-state')
            @include('components.address.partials.list-state')
            @include('components.address.partials.form-state')
            @include('components.address.partials.delete-confirm-state')
        </div>
    </x-profiles.modal>
    
    <!-- Alpine.js Logic -->
    @include('components.address.partials.script')
</div>
