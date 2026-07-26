            <!-- VIEW 3: FORM STATE -->
            <div x-show="viewState === 'FORM'" x-cloak>
                <form @submit.prevent="saveAddress()">
                    <div class="space-y-4">
                        {{-- Phone Number --}}
                        <div class="relative w-full">
                            <input type="tel" name="phone_number" placeholder=" "
                            x-model="formData.phone_number" required
                            pattern="[0-9\+\-\s]+" minlength="8" maxlength="20"
                            @input="formatPhone($event)"
                            class="block px-3 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 peer" />
                            <label
                                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-3 bg-white px-1 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
                                Phone Number
                            </label>
                        </div>

                        {{-- Street Address --}}
                        <div class="relative w-full">
                            <input type="text" name="address" placeholder=" " required x-model="formData.address"
                                minlength="5" maxlength="255"
                                class="block px-3 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 peer" />
                            <label
                                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-3 bg-white px-1 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
                                Street Address
                            </label>
                        </div>

                        {{-- City + State row --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div class="relative w-full">
                                <input type="text" name="city" placeholder=" " required
                                    x-model="formData.city" minlength="2" maxlength="100"
                                    class="block px-3 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 peer" />
                                <label
                                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-3 bg-white px-1 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
                                    City
                                </label>
                            </div>
                            <div class="relative w-full">
                                <input type="text" name="state" placeholder=" " required
                                    x-model="formData.state" minlength="2" maxlength="100"
                                    class="block px-3 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 peer" />
                                <label
                                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-3 bg-white px-1 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
                                    State
                                </label>
                            </div>
                        </div>

                        {{-- Zip Code --}}
                        <div class="relative w-full" style="max-width: 180px;">
                            <input type="text" name="zip_code" placeholder=" " required
                                x-model="formData.zip_code" maxlength="10"
                                class="block px-3 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-white rounded-md border border-gray-300 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 peer" />
                            <label
                                class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-3 bg-white px-1 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">
                                Zip Code
                            </label>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between pt-4 border-t border-gray-100">
                        <button type="button" @click="goBack()"
                            class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors focus:outline-none rounded-md hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back
                        </button>

                        <div class="flex items-center gap-3">
                            <button type="button"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
                                @click="closeModalAndReset()">Cancel</button>
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">Save
                                Address</button>
                        </div>
                    </div>
                </form>
            </div>
