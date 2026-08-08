<div x-data="{
    originalImage: '{{ Auth::user()->profile_image ? Storage::url(Auth::user()->profile_image) : '' }}',
    previewImage: '',
    showMenu: false,
    get hasPendingUpload() { return this.previewImage !== ''; },
    handleFileSelect(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
            this.previewImage = e.target.result;
        };
        reader.readAsDataURL(file);
    },
    cancelUpload() {
        this.previewImage = '';
        this.$refs.fileInput.value = '';
    }
}" class="w-full mb-10">

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

        <!-- Left Side: Avatar and Info -->
        <div class="flex flex-col sm:flex-row sm:items-center gap-6">
            <!-- Avatar Container -->
            <div class="relative">
                <div class="w-20 h-20 md:w-24 md:h-24 rounded-full flex items-center justify-center flex-shrink-0 overflow-hidden bg-indigo-100 text-indigo-600 relative group cursor-pointer"
                    @click="if(!originalImage && !previewImage) $refs.fileInput.click()">

                    <!-- Image / Initials -->
                    <template x-if="previewImage || originalImage">
                        <img :src="previewImage || originalImage" alt="Profile Image" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!previewImage && !originalImage">
                        <span class="text-3xl font-bold uppercase"
                            x-text="'{{ substr(Auth::user()->first_name, 0, 1) }}'">
                        </span>
                    </template>

                    <!-- Overlay (for empty state) -->
                    <template x-if="!originalImage && !previewImage">
                        <div
                            class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                    </template>
                </div>

                <!-- Populated State: Pencil Icon Badge -->
                <template x-if="(originalImage || previewImage) && !hasPendingUpload">
                    <div class="absolute bottom-0 right-0 z-10">
                        <button type="button" @click="showMenu = !showMenu" @click.away="showMenu = false"
                            class="bg-white rounded-full p-1.5 shadow border border-gray-200 text-gray-600 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>

                        <!-- Context Menu -->
                        <div x-show="showMenu" x-transition.opacity
                            class="absolute top-8 right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-100 z-20 overflow-hidden ">
                            <button type="button" @click="$refs.fileInput.click(); showMenu = false"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                Upload new image
                            </button>
                            <form action="{{ route('image.destroy') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Remove image
                                </button>
                            </form>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Info / Pending Actions -->
            <div class="flex flex-col gap-2">
                <!-- Normal State (No pending upload) -->
                <template x-if="!hasPendingUpload">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->first_name }}
                            {{ Auth::user()->last_name }}</h2>
                    </div>
                </template>
                <!-- Pending State -->
                <template x-if="hasPendingUpload">
                    <div class="flex flex-col gap-2">
                        <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->first_name }}
                            {{ Auth::user()->last_name }}</h2>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" @click="$refs.uploadForm.submit()"
                                class="px-4 py-2 text-sm font-medium border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                            </button>
                            <button type="button" @click="cancelUpload()"
                                class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="button" @click="$refs.fileInput.click()"
                                class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Change
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Right Side: Toast Messages -->
        <div class="flex flex-col items-end gap-2 mt-4 sm:mt-0">
            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-4"
                    class="flex items-center px-4 py-2 text-sm text-gray-800 bg-white rounded-md shadow border border-gray-200"
                    role="alert">
                    <div
                        class="inline-flex items-center justify-center flex-shrink-0 w-5 h-5 text-green-500 bg-green-100 rounded mr-2">
                        <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                    </div>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-x-0"
                    x-transition:leave-end="opacity-0 translate-x-4"
                    class="flex items-center px-4 py-2 text-sm text-gray-800 bg-white rounded-md shadow border border-gray-200"
                    role="alert">
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif
        </div>
    </div>

    <!-- The actual form with the hidden input -->
    <form x-ref="uploadForm" action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data"
        class="hidden">
        @csrf
        <input x-ref="fileInput" type="file" name="image" accept="image/*" @change="handleFileSelect">
    </form>
</div>
