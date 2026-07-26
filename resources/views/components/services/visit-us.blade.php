<section class="scroll-mt-32 md:scroll-mt-36 py-12 sm:py-16 md:py-20 bg-white font-['Kantumruy_Pro',sans-serif]"
    id="visit">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 md:px-8 w-full">
        <p class="inline-block text-[#305CDE] text-[clamp(0.875rem,1.1vw,1rem)] font-semibold mb-3 sm:mb-4">ទីតាំង</p>
        <h2
            class="font-sans text-[clamp(1.5rem,3vw+0.5rem,2.75rem)] text-[#1a1a2e] tracking-normal leading-[1.65] mb-6 sm:mb-8">
            មកកាន់ហាងរបស់យើង</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            {{-- Map --}}
            <div class="rounded-2xl overflow-hidden border border-[#e8ede9] shadow-sm aspect-[4/3] w-full"
                aria-label="Store location map">
                <iframe src="{{ config('services.google_maps.embed_url') }}" class="w-full h-full" style="border:0;"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            {{-- Info cards --}}
            <div class="flex flex-col gap-5 w-full">
                {{-- Address --}}
                <div class="flex gap-4 items-start bg-[#f8f9fa] rounded-xl p-4 sm:p-5">
                    <div
                        class="w-10 h-10 rounded-lg bg-[#e6f4ec] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <x-icons.map-pin class="stroke-[#1a6b4a]" />
                    </div>
                    <div>
                        <h4 class="font-semibold text-[#1a1a2e] text-[clamp(0.875rem,1.1vw,1rem)] mb-1">អាស័យដ្ឋាន</h4>
                        <p class="text-[#1a1a2e]/70 text-[clamp(0.875rem,1.05vw,0.95rem)] leading-[1.75]">
                            ភូមិ០៣, សង្កាត់០២, ក្រុងព្រះសីហនុ, ខេត្តព្រះសីហនុ, កម្ពុជា
                        </p>
                        <a href="{{ config('services.google_maps.link') }}" target="_blank" rel="noopener"
                            class="inline-block mt-2 text-[#305CDE] text-sm font-semibold hover:underline">
                            មើលទីតាំងនៅលើ Google Maps
                        </a>
                    </div>
                </div>
                {{-- Opening Hours --}}
                <div class="flex gap-4 items-start bg-[#f8f9fa] rounded-xl p-5">
                    <div
                        class="w-10 h-10 rounded-lg bg-[#e6f4ec] flex items-center justify-center flex-shrink-0 mt-0.5">
                        <x-icons.clock class="stroke-[#1a6b4a]" />
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-[#1a1a2e] text-sm mb-1">ម៉ោងបើកដំណើរការអាជីវកម្ម</h4>
                        <table class="w-full text-sm" aria-label="Opening hours">
                            <tbody>
                                <tr class="border-b border-[#e8ede9]">
                                    <td class="py-2 text-[#1a1a2e]/60 font-medium">ច័ន្ទ-សៅរ៏</td>
                                    <td class="py-2 text-[#1a1a2e] font-semibold text-right">8:00 ព្រឹក - 5:30 ល្ងាច
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-[#1a1a2e]/60 font-medium">អាទិត្យ</td>
                                    <td class="py-2 text-red-500 font-semibold text-right">បិទ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
