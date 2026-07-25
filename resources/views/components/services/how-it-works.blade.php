{{-- HOW IT WORKS / ORDERING PROCESS --}}
<section class="relative py-12 sm:py-16 md:py-24 bg-[#111827] overflow-hidden font-['Kantumruy_Pro',sans-serif]" id="how-it-works">
    {{-- Decorative blobs --}}
    <div class="absolute w-72 h-72 rounded-full bg-[#305CDE] opacity-5 -top-16 right-0 blur-3xl pointer-events-none"
        aria-hidden="true"></div>

    <div class="relative z-10 max-w-[1200px] mx-auto px-4 sm:px-6 md:px-8 w-full">
        <p class="inline-block text-[#305CDE] text-[clamp(0.875rem,1.1vw,1rem)] font-medium mb-3 sm:mb-4">ការបញ្ជាទិញ</p>
        <h3
            class="font-sans font-bold text-[clamp(1.375rem,3vw+0.5rem,2.375rem)] text-white tracking-normal leading-[1.65] max-w-[560px] mb-10 sm:mb-14">
            ធ្វើការបញ្ជាទិញតាម៤ជំហានងាយៗ
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-0 relative">
            {{-- Connecting line (desktop only) --}}
            <div class="hidden lg:block absolute top-7 left-[12.5%] right-[12.5%] h-px bg-white/10 z-0"></div>

            @php
                $steps = [
                    [
                        'num' => '01',
                        'title' => 'ជ្រើសរើសផលិតផលដែលអ្នកចង់បញ្ជាទិញ',
                        'desc' =>
                            'ចូលមើលផលិតផលរបស់យើងខ្ញុំហើយជ្រើសរើសម៉ូដែលដែលសាកសមនឹងតម្រូវការរបស់អ្នក។',
                    ],
                    [
                        'num' => '02',
                        'title' => 'ធ្វើការកុម្ម៉ង់',
                        'desc' =>
                            'ចូលទៅកាន់ផ្នែកកុម្ម៉ង់ ហើយជ្រើសរើសជម្រើសដែលអ្នកចង់បាន។',
                    ],
                    [
                        'num' => '03',
                        'title' => 'រៀបចំទំនិញ',
                        'desc' =>
                            'ការបញ្ជាទិញរបស់អ្នកនឹងត្រូវបានដំណើរការ និងរៀបចំសម្រាប់ការដឹកជញ្ជូន ឬយកដោយផ្ទាល់។',
                    ],
                    [
                        'num' => '04',
                        'title' => 'ដឹកជញ្ជូនដល់ទីតាំង',
                        'desc' =>
                            'ប្រគល់ជូនដល់ទីតាំងដែលបានកុម្ម៉ង់ ក្នុងរយៈពេលដ៏ខ្លី។',
                    ],
                ];
            @endphp

            @foreach ($steps as $step)
                <div class="flex flex-col items-center text-center px-4 sm:px-5 relative z-10 group w-full">
                    <div
                        class="w-14 h-14 rounded-full bg-white/5 border border-white/15 flex items-center justify-center font-['Inter',sans-serif] text-lg font-bold text-[#305CDE] mb-5 group-hover:bg-[#305CDE] group-hover:border-[#305CDE] group-hover:text-white transition-all duration-200">
                        {{ $step['num'] }}
                    </div>
                    <h4 class="font-sans text-[clamp(1rem,1.2vw+0.25rem,1.15rem)] font-semibold text-white leading-[1.6] mb-2">
                        {{ $step['title'] }}
                    </h4>
                    <p class="text-[clamp(0.85rem,1vw,0.925rem)] text-white/60 leading-[1.75] font-sans">
                        {{ $step['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
