<section class="scroll-mt-32 md:scroll-mt-36 py-12 sm:py-16 md:py-20 bg-[#f8f9fa] font-['Kantumruy_Pro',sans-serif]" id="instore">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 md:px-8 w-full">
        <p class="inline-block text-[#305CDE] text-[clamp(0.875rem,1.1vw,1rem)] font-semibold mb-3 sm:mb-4">អញ្ជើញមកកាន់ហាង ហើយយើងនឹងរៀបចំជូន</p>
        <h2
            class="font-sans text-[clamp(1.5rem,3vw+0.5rem,2.75rem)] text-[#1a1a2e] tracking-normal leading-[1.65] max-w-[560px] mb-4">
            សេវាកម្មក្នុងហាង</h2>
        <p class="text-[#1a1a2e]/70 text-[clamp(0.875rem,1.1vw,1rem)] leading-[1.75] max-w-xl mb-10 sm:mb-14">
            មិនមានម៉ាស៊ីនព្រីនផ្ទាល់ខ្លូននិងមិនចង់ចំណាយលុយទៅទិញម៉ាស៊ីនទាំងនោះមែនទេ?គ្មានបញ្ហា, ពួកយើងអាចផ្តល់សេវាកម្មក្នុងការកូពី ព្រីន និងស្កេនជូនលោកអ្នក។
        </p>
        @php
            $services = [
                [
                    'id' => 'copy',
                    'title' => 'សេវាកម្មថតចម្លង និងបោះពុម្ព',
                    'desc' => 'ត្រូវការចម្លងជាបន្ទាន់មែនទេ? យកច្បាប់ដើមរបស់អ្នកមក យើងនឹងថតចម្លងជូនជាសខ្មៅ ឬកូល័រ ចាប់ពី ១ ដល់ ១០០០សន្លឹក។',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />',
                    'icon_bg' => 'bg-[#d1fae5]',
                    'icon_stroke' => 'stroke-[#065f46]',
                    'items' => [
                        'ការថតចម្លងស-ខ្មៅ និងពណ៌ពេញ',
                        'ទំហំ A4, A3 ពង្រីកឬបង្រួមតាមតម្រូវការ',
                        'ថតចម្លងសងខាង (Duplex) ដោយមិនគិតថ្លៃបន្ថែម',
                        'បញ្ចុះតម្លៃសម្រាប់ការបញ្ជាទិញចាប់ពី ៥០០ សន្លឹកឡើងទៅ',
                        'មកផ្ទាល់ឬទំនាក់ទំនងប្រាប់ទុកមុនសម្រាប់ការងារប្រញាប់'
                    ],
                    'btn_text' => 'អញ្ជើញមកថ្ងៃនេះ',
                    'btn_url' => '#visit',
                ],
                [
                    'id' => 'try',
                    'title' => 'តេស្តសាកល្បងមុនពេលអ្នកទិញ',
                    'desc' => 'មិនប្រាកដថាម៉ាស៊ីនបោះពុម្ពមួយណាស័ក្តិសមសម្រាប់អ្នកមែនទេ? មកកាន់ហាងរបស់យើង ហើយសាកល្បងជាមួយម៉ូដែលម៉ាស៊ីនព្រីនណាមួយដោយផ្ទាល់។ បុគ្គលិករបស់យើងនឹងបោះពុម្ពសាកល្បង ដើម្បីឱ្យអ្នកអាចវាយតម្លៃគុណភាពផ្ទាល់ភ្នែកបាន។',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />',
                    'icon_bg' => 'bg-[#fee2d5]',
                    'icon_stroke' => 'stroke-[#9a3412]',
                    'items' => [
                        'ការបង្ហាញផ្ទាល់សម្រាប់គ្រប់ម៉ូដែលទាំងអស់',
                        'ប្រៀបធៀបគុណភាពម៉ាស៊ីនទន្ទឹមគ្នា',
                        'ផ្តល់ជាយោបល់ពីអ្នកជំនាញស្របតាមតម្រូវការបោះពុម្ពរបស់អ្នក'
                    ],
                    'btn_text' => 'ស្វែងរកហាងរបស់យើង',
                    'btn_url' => '#visit',
                ]
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($services as $service)
                <div class="bg-white rounded-2xl border border-[#e8ede9] p-5 sm:p-6 md:p-8 flex flex-col hover:shadow-md transition-shadow duration-200">
                    <div class="mb-6">
                        <div class="w-12 h-12 rounded-xl {{ $service['icon_bg'] }} flex items-center justify-center mb-5">
                            <svg class="w-6 h-6 {{ $service['icon_stroke'] }} stroke-[1.8]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                {!! $service['icon'] !!}
                            </svg>
                        </div>
                        <h3 class="font-sans text-[clamp(1.15rem,1.8vw+0.5rem,1.4rem)] font-bold text-[#1a1a2e] leading-[1.6] mb-3">{{ $service['title'] }}</h3>
                        <p class="text-[#1a1a2e]/70 text-[clamp(0.875rem,1.05vw,0.95rem)] leading-[1.75]">{{ $service['desc'] }}</p>
                    </div>
                    <ul class="flex flex-col gap-3 flex-1">
                        @foreach ($service['items'] as $item)
                            <li class="flex items-start gap-3 text-[clamp(0.875rem,1.05vw,0.95rem)] leading-[1.7] text-[#1a1a2e]/80">
                                <x-icons.check class="w-4 h-4 mt-1 shrink-0 stroke-[#305CDE] stroke-2" />
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-6 pt-5 border-t border-[#e8ede9]">
                        <a href="{{ $service['btn_url'] }}" class="inline-flex items-center gap-2 text-[#1a1a2e] font-semibold text-sm hover:gap-3 transition-all duration-200">
                            {{ $service['btn_text'] }}
                            <x-icons.arrow-right class="w-4 h-4" />
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
