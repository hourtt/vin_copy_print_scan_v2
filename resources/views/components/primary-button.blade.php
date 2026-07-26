<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' => 'inline-flex items-center px-4 py-2 bg-[#305CDE] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#264ca3] focus:bg-[#264ca3] active:bg-[#203e8a] focus:outline-none focus:ring-2 focus:ring-[#305CDE] focus:ring-offset-2 transition ease-in-out duration-150',
    ]) }}>
    {{ $slot }}
</button>
