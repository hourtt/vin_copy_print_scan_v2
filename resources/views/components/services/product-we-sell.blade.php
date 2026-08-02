<section class="scroll-mt-32 md:scroll-mt-36 py-12 sm:py-16 md:py-20 bg-white font-['Kantumruy_Pro',sans-serif]" id="products">
    <div class="max-w-[1200px] mx-auto px-4 sm:px-6 md:px-8 w-full">
        {{-- Section header --}}
        <div class="mb-10 sm:mb-14 md:mb-16">
            <p class="inline-block text-[#305CDE] text-[clamp(0.875rem,1.1vw,1rem)] font-semibold mb-3 sm:mb-4">អ្វីដែលយើងលក់</p>
            <h2
                class="font-sans text-[clamp(1.5rem,3vw+0.5rem,2.75rem)] text-[#1a1a2e] tracking-normal leading-[1.65] max-w-[560px] mb-4">
                <span class="block pb-1 sm:pb-2">ពួកយើងមានលក់នូវ៖</span>
                <span class="block">ម៉ាស៊ីនព្រីន, កូពី, ទឹកថ្នាំ និងធូន័រគ្រប់ប្រភេទទៅតាមតម្រូវការរបស់លោកអ្នក។</span>
            </h2>
            <p class="text-[#1a1a2e]/70 text-[clamp(0.875rem,1.1vw,1rem)] leading-[1.75] max-w-xl">
                ស្វែងរកកាតាឡុកផលិតផលរបស់យើងតាមរយៈគេហទំព័រឬមកកាន់ហាងរបស់យើង
                ដើម្បីមើលម៉ូដែលនីមួយៗមុនពេលអ្នកទិញ។
            </p>
        </div>
        <div class="flex flex-col gap-24">
            @php
                $sections = [
                    [
                        'id' => 'printers',
                        'title' => 'ម៉ាស៊ីនបោះពុម្ពដែលត្រឹមត្រូវ<br>សម្រាប់គ្រប់តម្រូវការ។',
                        'subtitle' => '01 ម៉ាស៊ីនបោះពុម្ព',
                        'desc' => 'ពីម៉ាស៊ីនបោះពុម្ពខ្នាតតូចសម្រាប់ប្រើនៅផ្ទះ រហូតដល់ម៉ាស៊ីនប្រើប្រាស់ក្នុងការិយាល័យធំៗ យើងមានជម្រើសទាំងអស់ ព្រមជាមួយដំបូន្មានពីអ្នកជំនាញ ដើម្បីជួយអ្នកស្វែងរកម៉ូដែលដ៏ស័ក្តិសមបំផុត។',
                        'items' => [
                            'សម្រាប់ផ្ទះ & ការិយាល័យតូច ម៉ូដែលឡាស៊ែរនិងទឹកថ្នាំខ្នាតតូច ពីម៉ាកល្បីៗ',
                            'ការិយាល័យ & ក្រុមការងារ ម៉ាស៊ីនបោះពុម្ពល្បឿនលឿនសងខាង ដែលអាចធ្វើការព្រីនតាមរយៈខ្សែ LAN និង ឥតខ្សែបានផងដែរ។',
                            'រួមបញ្ចូលគ្នា បោះពុម្ព ស្កេន ថតចម្លង និងហ្វាក់ ក្នុងម៉ាស៊ីនតែមួយ',
                            'ខ្នាតធំ ទំហំ A3 និងធំជាងនេះ សម្រាប់ផ្ទាំងរូបភាព ប្លង់ និងបដា',
                        ],
                        'btn_text' => 'ស្វែងរកម៉ាស៊ីនបោះពុម្ព',
                        'btn_url' => route('products.printers.index'),
                        'icon' => 'printer',
                        'icon_label' => 'ឡាស៊ែរ ទឹកថ្នាំ រួមបញ្ចូលគ្នា',
                        'theme' => [
                            'bg' => 'bg-[#1a1a2e]',
                            'circle' => 'bg-[#305CDE] opacity-10',
                            'icon_bg' => 'bg-[#305CDE]/20',
                            'icon_class' => 'stroke-[#9fe1cb]',
                            'label_class' => 'text-white/50'
                        ],
                        'reverse' => false,
                        'secondary_btn' => null,
                    ],
                    [
                        'id' => 'toners',
                        'title' => 'បន្តការបោះពុម្ព<br>ដោយទំនុកចិត្ត។',
                        'subtitle' => '02 ទឹកថ្នាំ',
                        'desc' => 'យើងមានស្តុកប្រអប់ទឹកថ្នាំ OEM និងជម្រើសទឹកថ្នាំដែលអាចប្រើជំនួសបានដែលមានគុណភាពពស់ សម្រាប់ម៉ាកល្បីៗទាំងអស់។',
                        'items' => [
                            'ប្រអប់ទឹកថ្នាំ OEM HP, Canon, Epson, Brother, Samsung, Ricoh & ច្រើនទៀត',
                            'ទឹកថ្នាំប្រើជំនួសបាន គុណភាពត្រូវបានសាកល្បងត្រឹមត្រូវ ក្នុងតម្លៃទាបជាង OEM ឆ្ងាយ',
                            'ជម្រើសទិន្នផលខ្ពស់ បោះពុម្ពបានទំព័រច្រើនជាងមុន ក្នុងតម្លៃទាបក្នុងមួយទំព័រ',
                            'អាចរកបានភ្លាមៗ អញ្ជើញមកផ្ទាល់ ឬបញ្ជាទិញសម្រាប់ការដឹកជញ្ជូននៅថ្ងៃបន្ទាប់',
                        ],
                        'btn_text' => 'ទិញសម្ភារៈប្រើប្រាស់',
                        'btn_url' => route('products.toners.index'),
                        'icon' => 'toner',
                        'icon_label' => 'OEM និង អាចប្រើជំនួសបាន',
                        'theme' => [
                            'bg' => 'bg-[#305CDE]',
                            'circle' => 'bg-[#2a5a3a] opacity-40',
                            'icon_bg' => 'bg-white/15',
                            'icon_class' => 'stroke-white/80',
                            'label_class' => 'text-white/60'
                        ],
                        'reverse' => true,
                        'secondary_btn' => null,
                    ],
                    [
                        'id' => 'paper',
                        'title' => 'ក្រដាសសម្រាប់គ្រប់<br>ការងារបោះពុម្ព។',
                        'subtitle' => '03 ក្រដាស & សម្ភារៈបោះពុម្ព',
                        'desc' => 'ចាប់ពីក្រដាសថតចម្លងសម្រាប់ការិយាល័យប្រចាំថ្ងៃ រហូតដល់ក្រដាសរូបថតកម្រិតខ្ពស់ និងសម្ភារៈពិសេសៗ - យើងមានគ្រប់កម្រាស់ ប្រភេទផ្ទៃ និងទំហំ។',
                        'items' => [
                            'ក្រដាសថតចម្លង កម្រាស់ 75gsm និង 80gsm សម្រាប់ការប្រើប្រាស់ការិយាល័យប្រចាំថ្ងៃ',
                            'ក្រដាសគុណភាពខ្ពស់ ពណ៌សភ្លឺ 90-120gsm សម្រាប់ឯកសារផ្លូវការ',
                            'រូបថត & រលោង សម្រាប់បោះពុម្ពរូបថត និងទីផ្សារពណ៌រស់រវើក',
                            'សម្ភារៈពិសេស ស្លាក, កាត, ក្រដាសថ្លា, និងស្រោមសំបុត្រ',
                        ],
                        'btn_text' => 'ទិញក្រដាស',
                        'btn_url' => route('products.papers.index'),
                        'icon' => 'paper',
                        'icon_label' => 'A5 A4 A3 តម្រូវតាមទំហំ',
                        'theme' => [
                            'bg' => 'bg-[#f5f0e8]',
                            'circle' => 'bg-[#305CDE] opacity-10',
                            'icon_bg' => 'bg-black/8',
                            'icon_class' => 'stroke-[#6b5a3e]',
                            'label_class' => 'text-[#6b5a3e]/60'
                        ],
                        'reverse' => false,
                        'secondary_btn' => null,
                    ],
                ];
            @endphp

            @foreach ($sections as $section)
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    {{-- Visual --}}
                    <div class="relative {{ $section['theme']['bg'] }} rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-12 flex items-center justify-center min-h-[260px] sm:min-h-[320px] overflow-hidden {{ $section['reverse'] ? 'lg:order-2 order-1' : '' }}">
                        <div class="absolute w-80 h-80 rounded-full {{ $section['theme']['circle'] }} {{ $section['reverse'] ? '-bottom-16 -left-16' : '-top-20 -right-20' }}"></div>
                        <div class="relative z-10 flex flex-col items-center gap-5">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl {{ $section['theme']['icon_bg'] }} flex items-center justify-center">
                                <x-dynamic-component :component="'icons.' . $section['icon']" class="w-8 h-8 sm:w-10 sm:h-10 shrink-0 {{ $section['theme']['icon_class'] }} stroke-[1.6]" />
                            </div>
                            <span class="text-xs tracking-widest uppercase {{ $section['theme']['label_class'] }} text-center max-w-[200px]">{{ $section['icon_label'] }}</span>
                        </div>
                    </div>
                    
                    {{-- Content --}}
                    <div class="{{ $section['reverse'] ? 'lg:order-1 order-2' : '' }}">
                        <span class="text-xl tracking-[0.12em] uppercase text-[#305CDE] mb-3 block font-medium">{{ $section['subtitle'] }}</span>
                        <h2 class="font-sans text-[clamp(1.35rem,2.5vw+0.5rem,2.25rem)] text-[#1a1a2e] tracking-normal leading-[1.65] mb-4 sm:mb-6">{!! $section['title'] !!}</h2>
                        <p class="text-[#1a1a2e]/70 text-[clamp(0.875rem,1.1vw,1rem)] leading-[1.75] mb-6">{{ $section['desc'] }}</p>
                        <ul class="flex flex-col gap-3 mb-8">
                            @foreach ($section['items'] as $item)
                                <li class="flex gap-3 items-start text-[clamp(0.875rem,1.05vw,0.95rem)] leading-[1.7] text-[#1a1a2e]/80">
                                    <span class="mt-2 w-2 h-2 rounded-full bg-[#305CDE] flex-shrink-0"></span>
                                    <span>{{ $item }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ $section['btn_url'] }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#1a1a2e] text-white text-sm font-semibold rounded-xl hover:bg-[#2d2d4e] transition-colors duration-200">
                                {{ $section['btn_text'] }}
                                <x-icons.arrow-right class="w-4 h-4" />
                            </a>
                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
