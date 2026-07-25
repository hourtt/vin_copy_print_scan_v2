<li class="p-6 flex flex-col sm:flex-row sm:items-center gap-6 hover:bg-gray-50/50 transition-colors">
    <div class="flex-shrink-0 w-24 h-24 sm:w-32 sm:h-32 border border-gray-100 rounded-lg overflow-hidden bg-gray-50">
        @if($item->product->image)
            <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-center object-cover" loading="lazy">
        @else
            <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">No Image</div>
        @endif
    </div>
    
    <div class="flex-1 flex flex-col justify-between">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">
                    <a href="#" class="hover:text-indigo-600 transition-colors">{{ $item->product->name }}</a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">{{ $item->product->category->name ?? 'Uncategorized' }}</p>
            </div>
            <p id="item-price-{{ $item->product->id }}" class="text-lg font-bold text-gray-900">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
        </div>
        
        <div class="mt-6 flex items-center justify-between">
            <form x-data="cartItemHandler({{ $item->quantity }}, {{ $item->product->id }})"
                x-ref="updateForm" action="{{ route('cart.update', $item->product->id) }}" method="POST" class="flex items-center"
                @submit.prevent="updateCart()">
                @csrf
                @method('PATCH')
                <div class="flex items-center border border-gray-200 rounded-full bg-white overflow-hidden shadow-sm h-9 relative">
                    
                    <!-- Loading Overlay inside Stepper -->
                    <div x-show="loading" class="absolute inset-0 bg-white/80 flex items-center justify-center z-10" style="display: none;">
                        <svg class="animate-spin h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </div>

                    <button type="button" 
                            class="w-9 h-full flex items-center justify-center text-gray-500 hover:bg-gray-50 focus:outline-none transition-colors"
                            :class="{ 'opacity-50 cursor-not-allowed': qty <= 1 || loading, 'hover:text-gray-900': qty > 1 && !loading }"
                            :disabled="qty <= 1 || loading"
                            @click="if(qty > 1 && !loading) { qty--; updateCart(); }">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path></svg>
                    </button>
                    
                    <input type="number" name="quantity" x-model.number="qty" min="1" 
                           class="w-10 h-full border-0 text-center text-sm font-medium text-gray-900 focus:ring-0 p-0 bg-transparent [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" 
                           :disabled="loading"
                           @change="if(qty >= 1 && !loading) updateCart();">
                           
                    <button type="button" 
                            class="w-9 h-full flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-gray-900 focus:outline-none transition-colors"
                            :disabled="loading"
                            @click="if(!loading) { qty++; updateCart(); }">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>
            </form>
            
            <div x-data="{ showConfirm: false }">
                <form x-ref="removeForm" action="{{ route('cart.remove', $item->product->id) }}" method="POST" @submit.prevent="showConfirm = true">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-800 transition-colors flex items-center group">
                        <svg class="w-4 h-4 mr-1 text-red-500 group-hover:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Remove
                    </button>
                </form>

                @include('cart.partials.remove-modal')
            </div>
        </div>
    </div>
</li>
