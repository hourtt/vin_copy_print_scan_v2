<footer class="bg-white border-t border-[var(--ink)]/10">
    <div class="max-w-6xl mx-auto px-6 py-12 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-10">

        {{-- Brand --}}
        <div>
            <div class="flex items-center gap-2 mb-4 text-[var(--ink)]">
                <img src="{{ asset('storage/images/logo-icon-only.webp') }}" alt="Logo" width="70"
                    class="rounded-xl" loading="lazy">
                <span class="font-bold text-xl">Vin Copy Print Scan</span>
            </div>
            <p class="text-sm leading-relaxed text-[var(--ink-muted)] max-w-[300px]">
                Your trusted partner for comprehensive printing, copying, scanning, and binding solutions in
                Sihanoukville. Quality, and reliability guaranteed.
            </p>
        </div>

        {{-- Contact --}}
        <div class="sm:text-right">
            <h4 class="font-semibold text-sm text-[var(--ink)] mb-5">Contact Us</h4>
            <ul class="space-y-3 text-sm text-[var(--ink-muted)]">
                <li>
                    <a href="mailto:vincopy168@gmail.com"
                        class="inline-flex items-center sm:justify-end gap-2 hover:text-[var(--ink)] transition-colors">
                        <svg class="shrink-0" width="14" height="14" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                            <polyline points="22,6 12,13 2,6" />
                        </svg>
                        vincopy168@gmail.com
                    </a>
                </li>
                <li>
                    <a href="tel:+85515693334"
                        class="inline-flex items-center sm:justify-end gap-2 hover:text-[var(--ink)] transition-colors">
                        <svg class="shrink-0" width="14" height="14" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path
                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                        +855 15 693 334
                    </a>
                </li>
                <li>
                    <a href="https://t.me/Vincopy" target="_blank" rel="noopener"
                        class="inline-flex items-center sm:justify-end gap-2 hover:text-[var(--ink)] transition-colors">
                        <svg class="shrink-0" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M21.05 3.64 2.78 10.77c-1.25.5-1.24 1.2-.23 1.51l4.69 1.47 1.8 5.62c.22.6.39.84.79.84.36 0 .54-.16.78-.4l1.86-1.81 4.43 3.27c.81.45 1.4.22 1.6-.75l2.89-13.6c.3-1.21-.46-1.75-1.34-1.28zM8.96 13.94l8.56-5.41c.4-.25.77-.11.47.16l-7.05 6.37-.27 3.04-1.71-4.16z" />
                        </svg>
                        Telegram
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/obito.ze.5" target="_blank" rel="noopener"
                        class="inline-flex items-center sm:justify-end gap-2 hover:text-[var(--ink)] transition-colors">
                        <svg class="shrink-0" width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.23.2 2.23.2v2.46H15.2c-1.24 0-1.63.78-1.63 1.57v1.88h2.78l-.44 2.91h-2.34V22c4.78-.76 8.43-4.92 8.43-9.94z" />
                        </svg>
                        Facebook
                    </a>
                </li>
            </ul>
            <p class="mt-6 text-xs text-[var(--ink-muted)]">
                © {{ date('Y') }} Vin Copy Print Scan. All rights reserved.
            </p>
        </div>

    </div>
</footer>
