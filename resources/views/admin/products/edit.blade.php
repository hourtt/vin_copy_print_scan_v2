<x-admin-layout>
    <x-slot name="header">Edit Product</x-slot>

    <form method="POST" action="{{ route('admin.products.update', $product) }}"
          enctype="multipart/form-data"
          x-data="{
              newPreviews: [],
              specs: {{ $product->specifications ? json_encode(collect($product->specifications)->map(fn($v,$k) => ['key'=>$k,'value'=>$v])->values()) : '[]' }},
              addSpec() { this.specs.push({ key: '', value: '' }); },
              removeSpec(i) { this.specs.splice(i, 1); },
              handleNewImages(files) {
                  Array.from(files).forEach(file => {
                      const reader = new FileReader();
                      reader.onload = e => this.newPreviews.push({ url: e.target.result, name: file.name });
                      reader.readAsDataURL(file);
                  });
              },
              setPrimary(productId, imageId, csrfToken) {
                  fetch(`/admin/products/${productId}/images/${imageId}/set-primary`, {
                      method: 'POST',
                      headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                  })
                  .then(r => r.json())
                  .then(() => window.location.reload());
              },
              deleteImage(productId, imageId, csrfToken) {
                  if (!confirm('Delete this image?')) return;
                  fetch(`/admin/products/${productId}/images/${imageId}`, {
                      method: 'DELETE',
                      headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                  })
                  .then(() => window.location.reload());
              }
          }"
          class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm list-none">
                <p class="font-medium mb-1">Please fix the following errors:</p>
                <ul class="list-none list-inside space-y-0.5">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT: Main Info --}}
            <div class="lg:col-span-2 space-y-5">

                @include('admin.products.partials.edit.basic-info')

                @include('admin.products.partials.edit.specifications')

                @include('admin.products.partials.edit.current-gallery')

                @include('admin.products.partials.edit.new-images')

            </div>

            {{-- RIGHT: Meta / Actions --}}
            <div class="space-y-5">

                @include('admin.products.partials.edit.sidebar')

                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <a href="{{ route('admin.products.show', $product) }}"
                       class="block text-sm text-center text-indigo-600 hover:text-indigo-800 font-medium">
                        View Product Detail →
                    </a>
                </div>

            </div>
        </div>
    </form>
</x-admin-layout>
