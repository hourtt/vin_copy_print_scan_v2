<nav x-data="{
        activeSection: 'products',
        sections: ['products', 'instore', 'visit', 'why', 'faq'],
        isScrolling: false,
        init() {
            if (window.location.hash) {
                const hash = window.location.hash.substring(1);
                if (this.sections.includes(hash)) {
                    this.activeSection = hash;
                }
            }
            const observer = new IntersectionObserver((entries) => {
                if (this.isScrolling) return; // Prevent scrollspy override during manual click
                entries.forEach(entry => {
                    if (entry.isIntersecting && entry.intersectionRatio >= 0.4) {
                        this.activeSection = entry.target.id;
                    }
                });
            }, { rootMargin: '-64px 0px 0px 0px', threshold: [0.4, 0.5] });
            
            this.sections.forEach(id => {
                const el = document.getElementById(id);
                if(el) observer.observe(el);
            });
        },
        scrollTo(id) {
            this.activeSection = id; // Instantly highlight clicked button
            this.isScrolling = true; // Pause observer temporarily
            
            const el = document.getElementById(id);
            if(el) {
                const navHeight = 130; // Approx height of both sticky headers
                const elementPosition = el.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.scrollY - navHeight;
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Re-enable observer after smooth scroll animation completes
                setTimeout(() => {
                    this.isScrolling = false;
                }, 800);
            } else {
                this.isScrolling = false;
            }
        }
    }" 
    class="sticky top-[64px] lg:top-[68px] z-40 bg-white/95 backdrop-blur-sm border-b border-[#e8ede9] shadow-sm font-['Kantumruy_Pro',sans-serif] transition-all duration-200" aria-label="Page sections">
    <div class="max-w-[1200px] mx-auto w-full">
        <div class="flex flex-nowrap justify-start md:justify-center overflow-x-auto scrollbar-none scroll-smooth items-center gap-2.5 py-3 md:py-4 px-4 sm:px-6 w-full">
            <a href="#products"
                @click.prevent="scrollTo('products')"
                :class="activeSection === 'products' ? 'text-white bg-[#1a1a2e] font-medium shadow-md' : 'text-[#1a1a2e]/60 hover:text-[#1a1a2e] hover:bg-[#f8f9fa] bg-transparent font-medium'"
                class="shrink-0 px-4 md:px-5 py-2.5 rounded-full text-[clamp(0.875rem,1.1vw,1rem)] transition-all duration-200 ease-in-out leading-[1.65] border border-transparent">
                ផលិតផល
            </a>
            <a href="#instore"
                @click.prevent="scrollTo('instore')"
                :class="activeSection === 'instore' ? 'text-white bg-[#1a1a2e] font-medium shadow-md' : 'text-[#1a1a2e]/60 hover:text-[#1a1a2e] hover:bg-[#f8f9fa] bg-transparent font-medium'"
                class="shrink-0 px-4 md:px-5 py-2.5 rounded-full text-[clamp(0.875rem,1.1vw,1rem)] transition-all duration-200 ease-in-out leading-[1.65] border border-transparent">
                សេវាកម្មក្នុងហាង
            </a>
            <a href="#visit"
                @click.prevent="scrollTo('visit')"
                :class="activeSection === 'visit' ? 'text-white bg-[#1a1a2e] font-medium shadow-md' : 'text-[#1a1a2e]/60 hover:text-[#1a1a2e] hover:bg-[#f8f9fa] bg-transparent font-medium'"
                class="shrink-0 px-4 md:px-5 py-2.5 rounded-full text-[clamp(0.875rem,1.1vw,1rem)] transition-all duration-200 ease-in-out leading-[1.65] border border-transparent">
                ទីតាំង
            </a>
            <a href="#why"
                @click.prevent="scrollTo('why')"
                :class="activeSection === 'why' ? 'text-white bg-[#1a1a2e] font-medium shadow-md' : 'text-[#1a1a2e]/60 hover:text-[#1a1a2e] hover:bg-[#f8f9fa] bg-transparent font-medium'"
                class="shrink-0 px-4 md:px-5 py-2.5 rounded-full text-[clamp(0.875rem,1.1vw,1rem)] transition-all duration-200 ease-in-out leading-[1.65] border border-transparent">
                ហេតុអ្វីជ្រើសរើសយើង
            </a>
            <a href="#faq"
                @click.prevent="scrollTo('faq')"
                :class="activeSection === 'faq' ? 'text-white bg-[#1a1a2e] font-medium shadow-md' : 'text-[#1a1a2e]/60 hover:text-[#1a1a2e] hover:bg-[#f8f9fa] bg-transparent font-medium'"
                class="shrink-0 px-4 md:px-5 py-2.5 rounded-full text-[clamp(0.875rem,1.1vw,1rem)] transition-all duration-200 ease-in-out leading-[1.65] border border-transparent">
                សំណួរញឹកញាប់
            </a>
        </div>
    </div>
</nav>
