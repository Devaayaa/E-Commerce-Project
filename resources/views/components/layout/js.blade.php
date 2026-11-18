<!-- Library Eksternal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- Logic Script -->
<script>
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    window.addEventListener("load", () => {
        if (typeof gsap !== 'undefined') {
            gsap.registerPlugin(ScrollTrigger);

            // ==========================================
            // 🌟 0. ANIMASI PRELOADER GURITA (ULTRA SMOOTH)
            // ==========================================
            const preloader = document.getElementById("preloader");
            
            if (preloader) {
                if (!prefersReducedMotion) {
                    // Timeline Utama
                    const tl = gsap.timeline({
                        onComplete: () => {
                            // EFEK KACA SAAT HILANG (Blur + Scale + Fade)
                            gsap.to(preloader, {
                                opacity: 0,
                                scale: 1.05, 
                                filter: "blur(15px)", 
                                duration: 1.2,
                                ease: "expo.inOut",
                                onComplete: () => {
                                    preloader.style.display = "none";
                                    preloader.style.filter = "none"; 
                                }
                            });
                        }
                    });

                    // 1. Animasi Ombak (Front & Back bergerak berlawanan arah)
                    const waveFront = gsap.to("#liquid-front", {
                        x: -400, // Geser sejauh 400px
                        duration: 4,
                        repeat: -1,
                        ease: "none"
                    });
                    
                    const waveBack = gsap.to("#liquid-back", {
                        x: 400, // Geser ke kanan
                        duration: 5, // Lebih lambat agar ada efek parallax (kedalaman)
                        repeat: -1,
                        ease: "none"
                    });

                    // 2. Animasi Air Naik (Sangat Smooth & Natural)
                    tl.to(["#liquid-front", "#liquid-back"], {
                        y: -20, // Naik ke atas mengisi gurita
                        duration: 2.2,
                        ease: "expo.out" // Mulai cepat, melambat dengan sangat halus di akhir
                    }, 0);

                    // 3. Teks Muncul Perlahan (Fade Up)
                    tl.fromTo("#preloader h1, #preloader p", 
                        { y: 15, opacity: 0 },
                        { y: 0, opacity: 1, duration: 1, stagger: 0.2, ease: "power3.out" },
                        0.5
                    );

                    // 4. Jeda sejenak sebelum hilang, lalu matikan ombak
                    tl.to({}, { 
                        duration: 0.5, 
                        onComplete: () => {
                            waveFront.kill();
                            waveBack.kill();
                        }
                    });

                } else {
                    // Langsung hilangkan jika user mematikan animasi di OS
                    preloader.style.display = "none";
                }
            }

            // ==========================================
            // LOGIKA ANIMASI LAINNYA
            // ==========================================
            if (!prefersReducedMotion) {
                // 1. Animasi Scroll Umum
                if (document.querySelectorAll(".scroll-anim").length > 0) {
                    gsap.utils.toArray(".scroll-anim").forEach((elem) => {
                        gsap.to(elem, {
                            y: 0, opacity: 1, duration: 0.8, ease: "power3.out",
                            scrollTrigger: { trigger: elem, start: "top 85%", toggleActions: "play none none none" }
                        });
                    });
                }

                // 2. Animasi Grid Produk (Halaman Beranda)
                if (document.querySelectorAll(".product-grid-container").length > 0) {
                    gsap.to(".stagger-item", {
                        y: 0, opacity: 1, duration: 0.8, stagger: 0.1, ease: "power3.out",
                        scrollTrigger: { trigger: ".product-grid-container", start: "top 85%", toggleActions: "play none none none" }
                    });
                }

                // 3. ANIMASI SECTION ABOUT (HOME PAGE)
                if (document.getElementById("about")) {
                    gsap.set(".reveal-line", { filter: "blur(12px)", opacity: 0.2, y: 20 });

                    let aboutTl = gsap.timeline({
                        scrollTrigger: {
                            trigger: "#about",
                            start: "top top",
                            end: "+=3000",
                            pin: true,     
                            scrub: 1,      
                        }
                    });

                    aboutTl.to("#why-badge", { opacity: 1, duration: 1, ease: "power2.out" });
                    aboutTl.to("#why-badge", { top: "12%", left: "8%", xPercent: 0, yPercent: 0, duration: 1.5, ease: "power2.inOut" });
                    aboutTl.to("#about-content", { opacity: 1, y: 0, duration: 1, ease: "power2.out" }, "-=0.5");
                    aboutTl.to(".reveal-line", { filter: "blur(0px)", opacity: 1, y: 0, stagger: 0.4, duration: 1.2, ease: "power2.out" }, "-=0.5");
                }

                // 4. EFEK HORIZONTAL SCROLL CATEGORIES (HOME PAGE)
                const track = document.getElementById("categories-track");
                if (track && document.getElementById("categories-wrapper")) {
                    let getScrollAmount = () => {
                        return -(track.scrollWidth - window.innerWidth + 50);
                    };

                    let tween = gsap.to(track, {
                        x: () => getScrollAmount(),
                        ease: "none",
                    });

                    ScrollTrigger.create({
                        trigger: "#categories-wrapper", 
                        start: "top top", 
                        end: () => `+=${track.scrollWidth - window.innerWidth}`, 
                        pin: "#categories-pinned", 
                        animation: tween,
                        scrub: 1,
                        invalidateOnRefresh: true, 
                        anticipatePin: 1
                    });
                }

                // 5. ANIMASI MASUK KARTU KATEGORI (HALAMAN CATEGORIES)
                if (document.querySelectorAll(".category-card").length > 0 && !document.getElementById("categories-track")) {
                    gsap.from(".category-card", {
                        y: 50,
                        opacity: 0,
                        duration: 0.8,
                        stagger: 0.1,
                        ease: "power3.out",
                        clearProps: "all"
                    });
                }

            } else {
                gsap.set([".scroll-anim", ".stagger-item", ".carousel-item", ".category-card"], { opacity: 1, y: 0, x: 0 });
                gsap.set(".reveal-line", { filter: "blur(0px)", opacity: 1, y: 0 });
                if (document.getElementById("why-badge")) {
                    gsap.set("#why-badge", { opacity: 1, top: "12%", left: "8%", xPercent: 0, yPercent: 0 });
                }
            }
        }
    });

    // ==========================================
    // 6. LOGIKA FILTER KATEGORI, AUTO-FILTER & HOVER TEKS
    // ==========================================
    document.addEventListener('DOMContentLoaded', () => {
        
        if (typeof gsap !== 'undefined' && !prefersReducedMotion) {
            const hoverTexts = document.querySelectorAll('.hover-text');
            
            hoverTexts.forEach(el => {
                const text = el.innerText;
                el.innerHTML = ''; 
                
                text.split('').forEach(char => {
                    const span = document.createElement('span');
                    span.className = 'letter';
                    span.innerHTML = char === ' ' ? '&nbsp;' : char;
                    span.style.display = 'inline-block'; 
                    el.appendChild(span);
                });

                const letters = el.querySelectorAll('.letter');
                letters.forEach(letter => {
                    letter.addEventListener('mouseenter', () => {
                        gsap.to(letter, { y: -15, scale: 1.1, duration: 0.2, ease: "power2.out" });
                    });

                    letter.addEventListener('mouseleave', () => {
                        gsap.to(letter, { y: 0, scale: 1, duration: 0.5, ease: "bounce.out" });
                    });
                });
            });
        }

        const categoryCards = document.querySelectorAll('.category-card');
        if (categoryCards.length > 0) {
            categoryCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    categoryCards.forEach(c => {
                        if (c !== card) c.classList.add('opacity-40', 'blur-sm');
                    });
                });
                card.addEventListener('mouseleave', () => {
                    categoryCards.forEach(c => c.classList.remove('opacity-40', 'blur-sm'));
                });
            });
        }

        const filterBtns = document.querySelectorAll('.filter-btn');
        if (filterBtns.length > 0) {
            const applyFilter = (category, activeBtn) => {
                filterBtns.forEach(b => {
                    b.classList.remove('bg-slate-900', 'text-white', 'shadow-lg');
                    b.classList.add('bg-white/60', 'text-slate-600', 'hover:bg-white', 'hover:text-slate-900', 'border', 'border-slate-200');
                });
                if(activeBtn) {
                    activeBtn.classList.remove('bg-white/60', 'text-slate-600', 'hover:bg-white', 'hover:text-slate-900', 'border', 'border-slate-200');
                    activeBtn.classList.add('bg-slate-900', 'text-white', 'shadow-lg');
                }

                const sections = document.querySelectorAll('.product-section');
                sections.forEach(section => {
                    if (category === 'all' || section.getAttribute('data-category') === category) {
                        section.style.display = 'block';
                        section.style.opacity = '1';
                        if(typeof gsap !== 'undefined') gsap.set(section, { clearProps: "all" });
                    } else {
                        section.style.display = 'none';
                    }
                });
            };

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');
                    applyFilter(category, this);
                });
            });

            const urlParams = new URLSearchParams(window.location.search);
            const categoryParam = urlParams.get('category');

            if (categoryParam) {
                const targetBtn = document.querySelector(`.filter-btn[data-category="${categoryParam}"]`);
                if (targetBtn) {
                    targetBtn.click();
                }
            }
        }
    });

    window.toggleFaq = function(button) {
        const content = button.nextElementSibling;
        const icon = button.querySelector('svg');
        
        document.querySelectorAll('.faq-content').forEach(el => {
            if(el !== content && !el.classList.contains('hidden')) {
                el.classList.add('hidden');
                const prevIcon = el.previousElementSibling.querySelector('svg');
                if(prevIcon) prevIcon.style.transform = 'rotate(0deg)';
            }
        });

        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        } else {
            content.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    };
</script>