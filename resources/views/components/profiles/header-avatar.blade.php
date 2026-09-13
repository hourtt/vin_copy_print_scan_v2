<div x-data="{ previewImage: null }" class="w-full mb-10">
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <!-- Avatar and Form -->
        <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data"
            class="flex items-center gap-4">
            @csrf

            <div class="relative">
                <label for="profile_image" class="cursor-pointer block relative group">
                    <!-- Show Original or Thumbnail -->
                    <div x-show="!previewImage">
                        @if (Auth::user()->profile_image)
                            <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                                alt="{{ Auth::user()->first_name }}"
                                class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover shadow-sm group-hover:opacity-75 transition">
                        @else
                            <div
                                class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-[#305CDE] flex items-center justify-center text-white text-2xl font-bold group-hover:opacity-75 transition uppercase">
                                {{ substr(Auth::user()->first_name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <!-- Show Selected Preview -->
                    <div x-show="previewImage" style="display: none;">
                        <img :src="previewImage"
                            class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover shadow-sm group-hover:opacity-75 transition">
                    </div>

                    <!-- Pencil Icon Overlay -->
                    <div
                        class="absolute bottom-0 right-0 bg-white p-1.5 rounded-full shadow border border-gray-200 text-gray-500 group-hover:text-[#305CDE] transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </div>
                </label>

                <!-- Hidden Input with Alpine @change listener -->
                <input id="profile_image" name="image" type="file" accept="image/*" class="hidden" x-ref="avatar"
                    @change="
                    const file = $refs.avatar.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => { previewImage = e.target.result; };
                        reader.readAsDataURL(file);
                    }
                " />
            </div>

            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->first_name }}
                    {{ Auth::user()->last_name }}</h2>
                <p class="text-sm text-gray-500">Authenticated via Web</p>

                <!-- Dynamic Action Buttons -->
                <div x-show="previewImage" style="display: none;" class="mt-3 flex space-x-2">
                    <button type="button" @click="previewImage = null; $refs.avatar.value = null;"
                        class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#305CDE] focus:ring-offset-2 transition ease-in-out duration-150">
                        Cancel
                    </button>
                    <button type="submit"
                        class="inline-flex items-center px-3 py-1.5 bg-[#305CDE] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-[#305CDE] focus:ring-offset-2 transition ease-in-out duration-150">
                        Save
                    </button>
                </div>
            </div>
        </form>

        <!-- Toast Messages -->
        <div class="flex flex-col items-end gap-2 mt-4 sm:mt-0">
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                    class="flex items-center px-4 py-2 text-sm text-gray-800 bg-white rounded-md shadow border border-gray-200">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                    class="flex items-center px-4 py-2 text-sm text-gray-800 bg-white rounded-md shadow border border-gray-200">
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif
        </div>
    </div>
</div>
