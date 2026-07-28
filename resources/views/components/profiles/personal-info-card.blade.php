<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
    <h3 class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-900 bg-gray-50/50">
        Personal Information</h3>

    {{--  Row 1: Full Name (inline edit)  --}}
    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row gap-4"
        data-inline-field="name">

        <div class="md:w-1/3 text-sm font-medium text-gray-700 md:mt-1">Full Name</div>

        {{-- Display slot: shown by default --}}
        <div class="flex-1 text-sm text-gray-900 ie-display flex justify-between items-start w-full">
            <span id="ie-display-name" class="mt-1">{{ Auth::user()->first_name }}
                {{ Auth::user()->last_name }}</span>
            <button type="button"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors mt-1"
                onclick="ieOpen('name')">Edit</button>
        </div>

        {{-- Editor slot: hidden by default --}}
        <div class="flex-1 ie-editor w-full" id="ie-editor-name" style="display:none;">
            <form method="POST" action="{{ route('profile.update') }}"
                class="flex flex-col gap-4 w-full" data-field="name">
                @csrf
                @method('PATCH')
                <input type="hidden" name="inline_field" value="name">
                <div class="flex flex-col sm:flex-row gap-4 w-full">
                    <div class="flex-1 flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-gray-700" for="ie-first-name">First
                            Name</label>
                        <input @class([
                            'w-full px-3 py-2 border rounded-md text-sm transition-colors',
                            'border-red-500 focus:ring-red-500 focus:border-red-500 focus:ring-2' => $errors->has(
                                'first_name'),
                            'border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500' => !$errors->has(
                                'first_name'),
                        ]) id="ie-first-name" type="text"
                            name="first_name"
                            value="{{ old('first_name', Auth::user()->first_name) }}"
                            autocomplete="given-name" required>
                        @error('first_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex-1 flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-gray-700" for="ie-last-name">Last
                            Name</label>
                        <input @class([
                            'w-full px-3 py-2 border rounded-md text-sm transition-colors',
                            'border-red-500 focus:ring-red-500 focus:border-red-500 focus:ring-2' => $errors->has(
                                'last_name'),
                            'border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500' => !$errors->has(
                                'last_name'),
                        ]) id="ie-last-name" type="text"
                            name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}"
                            autocomplete="family-name" required>
                        @error('last_name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-2">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors">Save</button>
                    <button type="button"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors"
                        onclick="ieClose('name')">Cancel</button>
                </div>
            </form>
        </div>

    </div>

    {{--  Row 2: Contact Details (inline edit)  --}}
    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row gap-4"
        data-inline-field="email">

        <div class="md:w-1/3 text-sm font-medium text-gray-700 md:mt-1">Contact Details</div>

        {{-- Display slot: shown by default --}}
        <div class="flex-1 text-sm text-gray-900 ie-display flex justify-between items-start w-full">
            <div>
                <div id="ie-display-email" class="mt-1">{{ Auth::user()->email }}</div>
                <div class="text-sm text-gray-500 mt-1">Phone not added</div>
            </div>
            <button type="button"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors mt-1"
                onclick="ieOpen('email')">Edit</button>
        </div>

        {{-- Editor slot: hidden by default --}}
        <div class="flex-1 ie-editor w-full" id="ie-editor-email" style="display:none;">
            <form method="POST" action="{{ route('profile.update') }}"
                class="flex flex-col gap-4 w-full" data-field="email">
                @csrf
                @method('PATCH')
                <input type="hidden" name="inline_field" value="email">
                <div class="w-full sm:max-w-md">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-medium text-gray-700" for="ie-email">Email
                            Address</label>
                        <input @class([
                            'w-full px-3 py-2 border rounded-md text-sm transition-colors',
                            'border-red-500 focus:ring-red-500 focus:border-red-500 focus:ring-2' => $errors->has(
                                'email'),
                            'border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500' => !$errors->has(
                                'email'),
                        ]) id="ie-email" type="email"
                            name="email" value="{{ old('email', Auth::user()->email) }}"
                            autocomplete="email" required>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex items-center gap-3 mt-2">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors">Save</button>
                    <button type="button"
                        class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors"
                        onclick="ieClose('email')">Cancel</button>
                </div>
            </form>
        </div>

    </div>

</div>
