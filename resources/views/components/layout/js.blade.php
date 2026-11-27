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
            // 🌟 BAGIAN 1 — Konstanta & Logic PRODUCT GLASS FOLDER
            // ==========================================
            const TF_LAYOUTS = {
                fan: {
                    K: Math.min(1, (window.innerWidth - 48) / 520),
                    scaleK: false,
                    sx: [-165, -85, 0, 85, 165],
                    sy: [-55, -95, -125, -95, -55],
                    sr: [-16, -8, 0, 8, 16],
                    ss: [.92, .96, 1.06, .96, .92],
                    bdA: {
                        x: -185,
                        y: -235,
                        r: -7
                    },
                    bdB: {
                        x: 190,
                        y: -245,
                        r: 7
                    },
                    stagger: .08,
                    float: 9
                }
            };

            // Folder kategori: lempar file -> folder mengecil & turun -> file berjajar
            const initCatFolder = (z, reduced) => {
                const q = s => z.querySelector(s);

                // ---- ukuran dihitung otomatis dari lebar panel ----
                const k = Math.min(1, z.clientWidth / 1196); // skala kartu
                const FS = .42; // ukuran akhir folder
                const ROWC = 36 + 159 * k; // titik tengah baris kartu
                const base = Math.round(172 + 318 * k); // dasar folder setelah turun
                const H = base + 18; // tinggi zona
                const FT = Math.max(10, base - 362); // posisi awal folder
                const CY0 = FT + 150; // titik tengah kartu di folder
                z.style.height = H + 'px';
                q('.tf-folder').style.top = FT + 'px';

                const cards = gsap.utils.toArray('.tf-card', z);
                const front = q('.tf-front'),
                    back = q('.tf-back'),
                    outline = q('.tf-outline'),
                    shadow = q('.tf-shadow'),
                    tab = q('.tf-tab'),
                    bdA = q('.tf-bd-a'),
                    bdB = q('.tf-bd-b');
                const shift = base - (FT + 262); // jarak folder turun
                const BY = (base - 30) - (FT + 95); // posisi akhir badge
                const sl = el => +el.dataset.slot;

                // posisi saat dilempar: [x, offset y dari baris, rotasi]
                const TOSS = [
                    [-560, 34, -20],
                    [-290, -4, -9],
                    [0, -16, 5],
                    [290, 6, 11],
                    [560, 38, 21]
                ];
                const WAVE = [12, 0, -14, 0, 12]; // lengkung baris akhir
                const row = {
                    x: (i, el) => (sl(el) - 2) * 240 * k,
                    y: (i, el) => ROWC + WAVE[sl(el)] - CY0,
                    scale: (i, el) => (sl(el) === 2 ? 1.06 : 1) * k,
                    rotation: 0
                };
                const toss = {
                    x: (i, el) => TOSS[sl(el)][0] * k,
                    y: (i, el) => ROWC + TOSS[sl(el)][1] - CY0,
                    rotation: (i, el) => TOSS[sl(el)][2],
                    scale: k
                };

                let ready = false; // hover aktif setelah animasi selesai

                // ---- hover zoom ----
                const zi = el => sl(el) === 2 ? 8 : (sl(el) === 1 || sl(el) === 3) ? 6 : 5;
                const bs = el => (sl(el) === 2 ? 1.06 : 1) * k;
                const bindHover = () => cards.forEach(c => {
                    c.addEventListener('mouseenter', () => {
                        if (!ready) return;
                        c._h && c._h.kill();
                        c.style.zIndex = 30;
                        if (c._by === undefined) c._by = gsap.getProperty(c, 'y');
                        c._h = gsap.to(c, {
                            scale: bs(c) * 1.12,
                            y: c._by - 10,
                            duration: .4,
                            ease: 'power2.out'
                        });
                    });
                    c.addEventListener('mouseleave', () => {
                        if (!ready) return;
                        c._h && c._h.kill();
                        c._h = gsap.to(c, {
                            scale: bs(c),
                            y: c._by,
                            duration: .4,
                            ease: 'power2.out',
                            onComplete: () => {
                                c.style.zIndex = zi(c);
                                c._by = undefined;
                            }
                        });
                    });
                });

                gsap.set([back, outline, shadow, front], {
                    transformOrigin: '50% 100%'
                });
                gsap.set(tab, {
                    transformOrigin: '140px 255px'
                });
                gsap.set([bdA, bdB], {
                    xPercent: -50
                });

                // ---- prefers-reduced-motion: langsung posisi akhir ----
                if (reduced) {
                    gsap.set([back, outline, shadow, tab], {
                        scale: FS,
                        y: shift
                    });
                    gsap.set(front, {
                        rotationX: -32,
                        scale: FS,
                        y: shift + 10
                    });
                    gsap.set(cards, {
                        ...row,
                        opacity: 1
                    });
                    gsap.set(bdA, {
                        x: -185,
                        y: BY
                    });
                    gsap.set(bdB, {
                        x: 185,
                        y: BY
                    });
                    ready = true;
                    bindHover();
                    return;
                }

                gsap.set(cards, {
                    x: 0,
                    y: 0,
                    scale: .3,
                    opacity: 0
                });
                gsap.set([bdA, bdB], {
                    y: 20,
                    scale: .6,
                    opacity: 0
                });

                // efek melayang halus setelah semua selesai
                const flEls = gsap.utils.toArray('.tf-fl', z);
                let floats = [];
                const startFloat = () => {
                    floats = flEls.map((el, i) =>
                        gsap.to(el, {
                            y: i % 2 ? -4 : 4,
                            duration: 2 + i * .2,
                            repeat: -1,
                            yoyo: true,
                            ease: 'sine.inOut'
                        })
                    );
                };
                const stopFloat = () => {
                    floats.forEach(t => t.kill());
                    floats = [];
                    gsap.to(flEls, {
                        y: 0,
                        duration: .3
                    });
                };

                const tl = gsap.timeline({
                    paused: true,
                    onComplete: () => {
                        startFloat();
                        ready = true;
                    }
                });

                // 1) folder terbuka & MELEMPAR semua file
                tl.to(front, {
                        rotationX: -32,
                        y: 10,
                        duration: .7,
                        ease: 'power2.out'
                    }, 0)
                    .to(shadow, {
                        scaleX: 1.15,
                        scaleY: 1.5,
                        duration: .7,
                        ease: 'power2.out'
                    }, 0)
                    .to(cards, {
                        opacity: 1,
                        duration: .25,
                        stagger: {
                            each: .12,
                            from: 'center'
                        }
                    }, .35)
                    .to(cards, {
                        ...toss,
                        duration: 1.3,
                        ease: 'power3.out',
                        stagger: {
                            each: .12,
                            from: 'center'
                        }
                    }, .35)
                    .to(bdA, {
                        x: -215,
                        y: 70,
                        rotation: -4,
                        scale: 1,
                        opacity: 1,
                        duration: .8,
                        ease: 'back.out(2)'
                    }, 1.4)
                    .to(bdB, {
                        x: 215,
                        y: 70,
                        rotation: 4,
                        scale: 1,
                        opacity: 1,
                        duration: .8,
                        ease: 'back.out(2)'
                    }, 1.5)

                    // 2) folder mengecil & bergeser turun
                    .to([back, outline, shadow, tab], {
                        scale: FS,
                        y: shift,
                        duration: 2.2,
                        ease: 'power2.inOut'
                    }, 2.4)
                    .to(front, {
                        scale: FS,
                        y: shift + 10,
                        duration: 2.2,
                        ease: 'power2.inOut'
                    }, 2.4)
                    .to(bdA, {
                        x: -185,
                        y: BY,
                        duration: 2.2,
                        ease: 'power2.inOut'
                    }, 2.4)
                    .to(bdB, {
                        x: 185,
                        y: BY,
                        duration: 2.2,
                        ease: 'power2.inOut'
                    }, 2.4)

                    // 3) tiap file memisahkan diri & berjajar ke samping
                    .to(cards, {
                        ...row,
                        duration: 1.5,
                        ease: 'back.out(1.15)',
                        stagger: {
                            each: .14,
                            from: 'center'
                        }
                    }, 2.9);

                let open = false;
                const doOpen = () => {
                    if (open) return;
                    open = true;
                    tl.timeScale(1).play();
                };
                const doClose = () => {
                    if (!open) return;
                    open = false;
                    ready = false;
                    cards.forEach(c => c._h && c._h.kill());
                    stopFloat();
                    tl.timeScale(2).reverse();
                };

                ScrollTrigger.create({
                    trigger: z,
                    start: 'top 55%',
                    end: 'bottom top',
                    onEnter: doOpen,
                    onEnterBack: doOpen,
                    onLeaveBack: doClose
                });

                bindHover();
            };

            const initFolder = (zone, reduced) => {
                if (zone.dataset.mode === 'row') return initCatFolder(zone, reduced);

                const L = TF_LAYOUTS[zone.dataset.mode || 'fan'];
                const K = L.K;
                const slot = (el) => +el.dataset.slot;
                const sc = (el) => L.ss[slot(el)] * (L.scaleK ? K : 1);
                const cards = gsap.utils.toArray('.tf-card', zone);
                const front = zone.querySelector('.tf-front');
                const shadow = zone.querySelector('.tf-shadow');
                const bdA = zone.querySelector('.tf-bd-a');
                const bdB = zone.querySelector('.tf-bd-b');
                const hint = zone.parentElement.querySelector('.tf-hint');
                const flEls = gsap.utils.toArray('.tf-card .tf-fl, .tf-badge .tf-fl', zone);
                const cardTo = () => ({
                    x: (i, el) => L.sx[slot(el)] * K,
                    y: (i, el) => L.sy[slot(el)],
                    rotation: (i, el) => L.sr[slot(el)],
                    scale: (i, el) => sc(el),
                    opacity: 1
                });

                // prefers-reduced-motion: langsung terbuka
                if (reduced) {
                    gsap.set(front, {
                        rotationX: -32,
                        y: 10
                    });
                    gsap.set(cards, cardTo());
                    gsap.set([bdA, bdB], {
                        xPercent: -50,
                        opacity: 1,
                        scale: 1
                    });
                    gsap.set(bdA, {
                        x: L.bdA.x * K,
                        y: L.bdA.y,
                        rotation: L.bdA.r
                    });
                    gsap.set(bdB, {
                        x: L.bdB.x * K,
                        y: L.bdB.y,
                        rotation: L.bdB.r
                    });
                    if (hint) gsap.set(hint, {
                        opacity: 0
                    });
                    return;
                }

                gsap.set([...cards, front, bdA, bdB, shadow], {
                    transition: 'none'
                });
                gsap.set(cards, {
                    y: 70,
                    scale: .85,
                    opacity: 0
                });
                gsap.set([bdA, bdB], {
                    xPercent: -50,
                    y: 30,
                    scale: .6,
                    opacity: 0
                });

                let floats = [];
                let isOpen = false;
                let locked = false;

                const stopFloat = (silent) => {
                    floats.forEach(t => t.kill());
                    floats = [];
                    if (!silent) gsap.to(flEls, {
                        y: 0,
                        duration: .4,
                        ease: 'power2.out'
                    });
                };
                const startFloat = () => {
                    stopFloat(true);
                    floats = flEls.map((el, i) =>
                        gsap.to(el, {
                            y: (i % 2 ? -L.float : L.float),
                            duration: 2 + i * .25,
                            repeat: -1,
                            yoyo: true,
                            ease: 'sine.inOut'
                        })
                    );
                };

                const tl = gsap.timeline({
                    paused: true,
                    onComplete: startFloat,
                    defaults: {
                        ease: 'back.out(1.4)',
                        duration: .8
                    }
                });
                tl
                    .to(front, {
                        rotationX: -32,
                        y: 10,
                        duration: .7,
                        ease: 'power3.out'
                    }, 0)
                    .to(shadow, {
                        scaleX: 1.15,
                        scaleY: 1.5,
                        opacity: 1,
                        duration: .7,
                        ease: 'power3.out'
                    }, 0)
                    .to(cards, {
                        ...cardTo(),
                        stagger: L.stagger
                    }, .1)
                    .to(bdA, {
                        x: L.bdA.x * K,
                        y: L.bdA.y,
                        rotation: L.bdA.r,
                        scale: 1,
                        opacity: 1,
                        duration: .6,
                        ease: 'back.out(2)'
                    }, .45)
                    .to(bdB, {
                        x: L.bdB.x * K,
                        y: L.bdB.y,
                        rotation: L.bdB.r,
                        scale: 1,
                        opacity: 1,
                        duration: .6,
                        ease: 'back.out(2)'
                    }, .5);

                const open = () => {
                    if (isOpen) return;
                    isOpen = true;
                    tl.timeScale(1).play();
                    if (hint) gsap.to(hint, {
                        opacity: 0,
                        y: 6,
                        duration: .3
                    });
                };
                const close = () => {
                    if (!isOpen) return;
                    isOpen = false;
                    stopFloat();
                    tl.timeScale(1.5).reverse();
                    if (hint) gsap.to(hint, {
                        opacity: 1,
                        y: 0,
                        duration: .4,
                        delay: .3
                    });
                };

                zone.addEventListener('mouseenter', open);
                zone.addEventListener('mouseleave', () => {
                    if (!locked) close();
                });
                // Mobile: tap pertama buka folder, tap berikutnya buka link
                zone.addEventListener('click', (e) => {
                    if (!isOpen) {
                        e.preventDefault();
                        open();
                    }
                });
                // Keyboard
                zone.addEventListener('focusin', open);
                zone.addEventListener('focusout', (e) => {
                    if (!locked && !zone.contains(e.relatedTarget)) close();
                });

                // ✨ Buka otomatis saat folder masuk layar (data-auto), tutup lagi bila di-scroll balik ke atas
                if (zone.dataset.auto === 'true') {
                    ScrollTrigger.create({
                        trigger: zone,
                        start: 'top 72%',
                        end: 'bottom top',
                        onEnter: () => {
                            locked = true;
                            open();
                        },
                        onEnterBack: () => {
                            locked = true;
                            open();
                        },
                        onLeaveBack: () => {
                            locked = false;
                            close();
                        }
                    });
                }
            };

            // ==========================================
            // 🌟 0. PRELOADER GURITA
            // ==========================================
            const preloader = document.getElementById("preloader");
            if (preloader) {
                if (!prefersReducedMotion) {
                    const tl = gsap.timeline({
                        onComplete: () => {
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

                    const waveFront = gsap.to("#liquid-front", {
                        x: -400,
                        duration: 4,
                        repeat: -1,
                        ease: "none"
                    });
                    const waveBack = gsap.to("#liquid-back", {
                        x: 400,
                        duration: 5,
                        repeat: -1,
                        ease: "none"
                    });

                    tl.to(["#liquid-front", "#liquid-back"], {
                        y: -20,
                        duration: 2.2,
                        ease: "expo.out"
                    }, 0);
                    tl.fromTo("#preloader h1, #preloader p", {
                            y: 15,
                            opacity: 0
                        }, {
                            y: 0,
                            opacity: 1,
                            duration: 1,
                            stagger: 0.2,
                            ease: "power3.out"
                        },
                        0.5
                    );
                    tl.to({}, {
                        duration: 0.5,
                        onComplete: () => {
                            waveFront.kill();
                            waveBack.kill();
                        }
                    });
                } else {
                    preloader.style.display = "none";
                }
            }

            // ==========================================
            // LOGIKA ANIMASI LAINNYA
            // ==========================================
            if (!prefersReducedMotion) {

                // 🌟 ANIMASI SCROLL
                if (document.querySelectorAll(".scroll-anim").length > 0) {
                    gsap.utils.toArray(".scroll-anim").forEach((elem) => {
                        gsap.to(elem, {
                            y: 0,
                            opacity: 1,
                            duration: 0.8,
                            ease: "power3.out",
                            scrollTrigger: {
                                trigger: elem,
                                start: "top 85%",
                                toggleActions: "play none none none"
                            }
                        });
                    });
                }

                if (document.querySelectorAll(".product-grid-container").length > 0) {
                    gsap.to(".stagger-item", {
                        y: 0,
                        opacity: 1,
                        duration: 0.8,
                        stagger: 0.1,
                        ease: "power3.out",
                        scrollTrigger: {
                            trigger: ".product-grid-container",
                            start: "top 85%",
                            toggleActions: "play none none none"
                        }
                    });
                }

                if (document.getElementById("about")) {
                    gsap.set(".reveal-line", {
                        filter: "blur(12px)",
                        opacity: 0.2,
                        y: 20
                    });

                    let aboutTl = gsap.timeline({
                        scrollTrigger: {
                            trigger: "#about",
                            start: "top top",
                            end: "+=3000",
                            pin: true,
                            scrub: 1,
                        }
                    });

                    aboutTl.to("#why-badge", {
                        opacity: 1,
                        duration: 1,
                        ease: "power2.out"
                    });
                    aboutTl.to("#why-badge", {
                        top: "12%",
                        left: "8%",
                        xPercent: 0,
                        yPercent: 0,
                        duration: 1.5,
                        ease: "power2.inOut"
                    });
                    aboutTl.to("#about-content", {
                        opacity: 1,
                        y: 0,
                        duration: 1,
                        ease: "power2.out"
                    }, "-=0.5");
                    aboutTl.to(".reveal-line", {
                        filter: "blur(0px)",
                        opacity: 1,
                        y: 0,
                        stagger: 0.4,
                        duration: 1.2,
                        ease: "power2.out"
                    }, "-=0.5");
                }

                // ==========================================
                // 🗂️ CATEGORIES — horizontal scroll baru
                // ==========================================
                const track = document.getElementById("categories-track");
                if (track && document.getElementById("categories-wrapper")) {
                    const cards = gsap.utils.toArray(".cat-card");
                    const bar = document.getElementById("cat-progress-bar");
                    const counter = document.getElementById("cat-current");
                    const dist = () => Math.max(0, track.scrollWidth - window.innerWidth);

                    const updateCards = () => {
                        const mid = window.innerWidth / 2;
                        let best = 0,
                            bestD = Infinity;
                        cards.forEach((c, i) => {
                            const r = c.getBoundingClientRect();
                            const d = (r.left + r.width / 2) - mid;
                            const n = Math.min(Math.abs(d) / (window.innerWidth * 0.6), 1);
                            gsap.set(c, {
                                scale: 1 - n * 0.12,
                                opacity: 1 - n * 0.4
                            });
                            const img = c.querySelector("img");
                            if (img) gsap.set(img, {
                                x: -d * 0.08
                            });
                            if (Math.abs(d) < bestD) {
                                bestD = Math.abs(d);
                                best = i;
                            }
                        });
                        cards.forEach((c, i) => c.classList.toggle("is-active", i === best));
                        if (counter) counter.textContent = String(best + 1).padStart(2, "0");
                    };

                    const tween = gsap.to(track, {
                        x: () => -dist(),
                        ease: "none",
                        onUpdate: updateCards
                    });

                    ScrollTrigger.create({
                        trigger: "#categories-wrapper",
                        start: "top top",
                        end: () => `+=${dist() * 1.4}`,
                        pin: "#categories-pinned",
                        pinSpacing: true,
                        animation: tween,
                        scrub: 0.8,
                        snap: {
                            snapTo: 1 / Math.max(1, cards.length - 1),
                            duration: {
                                min: 0.25,
                                max: 0.7
                            },
                            delay: 0.05,
                            ease: "power2.inOut"
                        },
                        invalidateOnRefresh: true,
                        anticipatePin: 1,
                        onUpdate: (self) => {
                            if (bar) bar.style.transform = `scaleX(${self.progress})`;
                        },
                        onRefresh: updateCards
                    });
                    updateCards();
                }

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

                // ==========================================
                // ❓ FAQ — item muncul berurutan saat di-scroll
                // ==========================================
                if (document.querySelectorAll(".faq-item").length > 0) {
                    gsap.from(".faq-item", {
                        y: 36,
                        opacity: 0,
                        duration: 0.8,
                        stagger: 0.09,
                        ease: "power3.out",
                        clearProps: "transform,opacity",
                        scrollTrigger: {
                            trigger: "#faq-list",
                            start: "top 85%",
                            toggleActions: "play none none none"
                        }
                    });
                }

                // ✨ Kartu Loka Standard muncul berurutan
                if (document.querySelectorAll(".std-card").length > 0) {
                    gsap.from(".std-card", {
                        y: 44,
                        opacity: 0,
                        scale: .96,
                        duration: 0.8,
                        stagger: 0.12,
                        ease: "power3.out",
                        clearProps: "transform,opacity",
                        scrollTrigger: {
                            trigger: ".std-card",
                            start: "top 88%",
                            toggleActions: "play none none none"
                        }
                    });
                }

                // 🌟 Semua folder (produk & kategori)
                document.querySelectorAll('.tf-zone').forEach(z => initFolder(z, false));

            } else {
                // ==========================================
                // FALLBACK prefers-reduced-motion
                // ==========================================
                gsap.set([".scroll-anim", ".stagger-item", ".carousel-item", ".category-card"], {
                    opacity: 1,
                    y: 0,
                    x: 0
                });
                gsap.set(".reveal-line", {
                    filter: "blur(0px)",
                    opacity: 1,
                    y: 0
                });
                if (document.getElementById("why-badge")) {
                    gsap.set("#why-badge", {
                        opacity: 1,
                        top: "12%",
                        left: "8%",
                        xPercent: 0,
                        yPercent: 0
                    });
                }
                if (document.getElementById("about-content")) {
                    gsap.set("#about-content", {
                        opacity: 1,
                        y: 0
                    });
                }
                const tr = document.getElementById("categories-track");
                if (tr) {
                    tr.style.overflowX = "auto";
                    tr.style.width = "100%";
                }

                // 🌟 Folder langsung terbuka
                document.querySelectorAll('.tf-zone').forEach(z => initFolder(z, true));
            }
        }
    });

    // ==========================================
    // 6. LOGIKA FILTER KATEGORI, HOVER TEKS
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
                        gsap.to(letter, {
                            y: -15,
                            scale: 1.1,
                            duration: 0.2,
                            ease: "power2.out"
                        });
                    });
                    letter.addEventListener('mouseleave', () => {
                        gsap.to(letter, {
                            y: 0,
                            scale: 1,
                            duration: 0.5,
                            ease: "bounce.out"
                        });
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
                if (activeBtn) {
                    activeBtn.classList.remove('bg-white/60', 'text-slate-600', 'hover:bg-white', 'hover:text-slate-900', 'border', 'border-slate-200');
                    activeBtn.classList.add('bg-slate-900', 'text-white', 'shadow-lg');
                }

                const sections = document.querySelectorAll('.product-section');
                sections.forEach(section => {
                    if (category === 'all' || section.getAttribute('data-category') === category) {
                        section.style.display = 'block';
                        section.style.opacity = '1';
                        if (typeof gsap !== 'undefined') gsap.set(section, {
                            clearProps: "all"
                        });
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
                if (targetBtn) targetBtn.click();
            }
        }

        // ✨ Spotlight kaca mengikuti kursor (delegasi: ikut berlaku untuk kartu hasil filter)
        document.addEventListener('pointermove', (e) => {
            const el = e.target.closest && e.target.closest('.lg-spot');
            if (!el) return;
            const r = el.getBoundingClientRect();
            el.style.setProperty('--mx', (e.clientX - r.left) + 'px');
            el.style.setProperty('--my', (e.clientY - r.top) + 'px');
        });

        // ❓ FAQ — pencarian
        const faqSearch = document.getElementById('faq-search');
        if (faqSearch) {
            faqSearch.addEventListener('input', () => {
                const q = faqSearch.value.trim().toLowerCase();
                let visible = 0;
                document.querySelectorAll('.faq-item').forEach(item => {
                    const hit = !q || item.textContent.toLowerCase().includes(q);
                    item.style.display = hit ? '' : 'none';
                    if (hit) visible++;
                });
                const empty = document.getElementById('faq-empty');
                if (empty) empty.classList.toggle('hidden', visible > 0);
            });
        }

        // ==========================================
        // 🌟 7. COURIER DASHBOARD
        // ==========================================
        const courierApp = document.getElementById('courier-app');
        if (courierApp) {
            const locationUrl = courierApp.dataset.routeLocation;
            const statusUrl = courierApp.dataset.routeStatus;
            const withdrawUrl = courierApp.dataset.routeWithdraw;
            const profileUrl = courierApp.dataset.routeProfile;
            const csrfToken = courierApp.dataset.csrf;
            const initialStatus = courierApp.dataset.initialStatus;
            const courierBalance = parseFloat(courierApp.dataset.balance) || 0;

            const dot = document.getElementById('gps-dot');
            const text = document.getElementById('gps-text');
            const badge = document.getElementById('gps-badge');
            const warning = document.getElementById('offline-warning');
            let watchId = null;

            function setGpsState(active, label) {
                if (!dot || !badge || !text) return;
                dot.className = 'w-3 h-3 rounded-full flex-shrink-0 ' + (active ? 'bg-emerald-500 animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.8)]' : 'bg-slate-400');
                if (active) {
                    badge.className = 'inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 shadow-sm transition-all duration-300 max-w-[180px]';
                } else {
                    badge.className = 'inline-flex items-center gap-2 px-4 py-2.5 rounded-full bg-white/80 border border-slate-200 text-slate-500 shadow-sm transition-all duration-300 max-w-[180px]';
                }
                text.textContent = label;
            }

            function startGps() {
                if (!('geolocation' in navigator)) return setGpsState(false, 'No GPS Support');
                if (watchId) return;
                let lastSent = 0;
                watchId = navigator.geolocation.watchPosition(
                    pos => {
                        setGpsState(true, 'GPS Active');
                        const now = Date.now();
                        if (now - lastSent < 15000) return;
                        lastSent = now;
                        fetch(locationUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                latitude: pos.coords.latitude,
                                longitude: pos.coords.longitude
                            })
                        }).catch(() => {});
                    },
                    () => setGpsState(false, 'GPS Denied'), {
                        enableHighAccuracy: false,
                        maximumAge: 15000,
                        timeout: 30000
                    }
                );
            }

            function stopGps() {
                if (watchId) {
                    navigator.geolocation.clearWatch(watchId);
                    watchId = null;
                }
                setGpsState(false, 'Location Inactive');
            }

            window.showCourierToast = function(message) {
                const toast = document.getElementById('toast');
                const msg = document.getElementById('toast-message');
                if (!toast || !msg) return;
                msg.textContent = message;
                toast.classList.remove('translate-y-20', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');
                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3000);
            }

            const btn = document.getElementById('btn-status');
            if (btn) {
                btn.addEventListener('click', async function() {
                    const btnText = document.getElementById('btn-text');
                    const btnIcon = document.getElementById('btn-icon');
                    const btnSpinner = document.getElementById('btn-spinner');

                    const currentStatus = btn.dataset.status;
                    const newStatus = currentStatus === 'offline' ? 'available' : 'offline';

                    btn.disabled = true;
                    btnIcon.classList.add('hidden');
                    btnSpinner.classList.remove('hidden');

                    try {
                        const response = await fetch(statusUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        });
                        const data = await response.json();

                        if (response.ok) {
                            btn.dataset.status = newStatus;
                            window.showCourierToast(data.success);

                            if (newStatus === 'available') {
                                btnText.textContent = 'Go Offline';
                                btn.classList.add('hover:bg-red-500/80', 'hover:text-white', 'hover:border-red-300');
                                if (warning) warning.classList.add('hidden');
                                btnIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>';
                                startGps();
                            } else {
                                btnText.textContent = 'Start Working';
                                btn.classList.remove('hover:bg-red-500/80', 'hover:text-white', 'hover:border-red-300');
                                if (warning) warning.classList.remove('hidden');
                                btnIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>';
                                stopGps();
                            }
                        } else {
                            window.showCourierToast(data.error || 'Something went wrong');
                        }
                    } catch (error) {
                        window.showCourierToast('Network error. Please try again.');
                    } finally {
                        btn.disabled = false;
                        btnIcon.classList.remove('hidden');
                        btnSpinner.classList.add('hidden');
                    }
                });
            }

            if (initialStatus !== 'offline') startGps();

            // -- Modal Withdraw --
            const withdrawModal = document.getElementById('withdraw-modal');
            const withdrawContent = document.getElementById('withdraw-modal-content');

            window.handleWithdrawClick = function() {
                if (courierBalance <= 0) {
                    window.showCourierToast('Your balance is 0. You cannot withdraw at this time.');
                    return;
                }
                window.openWithdrawModal();
            }
            window.openWithdrawModal = function() {
                if (!withdrawModal) return;
                withdrawModal.classList.remove('hidden');
                withdrawModal.classList.add('flex');
                setTimeout(() => {
                    withdrawContent.classList.remove('scale-95');
                    withdrawContent.classList.add('scale-100');
                }, 10);
            }
            window.closeWithdrawModal = function() {
                if (!withdrawModal) return;
                withdrawContent.classList.remove('scale-100');
                withdrawContent.classList.add('scale-95');
                setTimeout(() => {
                    withdrawModal.classList.add('hidden');
                    withdrawModal.classList.remove('flex');
                }, 300);
            }
            window.submitWithdrawal = async function(e) {
                e.preventDefault();
                const form = document.getElementById('withdraw-form');
                const submitBtn = document.getElementById('btn-withdraw-submit');
                const submitText = document.getElementById('withdraw-btn-text');
                const submitSpinner = document.getElementById('withdraw-spinner');
                const formData = new FormData(form);

                submitBtn.disabled = true;
                submitText.textContent = 'Processing...';
                submitSpinner.classList.remove('hidden');

                try {
                    const response = await fetch(withdrawUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    const data = await response.json();
                    if (response.ok) {
                        window.showCourierToast(data.success);
                        window.closeWithdrawModal();
                        form.reset();
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        window.showCourierToast(data.error || data.message || 'An error occurred.');
                    }
                } catch (error) {
                    window.showCourierToast('Network error. Please try again.');
                } finally {
                    submitBtn.disabled = false;
                    submitText.textContent = 'Process Withdrawal';
                    submitSpinner.classList.add('hidden');
                }
            }

            // -- Modal Profile --
            const profileModal = document.getElementById('profile-modal');
            const profileContent = document.getElementById('profile-modal-content');

            window.openProfileModal = function() {
                if (!profileModal) return;
                profileModal.classList.remove('hidden');
                profileModal.classList.add('flex');
                setTimeout(() => {
                    profileContent.classList.remove('scale-95');
                    profileContent.classList.add('scale-100');
                }, 10);
            }
            window.closeProfileModal = function() {
                if (!profileModal) return;
                profileContent.classList.remove('scale-100');
                profileContent.classList.add('scale-95');
                setTimeout(() => {
                    profileModal.classList.add('hidden');
                    profileModal.classList.remove('flex');
                }, 300);
            }
            window.submitProfileUpdate = async function(e) {
                e.preventDefault();
                const form = document.getElementById('profile-form');
                const formData = new FormData(form);
                try {
                    const response = await fetch(profileUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    const data = await response.json();
                    if (response.ok) {
                        window.showCourierToast(data.success || 'Profile updated successfully!');
                        window.closeProfileModal();
                        setTimeout(() => window.location.reload(), 1500);
                    } else {
                        window.showCourierToast(data.error || data.message || 'Failed to update profile. Please check your data.');
                    }
                } catch (error) {
                    window.showCourierToast('Network error. Please try again later.');
                }
            }

            // -- Chart.js --
            const chartCanvas = document.getElementById('earningsChart');
            if (chartCanvas) {
                const ctx = chartCanvas.getContext('2d');
                const createdAtStr = courierApp.dataset.createdAt;
                const createdDate = new Date(createdAtStr);
                const now = new Date();
                const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

                let startDate = new Date(now.getFullYear(), now.getMonth() - 5, 1);
                const courierStartMonth = new Date(createdDate.getFullYear(), createdDate.getMonth(), 1);
                if (courierStartMonth > startDate) startDate = courierStartMonth;

                let dynamicLabels = [],
                    dynamicData = [];
                let loopDate = new Date(startDate);
                while (loopDate <= now) {
                    dynamicLabels.push(monthNames[loopDate.getMonth()] + " " + loopDate.getFullYear().toString().substr(-2));
                    dynamicData.push(Math.floor(Math.random() * (4500000 - 1500000 + 1) + 1500000));
                    loopDate.setMonth(loopDate.getMonth() + 1);
                }

                let gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dynamicLabels,
                        datasets: [{
                            label: 'Earnings (Rp)',
                            data: dynamicData,
                            borderColor: '#2563eb',
                            backgroundColor: gradient,
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#2563eb',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                titleFont: {
                                    size: 13,
                                    family: 'Inter'
                                },
                                bodyFont: {
                                    size: 14,
                                    family: 'Inter',
                                    weight: 'bold'
                                },
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(255, 255, 255, 0.3)',
                                    drawBorder: false
                                },
                                ticks: {
                                    color: '#64748b',
                                    font: {
                                        size: 11,
                                        family: 'Inter',
                                        weight: '600'
                                    },
                                    callback: function(value) {
                                        if (value === 0) return 'Rp 0';
                                        return 'Rp ' + (value / 1000000) + 'M';
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#64748b',
                                    font: {
                                        size: 12,
                                        family: 'Inter',
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }
    });

    // ==========================================
    // 8. FAQ — accordion animasi (tinggi dianimasikan GSAP)
    // ==========================================
    (function() {
        const canAnimate = () => typeof gsap !== 'undefined' && !prefersReducedMotion;

        function closeFaq(item) {
            const panel = item.querySelector('.faq-panel');
            const body = panel.firstElementChild;
            item.classList.remove('is-open');
            item.querySelector('.faq-btn').setAttribute('aria-expanded', 'false');
            if (canAnimate()) {
                gsap.to(panel, {
                    height: 0,
                    duration: 0.45,
                    ease: 'power3.inOut',
                    overwrite: true
                });
                gsap.to(body, {
                    opacity: 0,
                    y: -6,
                    duration: 0.25,
                    overwrite: true
                });
            } else {
                panel.style.height = '0px';
            }
        }

        function openFaq(item) {
            const panel = item.querySelector('.faq-panel');
            const body = panel.firstElementChild;
            item.classList.add('is-open');
            item.querySelector('.faq-btn').setAttribute('aria-expanded', 'true');
            if (canAnimate()) {
                gsap.to(panel, {
                    height: 'auto',
                    duration: 0.55,
                    ease: 'power3.out',
                    overwrite: true
                });
                gsap.fromTo(body, {
                    opacity: 0,
                    y: 10
                }, {
                    opacity: 1,
                    y: 0,
                    duration: 0.5,
                    delay: 0.1,
                    ease: 'power2.out',
                    overwrite: true
                });
            } else {
                panel.style.height = 'auto';
            }
        }

        window.toggleFaq = function(button) {
            const item = button.closest('.faq-item');
            if (!item) return;
            const wasOpen = item.classList.contains('is-open');
            document.querySelectorAll('.faq-item.is-open').forEach(o => {
                if (o !== item) closeFaq(o);
            });
            wasOpen ? closeFaq(item) : openFaq(item);
        };
    })();

    // ==========================================
    // 9. CART FLY ANIMATION, WEB AUDIO SFX & BUY NOW
    // ==========================================
    (function() {
        // 🔊 Suara disintesis dengan Web Audio (tanpa file mp3). Matikan: localStorage.setItem('loka-sound','off')
        var actx;

        function soundOn() {
            try {
                return localStorage.getItem('loka-sound') !== 'off';
            } catch (e) {
                return true;
            }
        }

        function audio() {
            try {
                actx = actx || new(window.AudioContext || window.webkitAudioContext)();
                if (actx.state === 'suspended') actx.resume();
            } catch (e) {}
            return soundOn() ? actx : null;
        }

        function tone(f0, f1, t0, dur, type, vol) {
            var c = audio();
            if (!c) return;
            var o = c.createOscillator(),
                g = c.createGain(),
                t = c.currentTime + t0;
            o.type = type;
            o.frequency.setValueAtTime(f0, t);
            o.frequency.exponentialRampToValueAtTime(f1, t + dur);
            g.gain.setValueAtTime(0.0001, t);
            g.gain.exponentialRampToValueAtTime(vol, t + .015);
            g.gain.exponentialRampToValueAtTime(0.0001, t + dur);
            o.connect(g);
            g.connect(c.destination);
            o.start(t);
            o.stop(t + dur + .03);
        }

        function sfxStart() {
            tone(420, 760, 0, .09, 'triangle', .16);
            tone(300, 1100, .05, .6, 'sine', .05);
        } // pop + whoosh
        function sfxDing() {
            tone(1318, 1318, 0, .4, 'sine', .15);
            tone(1760, 1760, .09, .55, 'sine', .12);
        } // ding
        var CHECK = '<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>';
        // ⏳ Spinner untuk tombol keranjang selama menunggu (loading)
        var SPIN = '<svg class="w-[18px] h-[18px] animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".25" stroke-width="3"/><path d="M21 12a9 9 0 00-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>';

        // Elemen dianggap "terlihat" bila ukurannya > 0, ada di layar, dan tidak ada induk yang transparan/hidden
        function usable(el) {
            if (!el) return false;
            var r = el.getBoundingClientRect();
            if (r.width <= 0 || r.height <= 0) return false;
            if (r.bottom <= 0 || r.top >= window.innerHeight || r.right <= 0 || r.left >= window.innerWidth) return false;
            for (var n = el; n && n !== document.body; n = n.parentElement) {
                var cs = getComputedStyle(n);
                if (cs.display === 'none' || cs.visibility === 'hidden' || parseFloat(cs.opacity) < .3) return false;
            }
            return true;
        }

        // Saat scroll: header menyusut ke kiri, tujuan = kartu "Your Cart" kanan-atas. Di atas: ikon keranjang header.
        function cartTarget() {
            var sel = {
                header: '[data-cart-target="header"], #header-right a[href*="cart"]',
                float: '[data-cart-target="float"], #floating-cart a[href*="cart"]'
            };
            var order = window.scrollY > 80 ? ['float', 'header'] : ['header', 'float'];
            for (var i = 0; i < order.length; i++) {
                var list = document.querySelectorAll(sel[order[i]]);
                for (var j = 0; j < list.length; j++)
                    if (usable(list[j])) return list[j];
            }
            var any = document.querySelectorAll('[data-cart-target], a[href*="cart"]');
            for (var k = 0; k < any.length; k++)
                if (usable(any[k])) return any[k];
            return null;
        }

        function pulse(t) {
            sfxDing();
            t.animate([{
                transform: 'scale(1)'
            }, {
                transform: 'scale(1.35)'
            }, {
                transform: 'scale(1)'
            }], {
                duration: 520,
                easing: 'cubic-bezier(.34,1.56,.64,1)'
            });
            var r = t.getBoundingClientRect(),
                ring = document.createElement('div');
            ring.style.cssText = 'position:fixed;z-index:9998;pointer-events:none;border-radius:50%;border:2px solid #38bdf8;left:' + r.left + 'px;top:' + r.top + 'px;width:' + r.width + 'px;height:' + r.height + 'px';
            document.body.appendChild(ring);
            ring.animate([{
                transform: 'scale(1)',
                opacity: .9
            }, {
                transform: 'scale(2.2)',
                opacity: 0
            }], {
                duration: 650,
                easing: 'ease-out'
            }).onfinish = function() {
                ring.remove();
            };
        }

        // Bola kaca berisi emoji produk melengkung terbang ke keranjang header
        function fly(src, target, emoji) {
            return new Promise(function(done) {
                if (prefersReducedMotion) {
                    pulse(target);
                    return done();
                }
                var s = src.getBoundingClientRect(),
                    t = target.getBoundingClientRect(),
                    size = 56;
                var x0 = s.left + s.width / 2 - size / 2,
                    y0 = s.top + s.height / 2 - size / 2;
                var dx = t.left + t.width / 2 - size / 2 - x0,
                    dy = t.top + t.height / 2 - size / 2 - y0;
                var o = document.createElement('div'),
                    i = document.createElement('div');
                o.style.cssText = 'position:fixed;z-index:9999;pointer-events:none;width:' + size + 'px;height:' + size + 'px;left:' + x0 + 'px;top:' + y0 + 'px';
                i.className = 'lg lg-soft';
                i.style.cssText = 'width:100%;height:100%;border-radius:50%;display:grid;place-items:center;font-size:28px;line-height:1';
                i.textContent = emoji;
                o.appendChild(i);
                document.body.appendChild(o);
                o.animate([{
                    transform: 'translateX(0)'
                }, {
                    transform: 'translateX(' + dx + 'px)'
                }], {
                    duration: 900,
                    easing: 'cubic-bezier(.22,.8,.36,1)',
                    fill: 'forwards'
                });
                i.animate([{
                    transform: 'translateY(0) scale(1) rotate(0deg)',
                    opacity: 1
                }, {
                    transform: 'translateY(' + dy + 'px) scale(.35) rotate(360deg)',
                    opacity: .85
                }], {
                    duration: 900,
                    easing: 'cubic-bezier(.55,0,.9,.5)',
                    fill: 'forwards'
                }).onfinish = function() {
                    o.remove();
                    pulse(target);
                    done();
                };
            });
        }

        function bump() {
            var touched = false;
            document.querySelectorAll('[data-cart-count]').forEach(function(el) {
                touched = true;
                el.textContent = el.textContent.replace(/\d+/, function(n) {
                    return +n + 1;
                });
            });
            if (touched) return;
            // fallback untuk header & kartu "Your Cart" bawaan layout
            var fp = document.querySelector('#floating-cart .font-bold');
            if (fp) fp.textContent = fp.textContent.replace(/\d+/, function(n) {
                return +n + 1;
            });
            var hl = document.querySelector('#header-right a[href*="cart"]');
            if (hl) {
                var badge = hl.querySelector('span.absolute');
                if (badge) {
                    badge.textContent = (parseInt(badge.textContent, 10) || 0) + 1;
                } else {
                    badge = document.createElement('span');
                    badge.className = 'absolute -top-1.5 -right-2 inline-flex items-center justify-center px-1 py-0.5 text-[9px] font-bold text-white bg-blue-600 rounded-full';
                    badge.textContent = '1';
                    hl.appendChild(badge);
                }
            }
        }

        function flash(b) {
            // pakai isi tombol asli yang disimpan sebelum spinner ditampilkan
            var html = b.dataset.html || b.innerHTML;
            b.innerHTML = CHECK + (b.dataset.label === 'buy' ? '<span>Added</span>' : '');
            setTimeout(function() {
                b.innerHTML = html;
                b.dataset.busy = '';
            }, 1400);
        }

        // 🛍️ Buy Now (versi lama via data-buy): tambahkan ke keranjang lalu PINDAH halaman.
        //    Tombol Buy Now di Shop sekarang berupa link [data-instant][data-loading] (lihat bagian 11).
        function buyNow(b, form) {
            b.dataset.busy = '1';
            tone(420, 760, 0, .09, 'triangle', .16);
            var html = b.innerHTML;
            b.innerHTML = '<svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".25" stroke-width="3"/><path d="M21 12a9 9 0 00-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg><span>Processing…</span>';
            var go = function() {
                location.href = b.getAttribute('data-buy');
            };
            if (!form) {
                setTimeout(function() {
                    b.innerHTML = html;
                    b.dataset.busy = '';
                    (window.onLokaBuy || go)(b);
                }, 500);
                return;
            }
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            }).then(function(res) {
                if (res.redirected && /login/i.test(res.url)) {
                    location.href = res.url;
                    return;
                }
                if (!res.ok) throw new Error('add failed');
                go();
            }).catch(function() {
                form.submit();
            });
        }

        document.addEventListener('click', function(e) {
            var b = e.target.closest('[data-fly],[data-buy]');
            if (!b) return;
            e.preventDefault();
            if (b.dataset.busy) return;
            if (b.hasAttribute('data-buy')) {
                buyNow(b, b.getAttribute('form') && document.getElementById(b.getAttribute('form')));
                return;
            }
            b.dataset.busy = '1';
            sfxStart();
            // ⏳ loading: simpan isi asli tombol, tampilkan spinner sampai selesai
            b.dataset.html = b.innerHTML;
            b.innerHTML = SPIN;

            var card = b.closest('article'),
                srcEl = card && card.querySelector('[data-fly-src]'),
                target = cartTarget();
            var form = b.getAttribute('form') && document.getElementById(b.getAttribute('form'));
            var anim = (srcEl && target) ? fly(srcEl, target, srcEl.textContent.trim()) : Promise.resolve();
            var post = form ? fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html'
                }
            }) : Promise.resolve(null);

            Promise.all([anim, post]).then(function(r) {
                var res = r[1];
                if (res && res.redirected && /login/i.test(res.url)) {
                    location.href = res.url;
                    return;
                }
                if (res && !res.ok) throw new Error('add failed');
                bump();
                flash(b);
            }).catch(function() {
                b.dataset.busy = '';
                if (b.dataset.html) b.innerHTML = b.dataset.html;
                if (form) form.submit();
            });
        });
    })();

    // ==========================================
    // 10. SHOP — filter kategori & pencarian TANPA reload
    //     (tidak ada preloader, transisi halaman, atau animasi loading)
    // ==========================================
    (function() {
        var dyn = document.getElementById('shop-dynamic');
        if (!dyn) return;
        var seq = 0;

        function reveal() {
            // kartu hasil AJAX langsung tampil (CSS .stagger-item default opacity 0)
            dyn.querySelectorAll('.stagger-item').forEach(function(el) {
                el.style.opacity = 1;
                el.style.transform = 'none';
            });
        }

        function swap(url, push) {
            var my = ++seq;
            fetch(url, {
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'text/html'
                    }
                })
                .then(function(r) {
                    if (!r.ok) throw new Error('bad');
                    return r.text();
                })
                .then(function(html) {
                    if (my !== seq) return; // abaikan respons lama
                    var doc = new DOMParser().parseFromString(html, 'text/html');
                    var next = doc.getElementById('shop-dynamic');
                    if (!next) throw new Error('no-dyn');
                    dyn.innerHTML = next.innerHTML;
                    reveal();
                    if (push) {
                        try {
                            history.pushState({
                                shop: 1
                            }, '', url);
                        } catch (e) {}
                    }
                    var q = new URL(url, location.href).searchParams.get('search');
                    var input = document.querySelector('#search-bar input[name="search"]');
                    if (input) input.value = q || '';
                })
                .catch(function() {
                    location.href = url; // fallback aman: navigasi biasa
                });
        }

        // Fase capture di window → jalan sebelum handler transisi halaman milik layout
        window.addEventListener('click', function(e) {
            if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
            var a = e.target.closest && e.target.closest('a[data-shop-nav]');
            if (!a) return;
            e.preventDefault();
            e.stopImmediatePropagation();
            swap(a.href, true);
        }, true);

        var form = document.getElementById('search-bar');
        if (form) form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var q = form.querySelector('input[name="search"]').value.trim();
            var base = form.getAttribute('action');
            swap(q ? base + '?search=' + encodeURIComponent(q) : base, true);
        }, true);

        window.addEventListener('popstate', function() {
            swap(location.href, false);
        });
    })();

    // ==========================================
    // 11. INSTANT NAV — pindah halaman tanpa preloader/transisi.
    //     Klik produk: pindah langsung ke detail.
    //     Buy Now: spinner di tombol, lalu langsung ke checkout.
    // ==========================================
    (function() {
        var SPIN = '<svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".25" stroke-width="3"/><path d="M21 12a9 9 0 00-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>';

        // Fase capture di window → jalan sebelum handler transisi halaman milik layout
        window.addEventListener('click', function(e) {
            if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
            var a = e.target.closest && e.target.closest('a[data-instant]');
            if (!a) return;
            e.preventDefault();
            e.stopImmediatePropagation();

            if (a.hasAttribute('data-loading')) {
                if (a.dataset.busy) return;
                a.dataset.busy = '1';
                a.style.pointerEvents = 'none';
                a.innerHTML = '<span class="inline-flex items-center gap-2">' + SPIN + '<span>Processing…</span></span>';
                setTimeout(function() {
                    location.href = a.href;
                }, 700);
                return;
            }
            location.href = a.href; // klik produk: pindah langsung
        }, true);

        // Prefetch halaman tujuan saat kursor lewat → terasa instan
        var done = {};
        document.addEventListener('pointerover', function(e) {
            var a = e.target.closest && e.target.closest('a[data-instant]');
            if (!a || done[a.href]) return;
            done[a.href] = 1;
            var l = document.createElement('link');
            l.rel = 'prefetch';
            l.href = a.href;
            document.head.appendChild(l);
        });

        // Tombol Back browser: reset tombol yang sempat berputar
        window.addEventListener('pageshow', function(e) {
            if (e.persisted) location.reload();
        });
    })();

    // ==========================================
    // 12. BUY NOW CHECKOUT — kalkulator qty, ongkir & GPS
    // ==========================================
    (function() {
        var q = document.getElementById('q');
        if (!q) return;

        var price = parseFloat(q.dataset.price) || 0;
        var maxStock = Math.max(1, parseInt(q.getAttribute('max'), 10) || 99);

        function rp(n) {
            return 'Rp ' + Math.round(n).toLocaleString('id-ID');
        }

        function calc() {
            var v = Math.max(1, Math.min(maxStock, parseInt(q.value, 10) || 1));
            q.value = v;
            var sel = document.querySelector('input[name="shipping"]:checked');
            var ship = sel ? +sel.dataset.cost : 0;
            var oSub = document.getElementById('o-sub');
            var oShip = document.getElementById('o-ship');
            var oTotal = document.getElementById('o-total');
            if (oSub) oSub.textContent = rp(price * v);
            if (oShip) oShip.textContent = rp(ship);
            if (oTotal) oTotal.textContent = rp(price * v + ship);
        }

        var btnMinus = document.getElementById('q-minus');
        var btnPlus = document.getElementById('q-plus');
        if (btnMinus) btnMinus.onclick = function() {
            q.value = (+q.value || 1) - 1;
            calc();
        };
        if (btnPlus) btnPlus.onclick = function() {
            q.value = (+q.value || 1) + 1;
            calc();
        };
        q.addEventListener('input', calc);
        document.querySelectorAll('input[name="shipping"]').forEach(function(r) {
            r.addEventListener('change', calc);
        });
        calc();

        // Ambil koordinat pengiriman otomatis (opsional)
        var latInput = document.getElementById('shipping_latitude');
        var lngInput = document.getElementById('shipping_longitude');
        if (latInput && lngInput && !latInput.value && 'geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(function(pos) {
                latInput.value = pos.coords.latitude;
                lngInput.value = pos.coords.longitude;
            }, function() {}, {
                timeout: 8000
            });
        }
    })();

    // ==========================================
    // 13. PRODUCT DETAIL (show.blade.php) — sinkronisasi qty ke Buy Now & Cart
    // ==========================================
    (function() {
        var qty = document.getElementById('qty'),
            buy = document.getElementById('buy-link'),
            cart = document.getElementById('cart-qty');
        if (!qty || !buy || !cart) return;

        var base = buy.getAttribute('href'),
            maxStock = Math.max(1, parseInt(qty.getAttribute('max'), 10) || 99);

        function sync() {
            var v = Math.max(1, Math.min(maxStock, parseInt(qty.value, 10) || 1));
            qty.value = v;
            cart.value = v;
            buy.setAttribute('href', base + '?qty=' + v);
        }

        var btnMinus = document.getElementById('qty-minus');
        var btnPlus = document.getElementById('qty-plus');
        if (btnMinus) btnMinus.onclick = function() {
            qty.value = (+qty.value || 1) - 1;
            sync();
        };
        if (btnPlus) btnPlus.onclick = function() {
            qty.value = (+qty.value || 1) + 1;
            sync();
        };
        qty.addEventListener('input', sync);
    })();

    /* Halaman About — animasi GSAP (butuh gsap + ScrollTrigger dari layout) */
    (function() {
        function run() {
            if (typeof gsap === 'undefined' || matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            var ST = window.ScrollTrigger;
            if (ST) gsap.registerPlugin(ST);
            var q = function(s, c) {
                return Array.prototype.slice.call((c || document).querySelectorAll(s));
            };

            // 1) Header masuk berurutan (blur -> tajam)
            gsap.from(q('.about-head > :not(.sparkle)'), {
                y: 34,
                opacity: 0,
                filter: 'blur(10px)',
                duration: 1,
                stagger: .14,
                ease: 'power3.out',
                delay: .15
            });
            // 0) Sentuhan air: riak menyebar dari titik kursor + badan kartu bergoyang seperti jeli
            function ripple(el, x, y, big) {
                var b = el.getBoundingClientRect(),
                    d = Math.hypot(b.width, b.height);
                [0].forEach(function(delay, i) {
                    var s = document.createElement('span');
                    s.className = 'water-ripple' + (big ? ' dot-ripple' : '');
                    s.style.left = x + 'px';
                    s.style.top = y + 'px';
                    el.appendChild(s);
                    gsap.fromTo(s, {
                        xPercent: -50,
                        yPercent: -50,
                        scale: 0,
                        opacity: i ? .6 : .95
                    }, {
                        scale: big ? d / 14 : d / 9,
                        opacity: 0,
                        duration: 1.4,
                        delay: delay,
                        ease: 'power2.out',
                        onComplete: function() {
                            s.remove();
                        }
                    });
                });
            }
            q('.step-card, .about-stat, .step-dot').forEach(function(el) {
                var dot = el.classList.contains('step-dot'),
                    last = 0,
                    lx = -999,
                    ly = -999;

                function pos(e) {
                    var b = el.getBoundingClientRect();
                    return [e.clientX - b.left, e.clientY - b.top];
                }
                el.addEventListener('pointerenter', function(e) {
                    var p = pos(e);
                    ripple(el, p[0], p[1], dot);
                    last = Date.now();
                    lx = p[0];
                    ly = p[1];
                    gsap.timeline({
                            defaults: {
                                overwrite: 'auto'
                            }
                        })
                        .to(el, {
                            scaleX: dot ? 1.18 : 1.035,
                            scaleY: dot ? .86 : .965,
                            y: dot ? 0 : -6,
                            duration: .16,
                            ease: 'power2.out'
                        })
                        .to(el, {
                            scaleX: 1,
                            scaleY: 1,
                            duration: 1.1,
                            ease: 'elastic.out(1,.32)'
                        });
                });
                el.addEventListener('pointerleave', function() {
                    gsap.to(el, {
                        y: 0,
                        scaleX: 1,
                        scaleY: 1,
                        duration: .9,
                        ease: 'elastic.out(1,.4)',
                        overwrite: 'auto'
                    });
                });
            });

            if (!ST) return;

            // 2) Kutipan muncul kata per kata
            q('[data-split]').forEach(function(el) {
                (function walk(n) {
                    Array.prototype.slice.call(n.childNodes).forEach(function(c) {
                        if (c.nodeType === 3) {
                            var f = document.createDocumentFragment();
                            c.textContent.split(/(\s+)/).forEach(function(t) {
                                if (!t) return;
                                if (/^\s+$/.test(t)) {
                                    f.appendChild(document.createTextNode(' '));
                                    return;
                                }
                                var s = document.createElement('span');
                                s.className = 'w';
                                s.style.display = 'inline-block';
                                s.textContent = t;
                                f.appendChild(s);
                            });
                            n.replaceChild(f, c);
                        } else if (c.nodeType === 1) walk(c);
                    });
                })(el);
                gsap.from(q('.w', el), {
                    opacity: 0,
                    y: 22,
                    filter: 'blur(8px)',
                    duration: .8,
                    stagger: .045,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 82%'
                    }
                });
            });

            // 3) Kartu statistik: muncul memantul + hitung naik untuk angka persen
            gsap.from('.about-stat', {
                y: 40,
                opacity: 0,
                scale: .92,
                duration: .8,
                stagger: .12,
                ease: 'back.out(1.4)',
                clearProps: 'transform,opacity',
                scrollTrigger: {
                    trigger: '.about-stat',
                    start: 'top 88%'
                }
            });
            q('.about-stat b').forEach(function(b) {
                var m = /^(\d+)%$/.exec(b.textContent.trim());
                if (!m) return;
                var o = {
                        v: 0
                    },
                    end = +m[1];
                b.textContent = '0%';
                gsap.to(o, {
                    v: end,
                    duration: 1.8,
                    ease: 'power2.out',
                    scrollTrigger: {
                        trigger: b,
                        start: 'top 88%'
                    },
                    onUpdate: function() {
                        b.textContent = Math.round(o.v) + '%';
                    }
                });
            });

            // 4) Timeline: garis tergambar, lingkaran emas muncul berputar, kartu naik
            var line = document.getElementById('tl-line');
            if (line) {
                gsap.set(line, {
                    transformOrigin: '0 50%',
                    scaleX: 0
                });
                gsap.to(line, {
                    scaleX: 1,
                    duration: 1.6,
                    ease: 'power2.inOut',
                    scrollTrigger: {
                        trigger: line,
                        start: 'top 85%'
                    }
                });
            }
            gsap.from('.step-dot', {
                scale: 0,
                rotation: -120,
                opacity: 0,
                duration: .8,
                stagger: .25,
                ease: 'back.out(2)',
                scrollTrigger: {
                    trigger: '.step-dot',
                    start: 'top 88%'
                }
            });
            gsap.from('.step-card', {
                y: 36,
                opacity: 0,
                duration: .8,
                stagger: .25,
                ease: 'power3.out',
                clearProps: 'transform,opacity',
                scrollTrigger: {
                    trigger: '.step-card',
                    start: 'top 90%'
                }
            });

            // 5) Foto: paralaks saat scroll
            q('.about-par').forEach(function(p) {
                gsap.fromTo(p, {
                    yPercent: -6
                }, {
                    yPercent: 6,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: p.parentNode,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub: true
                    }
                });
            });

            // 6) Bingkai foto miring 3D mengikuti kursor
            q('.about-tilt').forEach(function(f) {
                gsap.set(f, {
                    transformPerspective: 900
                });
                var rx = gsap.quickTo(f, 'rotationX', {
                        duration: .5,
                        ease: 'power2.out'
                    }),
                    ry = gsap.quickTo(f, 'rotationY', {
                        duration: .5,
                        ease: 'power2.out'
                    });
                f.addEventListener('pointermove', function(e) {
                    var r = f.getBoundingClientRect();
                    ry(((e.clientX - r.left) / r.width - .5) * 12);
                    rx(-((e.clientY - r.top) / r.height - .5) * 12);
                });
                f.addEventListener('pointerleave', function() {
                    rx(0);
                    ry(0);
                });
            });

            // 7) CTA: tombol muncul bergantian
            gsap.from('.auto-shine, .auto-shine + a', {
                y: 24,
                opacity: 0,
                duration: .8,
                stagger: .12,
                ease: 'power3.out',
                clearProps: 'transform,opacity',
                scrollTrigger: {
                    trigger: '.auto-shine',
                    start: 'top 92%'
                }
            });
        }
        if (document.readyState === 'complete') run();
        else window.addEventListener('load', run);
    })();

    /* Halaman Contact — interaksi & animasi.
   gsap, ScrollTrigger & Leaflet berasal dari layout; semuanya opsional (ada pengaman jika tidak termuat). */
    (function() {
        'use strict';

        var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var $ = function(s, c) {
            return (c || document).querySelector(s);
        };
        var $$ = function(s, c) {
            return Array.prototype.slice.call((c || document).querySelectorAll(s));
        };

        /* ------------------------------------------------------------------ */
        /* 1) JAM OPERASIONAL — status online real-time (WIB, Senin–Jumat 8–17) */
        /* ------------------------------------------------------------------ */
        var DAYS = {
            Sun: 0,
            Mon: 1,
            Tue: 2,
            Wed: 3,
            Thu: 4,
            Fri: 5,
            Sat: 6
        };

        function jakartaNow() {
            var parts = new Intl.DateTimeFormat('en-US', {
                timeZone: 'Asia/Jakarta',
                weekday: 'short',
                hour: 'numeric',
                minute: 'numeric',
                hour12: false
            }).formatToParts(new Date());
            var o = {};
            parts.forEach(function(p) {
                o[p.type] = p.value;
            });
            return {
                d: DAYS[o.weekday],
                h: parseInt(o.hour, 10) % 24,
                m: parseInt(o.minute, 10)
            };
        }

        function initHours() {
            var chip = $('#office-status'),
                badge = $('#office-badge'),
                detail = $('#office-detail');
            if (!chip && !badge) return;

            function tick() {
                var n = jakartaNow();
                var weekday = n.d >= 1 && n.d <= 5;
                var open = weekday && n.h >= 8 && n.h < 17;
                var when;

                if (open) when = 'Open now · closes at 5:00 PM WIB';
                else if (weekday && n.h < 8) when = 'Closed now · opens today at 8:00 AM WIB';
                else if (n.d >= 1 && n.d <= 4) when = 'Closed now · opens tomorrow at 8:00 AM WIB';
                else when = 'Closed now · opens Monday at 8:00 AM WIB';

                if (chip) {
                    chip.classList.toggle('is-open', open);
                    $('[data-status-text]', chip).textContent = open ? 'We’re online now' : 'Offline · we’ll reply next business day';
                }
                if (badge) {
                    badge.classList.toggle('is-open', open);
                    $('[data-badge-text]', badge).textContent = open ? 'Open' : 'Closed';
                }
                if (detail) detail.textContent = when;

                $$('.day').forEach(function(el) {
                    var d = parseInt(el.dataset.d, 10);
                    el.classList.toggle('is-open', d >= 1 && d <= 5);
                    el.classList.toggle('is-today', d === n.d);
                });
            }

            tick();
            setInterval(tick, 60000);
        }

        /* ------------------------------------------------------------------ */
        /* 2) SALIN KE CLIPBOARD                                              */
        /* ------------------------------------------------------------------ */
        function copyText(text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                return navigator.clipboard.writeText(text);
            }
            return new Promise(function(resolve, reject) {
                var t = document.createElement('textarea');
                t.value = text;
                t.style.cssText = 'position:fixed;opacity:0';
                document.body.appendChild(t);
                t.select();
                try {
                    document.execCommand('copy') ? resolve() : reject();
                } catch (e) {
                    reject(e);
                }
                t.remove();
            });
        }

        function initCopy() {
            $$('[data-copy]').forEach(function(btn) {
                var label = $('.copy-label', btn) || btn;
                var original = label.textContent;
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    copyText(btn.dataset.copy).then(function() {
                        label.textContent = 'Copied ✓';
                        btn.classList.add('is-done');
                        setTimeout(function() {
                            label.textContent = original;
                            btn.classList.remove('is-done');
                        }, 1600);
                    }).catch(function() {
                        label.textContent = 'Press Ctrl+C';
                        setTimeout(function() {
                            label.textContent = original;
                        }, 1600);
                    });
                });
            });
        }

        /* ------------------------------------------------------------------ */
        /* 3) FORM: topik, penghitung huruf, auto-tinggi, kirim + animasi     */
        /* ------------------------------------------------------------------ */
        function burst(card, from) {
            if (reduce || !card || !from) return;
            var cr = card.getBoundingClientRect(),
                fr = from.getBoundingClientRect();
            var cx = fr.left - cr.left + fr.width / 2,
                cy = fr.top - cr.top + fr.height / 2;

            for (var i = 0; i < 18; i++) {
                var s = document.createElement('span');
                s.className = 'burst-star';
                s.textContent = i % 3 ? '✦' : '★';
                s.style.left = cx + 'px';
                s.style.top = cy + 'px';
                s.style.fontSize = (10 + Math.random() * 14) + 'px';
                card.appendChild(s);

                var a = Math.random() * Math.PI * 2,
                    r = 70 + Math.random() * 140;
                var tx = Math.cos(a) * r,
                    ty = Math.sin(a) * r - 30;
                s.animate([{
                        transform: 'translate(-50%,-50%) scale(.3) rotate(0deg)',
                        opacity: 1
                    },
                    {
                        transform: 'translate(calc(-50% + ' + tx + 'px), calc(-50% + ' + ty + 'px)) scale(1) rotate(' + (Math.random() * 240 - 120) + 'deg)',
                        opacity: 0
                    }
                ], {
                    duration: 900 + Math.random() * 500,
                    easing: 'cubic-bezier(.2,.8,.2,1)'
                }).onfinish = (function(el) {
                    return function() {
                        el.remove();
                    };
                })(s);
            }
        }

        function initForm() {
            var form = $('#contact-form');
            if (!form) return;

            var card = $('#contact-card'),
                btn = $('#send-btn'),
                label = $('.btn-label', btn);
            var msg = $('#msg'),
                count = $('#msg-count'),
                msgLabel = $('#msg-label');
            var success = $('#form-success'),
                again = $('#send-again');
            var btnText = label.textContent;

            function applyHint() {
                var checked = $('input[name="topic"]:checked', form);
                if (checked && checked.dataset.hint && msgLabel) msgLabel.textContent = checked.dataset.hint;
            }
            $$('input[name="topic"]', form).forEach(function(r) {
                r.addEventListener('change', applyHint);
            });

            function updateCount() {
                var len = msg.value.length,
                    max = parseInt(msg.getAttribute('maxlength'), 10) || 500;
                count.textContent = len + ' / ' + max;
                count.classList.toggle('is-near', len > max * 0.85);
                msg.style.height = 'auto';
                msg.style.height = Math.min(msg.scrollHeight + 2, 260) + 'px';
            }
            msg.addEventListener('input', updateCount);
            updateCount();

            form.addEventListener('submit', function(e) {
                if (btn.dataset.busy) {
                    e.preventDefault();
                    return;
                }
                btn.dataset.busy = '1';
                btn.classList.add('is-loading');
                label.textContent = 'Sending…';

                // Kirim asli ke server bila action sudah diganti (bukan "#")
                if ((form.getAttribute('action') || '#') !== '#') return;

                // Mode demo: simulasikan pengiriman
                e.preventDefault();
                setTimeout(function() {
                    var plane = $('.plane', btn);
                    if (plane && !reduce) {
                        plane.animate([{
                                transform: 'translate(0,0) rotate(0deg)',
                                opacity: 1
                            },
                            {
                                transform: 'translate(70px,-46px) rotate(-18deg)',
                                opacity: 0
                            }
                        ], {
                            duration: 650,
                            easing: 'cubic-bezier(.5,0,.9,.5)',
                            fill: 'forwards'
                        });
                    }
                    label.textContent = 'Sent ✓';
                    btn.classList.remove('is-loading');

                    setTimeout(function() {
                        card.classList.add('is-sent');
                        success.setAttribute('aria-hidden', 'false');
                        setTimeout(function() {
                            burst(card, $('.success-check', card));
                        }, 380);
                    }, 550);
                }, 1100);
            });

            if (again) again.addEventListener('click', function() {
                card.classList.remove('is-sent');
                success.setAttribute('aria-hidden', 'true');
                form.reset();
                applyHint();
                updateCount();
                var plane = $('.plane', btn);
                if (plane) {
                    plane.getAnimations().forEach(function(a) {
                        a.cancel();
                    });
                }
                btn.dataset.busy = '';
                label.textContent = btnText;
            });
        }

        /* ------------------------------------------------------------------ */
        /* 4) KEMBALI KE ATAS                                                 */
        /* ------------------------------------------------------------------ */
        function initTop() {
            $$('[data-top]').forEach(function(a) {
                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: reduce ? 'auto' : 'smooth'
                    });
                });
            });
        }

        /* ------------------------------------------------------------------ */
        /* 5) PETA (Leaflet dari layout)                                      */
        /* ------------------------------------------------------------------ */
        function initMap() {
            var el = $('#contact-map');
            if (!el || typeof L === 'undefined') return;

            var pos = [0.5626183, 101.4267777]; // lokasi kantor Loka (dari Google Maps)
            var map = L.map(el, {
                scrollWheelZoom: false,
                zoomControl: true
            }).setView(pos, 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker(pos, {
                icon: L.divIcon({
                    className: 'loka-pin-wrap',
                    html: '<div class="loka-pin"><i></i><b>✦</b></div>',
                    iconSize: [44, 44],
                    iconAnchor: [22, 22]
                })
            }).addTo(map);

            // Scroll-zoom hanya aktif setelah peta diklik, agar scroll halaman tidak "tersangkut"
            map.on('click', function() {
                map.scrollWheelZoom.enable();
            });
            el.addEventListener('mouseleave', function() {
                map.scrollWheelZoom.disable();
            });

            // Ukuran peta dihitung ulang setelah animasi kemunculan selesai
            [300, 900, 1800].forEach(function(t) {
                setTimeout(function() {
                    map.invalidateSize();
                }, t);
            });
            window.addEventListener('resize', function() {
                map.invalidateSize();
            });
        }

        /* ------------------------------------------------------------------ */
        /* 6) ANIMASI GSAP (melengkapi animasi About dari layout)             */
        /* ------------------------------------------------------------------ */
        function initMotion() {
            if (typeof gsap === 'undefined' || reduce) return;
            var ST = window.ScrollTrigger;
            if (!ST) return;
            gsap.registerPlugin(ST);

            // Isi form masuk berurutan
            gsap.from('.contact-form [data-in]', {
                y: 22,
                opacity: 0,
                duration: .8,
                stagger: .1,
                ease: 'power3.out',
                clearProps: 'transform,opacity',
                scrollTrigger: {
                    trigger: '.contact-form',
                    start: 'top 82%'
                }
            });

            // Chip topik muncul memantul
            gsap.from('.topic-chip', {
                scale: .6,
                opacity: 0,
                duration: .6,
                stagger: .08,
                ease: 'back.out(2)',
                clearProps: 'transform,opacity',
                scrollTrigger: {
                    trigger: '.topic-chip',
                    start: 'top 88%'
                }
            });

            // Hari operasional muncul memantul
            gsap.from('.day', {
                scale: 0,
                opacity: 0,
                duration: .6,
                stagger: .07,
                ease: 'back.out(2.2)',
                clearProps: 'transform,opacity',
                scrollTrigger: {
                    trigger: '#week-days',
                    start: 'top 90%'
                }
            });
        }

        /* ------------------------------------------------------------------ */
        function boot() {
            initHours();
            initCopy();
            initForm();
            initTop();
        }

        function late() {
            initMap();
            initMotion();
        }

        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', boot);
        else boot();

        if (document.readyState === 'complete') late();
        else window.addEventListener('load', late);
    })();

    /* Courier Dashboard — logika (GPS, status, withdraw, profil, grafik) + animasi.
   Pengganti courier-dashboard.js lama. Jika bagian "COURIER DASHBOARD" masih ada di script global layout, hapus dari sana agar tidak ganda. */
    (function() {
        var app = document.getElementById('courier-app');
        if (!app) return;
        var D = app.dataset,
            csrf = D.csrf,
            balance = parseFloat(D.balance) || 0;
        var $ = function(id) {
            return document.getElementById(id);
        };
        var reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;
        var small = matchMedia('(max-width: 767px)').matches;
        var reload = function() {
            (window.courierReload || function() {
                location.reload();
            })();
        };
        var JSONH = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf
        };

        /* ---------- Toast ---------- */
        var tt;
        window.showCourierToast = function(msg) {
            var t = $('toast'),
                m = $('toast-message');
            if (!t || !m) return;
            m.textContent = msg;
            t.classList.remove('translate-y-20', 'opacity-0');
            t.classList.add('translate-y-0', 'opacity-100');
            clearTimeout(tt);
            tt = setTimeout(function() {
                t.classList.remove('translate-y-0', 'opacity-100');
                t.classList.add('translate-y-20', 'opacity-0');
            }, 3000);
        };

        /* ---------- GPS ---------- */
        var dot = $('gps-dot'),
            text = $('gps-text'),
            badge = $('gps-badge'),
            warning = $('offline-warning'),
            watchId = null;

        function setGps(active, label) {
            if (!dot || !badge || !text) return;
            dot.className = 'cd-dot' + (active ? ' is-on' : '');
            badge.className = 'lg lg-soft cd-gps' + (active ? ' is-on' : '');
            text.textContent = label;
        }

        function startGps() {
            if (!('geolocation' in navigator)) return setGps(false, 'No GPS Support');
            if (watchId) return;
            var last = 0;
            watchId = navigator.geolocation.watchPosition(function(pos) {
                setGps(true, 'GPS Active');
                var now = Date.now();
                if (now - last < 15000) return;
                last = now;
                fetch(D.routeLocation, {
                    method: 'POST',
                    headers: JSONH,
                    body: JSON.stringify({
                        latitude: pos.coords.latitude,
                        longitude: pos.coords.longitude
                    })
                }).catch(function() {});
            }, function() {
                setGps(false, 'GPS Denied');
            }, {
                enableHighAccuracy: false,
                maximumAge: 15000,
                timeout: 30000
            });
        }

        function stopGps() {
            if (watchId) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }
            setGps(false, 'Location Inactive');
        }

        /* ---------- Tombol status ---------- */
        var ICON_OFF = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>';
        var ICON_ON = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>';
        var btn = $('btn-status');
        if (btn) btn.addEventListener('click', function() {
            var next = btn.dataset.status === 'offline' ? 'available' : 'offline';
            var bt = $('btn-text'),
                bi = $('btn-icon'),
                bs = $('btn-spinner');
            btn.disabled = true;
            bi.classList.add('hidden');
            bs.classList.remove('hidden');
            fetch(D.routeStatus, {
                    method: 'POST',
                    headers: JSONH,
                    body: JSON.stringify({
                        status: next
                    })
                })
                .then(function(r) {
                    return r.json().then(function(d) {
                        return {
                            ok: r.ok,
                            d: d
                        };
                    });
                })
                .then(function(r) {
                    if (!r.ok) return showCourierToast(r.d.error || 'Something went wrong');
                    btn.dataset.status = next;
                    showCourierToast(r.d.success);
                    if (next === 'available') {
                        bt.textContent = 'Go Offline';
                        btn.classList.add('is-online');
                        if (warning) warning.classList.add('hidden');
                        bi.innerHTML = ICON_OFF;
                        startGps();
                    } else {
                        bt.textContent = 'Start Working';
                        btn.classList.remove('is-online');
                        if (warning) warning.classList.remove('hidden');
                        bi.innerHTML = ICON_ON;
                        stopGps();
                    }
                })
                .catch(function() {
                    showCourierToast('Network error. Please try again.');
                })
                .then(function() {
                    btn.disabled = false;
                    bi.classList.remove('hidden');
                    bs.classList.add('hidden');
                });
        });
        if (D.initialStatus !== 'offline') startGps();

        /* ---------- Modal ---------- */
        function modal(id, cid) {
            var m = $(id),
                c = $(cid);
            return {
                open: function() {
                    if (!m) return;
                    m.classList.remove('hidden');
                    m.classList.add('flex');
                    setTimeout(function() {
                        c.classList.remove('scale-95');
                        c.classList.add('scale-100');
                    }, 10);
                },
                close: function() {
                    if (!m) return;
                    c.classList.remove('scale-100');
                    c.classList.add('scale-95');
                    setTimeout(function() {
                        m.classList.add('hidden');
                        m.classList.remove('flex');
                    }, 300);
                }
            };
        }
        var W = modal('withdraw-modal', 'withdraw-modal-content'),
            P = modal('profile-modal', 'profile-modal-content');
        window.openWithdrawModal = W.open;
        window.closeWithdrawModal = W.close;
        window.openProfileModal = P.open;
        window.closeProfileModal = P.close;
        window.handleWithdrawClick = function() {
            if (balance <= 0) return showCourierToast('Your balance is 0. You cannot withdraw at this time.');
            W.open();
        };

        function submit(url, form, done) {
            return fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                })
                .then(function(r) {
                    return r.json().then(function(d) {
                        return {
                            ok: r.ok,
                            d: d
                        };
                    });
                });
        }
        window.submitWithdrawal = function(e) {
            e.preventDefault();
            var f = $('withdraw-form'),
                b = $('btn-withdraw-submit'),
                t = $('withdraw-btn-text'),
                s = $('withdraw-spinner');
            b.disabled = true;
            t.textContent = 'Processing...';
            s.classList.remove('hidden');
            submit(D.routeWithdraw, f).then(function(r) {
                    if (r.ok) {
                        showCourierToast(r.d.success);
                        W.close();
                        f.reset();
                        setTimeout(reload, 2000);
                    } else showCourierToast(r.d.error || r.d.message || 'An error occurred.');
                }).catch(function() {
                    showCourierToast('Network error. Please try again.');
                })
                .then(function() {
                    b.disabled = false;
                    t.textContent = 'Process Withdrawal';
                    s.classList.add('hidden');
                });
        };
        window.submitProfileUpdate = function(e) {
            e.preventDefault();
            submit(D.routeProfile, $('profile-form')).then(function(r) {
                if (r.ok) {
                    showCourierToast(r.d.success || 'Profile updated successfully!');
                    P.close();
                    setTimeout(reload, 1500);
                } else showCourierToast(r.d.error || r.d.message || 'Failed to update profile. Please check your data.');
            }).catch(function() {
                showCourierToast('Network error. Please try again later.');
            });
        };

        /* ---------- Grafik (Chart.js) — gaya liquid glass: biru langit -> emas ---------- */
        var cv = $('earningsChart');
        if (cv && window.Chart) {
            var ctx = cv.getContext('2d'),
                now = new Date(),
                mon = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var start = new Date(now.getFullYear(), now.getMonth() - 5, 1),
                joined = new Date(D.createdAt);
            var jm = new Date(joined.getFullYear(), joined.getMonth(), 1);
            if (jm > start) start = jm;
            var labels = [],
                data = [];
            for (var d = new Date(start); d <= now; d.setMonth(d.getMonth() + 1)) {
                labels.push(mon[d.getMonth()] + ' ' + String(d.getFullYear()).slice(-2));
                data.push(Math.floor(Math.random() * 3000001 + 1500000)); // TODO: ganti dengan data pendapatan asli dari server
            }
            var hGrad = function(c) {
                var a = c.chart.chartArea;
                if (!a) return '#0ea5e9';
                var g = c.chart.ctx.createLinearGradient(a.left, 0, a.right, 0);
                g.addColorStop(0, '#38bdf8');
                g.addColorStop(1, '#f59e0b');
                return g;
            };
            var vGrad = function(c) {
                var a = c.chart.chartArea;
                if (!a) return 'rgba(56,189,248,.3)';
                var g = c.chart.ctx.createLinearGradient(0, a.top, 0, a.bottom);
                g.addColorStop(0, 'rgba(56,189,248,.45)');
                g.addColorStop(.6, 'rgba(251,191,36,.18)');
                g.addColorStop(1, 'rgba(255,255,255,0)');
                return g;
            };
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Earnings (Rp)',
                        data: data,
                        borderColor: hGrad,
                        backgroundColor: vGrad,
                        borderWidth: 3.5,
                        tension: .42,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#f59e0b',
                        pointBorderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 9,
                        pointHoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: reduce ? 0 : 1600,
                        easing: 'easeOutQuart'
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255,255,255,.92)',
                            titleColor: '#0f172a',
                            bodyColor: '#0369a1',
                            borderColor: '#fff',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 16,
                            displayColors: false,
                            titleFont: {
                                family: 'Inter',
                                size: 12
                            },
                            bodyFont: {
                                family: 'Inter',
                                size: 14,
                                weight: 'bold'
                            },
                            callbacks: {
                                label: function(c) {
                                    return 'Rp ' + c.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: {
                                display: false
                            },
                            grid: {
                                color: 'rgba(255,255,255,.7)'
                            },
                            ticks: {
                                color: '#64748b',
                                font: {
                                    family: 'Inter',
                                    size: 11,
                                    weight: '600'
                                },
                                callback: function(v) {
                                    return v === 0 ? 'Rp 0' : 'Rp ' + (v / 1e6) + 'M';
                                }
                            }
                        },
                        x: {
                            border: {
                                display: false
                            },
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#475569',
                                font: {
                                    family: 'Inter',
                                    size: 12,
                                    weight: 'bold'
                                }
                            }
                        }
                    }
                }
            });
        }

        /* ---------- Target harian ---------- */
        var g = $('goal');
        if (g) {
            var goal = +g.dataset.goal || 1,
                earned = +g.dataset.earned || 0,
                pct = Math.min(100, Math.round(earned / goal * 100));
            $('goal-pct').textContent = pct + '%';
            $('goal-note').textContent = pct >= 100 ? 'Goal reached. Great work today!' : 'Rp ' + (goal - earned).toLocaleString('id-ID') + ' to go';
            setTimeout(function() {
                $('goal-fill').style.width = pct + '%';
            }, reduce ? 0 : 500);
        }

        /* ---------- Animasi (GSAP) ---------- */
        function effects() {
            if (reduce || typeof gsap === 'undefined') return;
            var ST = window.ScrollTrigger;
            if (ST) gsap.registerPlugin(ST);
            var qa = function(s) {
                return Array.prototype.slice.call(document.querySelectorAll(s));
            };

            // muncul berurutan saat di-scroll
            qa('.cd-reveal').forEach(function(el, i) {
                var c = small ? {
                    y: 16,
                    opacity: 0,
                    duration: .5,
                    ease: 'power2.out',
                    clearProps: 'transform,opacity'
                } : {
                    y: 34,
                    opacity: 0,
                    filter: 'blur(8px)',
                    duration: .9,
                    ease: 'power3.out',
                    delay: Math.min(i, 3) * .08,
                    clearProps: 'transform,opacity,filter'
                };
                if (ST) c.scrollTrigger = {
                    trigger: el,
                    start: 'top 92%'
                };
                gsap.from(el, c);
            });

            // angka menghitung naik
            qa('[data-count]').forEach(function(el) {
                var end = +el.dataset.count || 0,
                    pre = el.dataset.prefix || '',
                    o = {
                        v: 0
                    };
                var c = {
                    v: end,
                    duration: 1.6,
                    ease: 'power2.out',
                    onUpdate: function() {
                        el.textContent = pre + Math.round(o.v).toLocaleString('id-ID');
                    }
                };
                if (ST) c.scrollTrigger = {
                    trigger: el,
                    start: 'top 92%'
                };
                gsap.to(o, c);
            });

            // sentuhan air: satu riak saat kursor menyentuh
            (small ? [] : qa('.cd-touch')).forEach(function(el) {
                el.addEventListener('pointerenter', function(e) {
                    var b = el.getBoundingClientRect(),
                        s = document.createElement('span');
                    s.className = 'water-ripple';
                    s.style.left = (e.clientX - b.left) + 'px';
                    s.style.top = (e.clientY - b.top) + 'px';
                    el.appendChild(s);
                    gsap.fromTo(s, {
                        xPercent: -50,
                        yPercent: -50,
                        scale: 0,
                        opacity: .95
                    }, {
                        scale: Math.hypot(b.width, b.height) / 9,
                        opacity: 0,
                        duration: 1.4,
                        ease: 'power2.out',
                        onComplete: function() {
                            s.remove();
                        }
                    });
                });
            });
        }
        if (document.readyState === 'complete') effects();
        else window.addEventListener('load', effects);
    })();

    // Stepper +/−: simpan otomatis setelah jeda singkat (tanpa tombol Update)
    document.addEventListener('click', function(e) {
        var b = e.target.closest('[data-step]');
        if (!b) return;
        var f = b.closest('form'),
            i = f.querySelector('input[name=quantity]');
        var v = Math.min(99, Math.max(1, (+i.value || 1) + +b.dataset.step));
        if (v === +i.value) return;
        i.value = v;
        clearTimeout(f._t);
        f._t = setTimeout(function() {
            f.requestSubmit();
        }, 350);
    });
    document.addEventListener('change', function(e) {
        if (e.target.matches('.cart-qty-form input')) e.target.form.requestSubmit();
    });
</script>