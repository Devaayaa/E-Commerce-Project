<!-- Library Eksternal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Logic Script -->
<script>
    window.addEventListener("load", () => {
        if (typeof gsap !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);

            // 1. Animasi Hero
            if (document.querySelectorAll(".hero-anim").length > 0) {
                gsap.from(".hero-anim", { y: 40, opacity: 0, duration: 1, stagger: 0.15, ease: "power3.out" });
            }

            // 2. Animasi Scroll Umum
            if (document.querySelectorAll(".scroll-anim").length > 0) {
                gsap.from(".scroll-anim", {
                    y: 30, opacity: 0, duration: 0.8, ease: "power3.out",
                    scrollTrigger: { trigger: ".scroll-anim", start: "top 90%" }
                });
            }

            // 3. Animasi Grid Produk (Beranda)
            if (document.querySelectorAll(".product-grid-container").length > 0) {
                gsap.from(".stagger-item", {
                    y: 30, opacity: 0, duration: 0.8, stagger: 0.1, ease: "power3.out",
                    scrollTrigger: { trigger: ".product-grid-container", start: "top 85%", toggleActions: "restart pause reverse pause" }
                });
            }

            // ==========================================
            // 4. ANIMASI CAROUSEL PRODUK (Halaman Produk)
            // ==========================================
            const categorySections = document.querySelectorAll(".category-section");
            if (categorySections.length > 0) {
                categorySections.forEach((section) => {
                    // Animasi judul kategori
                    gsap.from(section.querySelector('h2'), {
                        y: 20, opacity: 0, duration: 0.8, ease: "power3.out",
                        scrollTrigger: { trigger: section, start: "top 85%" }
                    });

                    // Animasi kartu-kartu produk bergeser dari kanan secara berurutan
                    const cards = section.querySelectorAll(".carousel-item");
                    if(cards.length > 0) {
                        gsap.from(cards, {
                            x: 50, opacity: 0, duration: 0.8, stagger: 0.1, ease: "power3.out",
                            scrollTrigger: { trigger: section, start: "top 80%" }
                        });
                    }
                });
            }
        }
    });

    // 5. Logika Filter Kategori
    document.addEventListener('DOMContentLoaded', () => {
        const filterBtns = document.querySelectorAll('.filter-btn');
        
        if (filterBtns.length > 0) {
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');

                    filterBtns.forEach(b => {
                        b.classList.remove('bg-slate-900', 'text-white', 'shadow-lg');
                        b.classList.add('bg-white/60', 'text-slate-600', 'hover:bg-white', 'hover:text-slate-900', 'border', 'border-slate-200');
                    });

                    this.classList.remove('bg-white/60', 'text-slate-600', 'hover:bg-white', 'hover:text-slate-900', 'border', 'border-slate-200');
                    this.classList.add('bg-slate-900', 'text-white', 'shadow-lg');

                    const sections = document.querySelectorAll('.product-section');
                    
                    gsap.to(sections, {
                        opacity: 0, y: 20, duration: 0.3,
                        onComplete: () => {
                            sections.forEach(section => {
                                if (category === 'all' || section.dataset.category === category) {
                                    section.style.display = 'block';
                                } else {
                                    section.style.display = 'none';
                                }
                            });

                            const visibleSections = document.querySelectorAll('.product-section[style="display: block;"]');
                            
                            gsap.fromTo(visibleSections, 
                                { opacity: 0, y: 20 }, 
                                { opacity: 1, y: 0, duration: 0.5, stagger: 0.1, ease: "power2.out", 
                                  onComplete: () => { ScrollTrigger.refresh(); }
                                }
                            );
                        }
                    });
                });
            });
        }
    });
</script>