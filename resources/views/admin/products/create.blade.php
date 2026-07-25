<x-admin-layout>
    <x-slot name="header">Add Product</x-slot>

    <form method="POST" action="{{ route('admin.products.store') }}"
          enctype="multipart/form-data"
          x-data="{
              previewImages: [],
              specs: {{ old('specifications') ? json_encode(collect(old('specifications'))->map(fn($v,$k) => ['key'=>$k,'value'=>$v])->values()) : '[]' }},
              addSpec() { this.specs.push({ key: '', value: '' }); },
              removeSpec(i) { this.specs.splice(i, 1); },
              handleImages(files) {
                  Array.from(files).forEach(file => {
                      const reader = new FileReader();
                      reader.onload = e => this.previewImages.push({ url: e.target.result, name: file.name });
                      reader.readAsDataURL(file);
                  });
              }
          }"
          class="space-y-6">
        @csrf

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm list-none">
                <p class="font-medium mb-1">Please fix the following errors:</p>
                <ul class="list-none list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT: Main Info --}}
            <div class="lg:col-span-2 space-y-5">

                @include('admin.products.partials.create.basic-info')

                @include('admin.products.partials.create.specifications')

                @include('admin.products.partials.create.image-upload')

            </div>

            {{-- RIGHT: Meta / Actions --}}
            <div class="space-y-5">

                @include('admin.products.partials.create.sidebar')

            </div>
        </div>
    </form>
</x-admin-layout>
