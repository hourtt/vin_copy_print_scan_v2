import Alpine from "alpinejs";

window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
    Alpine.data("productCarousel", () => ({
        scrollContainer: null,
        canScrollLeft: false,
        canScrollRight: true,
        autoplay: null,
        init() {
            this.scrollContainer = this.$refs.track;
            setTimeout(() => {
                this.updateButtons();
                this.startAutoplay();
            }, 100);
        },
        updateButtons() {
            if (!this.scrollContainer) return;
            const el = this.scrollContainer;
            this.canScrollLeft = el.scrollLeft > 1;
            this.canScrollRight =
                Math.ceil(el.scrollLeft) < el.scrollWidth - el.clientWidth - 1;
        },
        scrollBy(direction) {
            if (!this.scrollContainer) return;
            const cardWidth =
                this.scrollContainer.querySelector("[data-carousel-card]")
                    ?.offsetWidth || 300;
            const gap = 24;
            this.scrollContainer.scrollBy({
                left: direction * (cardWidth + gap),
                behavior: "smooth",
            });
            setTimeout(() => this.updateButtons(), 350);
        },
        startAutoplay() {
            this.autoplay = setInterval(() => {
                if (!this.canScrollRight) {
                    this.scrollContainer.scrollTo({
                        left: 0,
                        behavior: "smooth",
                    });
                    setTimeout(() => this.updateButtons(), 350);
                } else {
                    this.scrollBy(1);
                }
            }, 4000);
        },
        pauseAutoplay() {
            clearInterval(this.autoplay);
        },
        resumeAutoplay() {
            this.startAutoplay();
        },
    }));
});
Alpine.start();
