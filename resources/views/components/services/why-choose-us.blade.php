{{-- WHY CHOOSE US --}}
<section
    class="scroll-mt-32 md:scroll-mt-36 relative py-12 sm:py-16 md:py-24 bg-[#1a1a2e] overflow-hidden font-['Kantumruy_Pro',sans-serif]"
    id="why">
    {{-- Decorative blobs (kept as CSS-in-HTML since they are purely decorative) --}}
    <div class="absolute w-96 h-96 rounded-full bg-[#305CDE] opacity-10 -top-24 -left-24 blur-3xl pointer-events-none"
        aria-hidden="true"></div>
    <div class="absolute w-72 h-72 rounded-full bg-[#d85a30] opacity-5 bottom-0 right-0 blur-3xl pointer-events-none"
        aria-hidden="true"></div>
    <div class="relative z-10 max-w-[1200px] mx-auto px-4 sm:px-6 md:px-8 w-full">
        <p class="inline-block text-[#305CDE] text-[clamp(0.875rem,1.1vw,1rem)] font-semibold mb-3 sm:mb-4">
            ហេតុអ្វីជ្រើសរើស Vin Copy Print Scan</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $reasons = [
                    [
                        'num' => '01',
                        'title' => 'ជំនាញច្បាស់លាស់',
                        'desc' =>
                            'បុគ្គលិករបស់យើងរីករាយក្នុងការជួយអ្នកជានិច្ច។អ្នកអាចប្រាប់ពីតម្រូវការរបស់អ្នកទៅកាន់ពួកគាត់បាន, នោះពួកគាត់នឹងធ្វើការព្រីនឬកូពីជូនអ្នក។',
                    ],
                    [
                        'num' => '02',
                        'title' => 'សេវាកម្មរហ័សក្នុងហាង',
                        'desc' =>
                            'ឯកសាររបស់អ្នកនឹងរួចរាលល់ភ្លាមៗមិនឲ្យលោកអ្នករងចាំយូរ។ក្នុងករណីលោកអ្នកមានឯកសារច្រើនច្បាប់, ពួកយើងនឹងធ្វើឲ្យអស់ពីលទ្ធភាពជូនលោកអ្នក។',
                    ],
                    [
                        'num' => '03',
                        'title' => 'ធានាគុណភាព',
                        'desc' =>
                            'រាល់ការបោះពុម្ពទាំងអស់មានភាពច្បាស់ ស្អាត និងដូចច្បាប់ដើម។ ប្រសិនបើគុណភាពនៃការព្រីនឬ កូពីមិនដូចនូវអ្វីដែលអ្នកចង់បាន, ពួកយើងនឹងធ្វើការព្រីនឬកូពីថ្មីជូនភ្លាមៗ។',
                    ],
                    [
                        'num' => '04',
                        'title' => 'ផលិតផលមានគុណភាព និងការធានាច្បាស់លាស់ពីក្រុមហ៊ុនផ្ទាល់',
                        'desc' =>
                            'យើងមានលក់ទឹកថ្នាំ OEM ព្រមជាមួយជម្រើសដែលអាចប្រើជំនួសបានដែលមានគុណភាព ដូច្នេះអ្នកអាចជ្រើសរើសដោយមានទំនុកចិត្ត។',
                    ],
                    [
                        'num' => '05',
                        'title' => 'អាចធ្វើការតេស្តសាកល្បងសិនមុនពេលអ្នកទិញ',
                        'desc' =>
                            'រាល់ម៉ូដែលម៉ាស៊ីនបោះពុម្ពដែលដាក់តាំងបង្ហាញនៅហាងយើងគឺលោកអ្នកអាចធ្វើការតេស្តសាកល្បងសិនមុនពេលសម្រេចចិត្តទិញ។',
                    ],
                    [
                        'num' => '06',
                        'title' => 'ម៉ាស៊ីនព្រីន កូពី ទឹកថ្នាំ និងក្រដាសតម្លៃល្អជាងទីផ្សារ',
                        'desc' =>
                            'យើងខ្ញុំក៏មានលក់ម៉ាស៊ីនបោះពុម្ព ម៉ាស៊ីនថតចម្លង និងសម្ភារៈដែលតម្លៃទាបជាងទីផ្សារជាមួួយនឹងគុណភាព។',
                    ],
                ];
            @endphp
            @foreach ($reasons as $reason)
                <div class="group w-full">
                    <div
                        class="text-3xl font-bold text-white/10 font-['Fraunces',serif] mb-4 group-hover:text-[#ffffff] transition-colors duration-300">
                        {{ $reason['num'] }}
                    </div>
                    <h3 class="text-white font-semibold text-[clamp(1.05rem,1.4vw+0.5rem,1.25rem)] leading-[1.6] mb-2">
                        {{ $reason['title'] }}</h3>
                    <p class="text-white/80 text-[clamp(0.875rem,1.05vw,0.95rem)] leading-[1.75]">{{ $reason['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
