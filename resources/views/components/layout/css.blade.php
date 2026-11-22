<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    :root {
        /* Taruh cloud.png di folder public/images/ */
        --cloud: url('{{ asset("images/cloud.png") }}');
    }

    html {
        scroll-behavior: smooth;
        scroll-padding-top: 120px;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f6f9fc;
        overflow-x: hidden;
    }

    .bg-grid {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background-image: linear-gradient(to right, rgba(0, 0, 0, 0.03) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(0, 0, 0, 0.03) 1px, transparent 1px);
        background-size: 40px 40px;
    }

    .glow-orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(100px);
        z-index: -1;
        opacity: 0.5;
    }

    .orb-1 {
        top: -10%;
        left: -10%;
        width: 50vw;
        height: 50vw;
        background: #e0e7ff;
    }

    .orb-2 {
        bottom: -10%;
        right: -10%;
        width: 40vw;
        height: 40vw;
        background: #dbeafe;
    }

    .font-serif-display {
        font-family: 'Playfair Display', 'Georgia', serif;
        letter-spacing: -0.02em;
    }

    .step-number {
        font-size: 3rem;
        line-height: 1;
        font-weight: 700;
        color: #e2e8f0;
        font-family: 'Georgia', serif;
    }

    .product-card {
        transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.4s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-up {
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .hero-anim,
    .scroll-anim,
    .stagger-item,
    .carousel-item {
        opacity: 0;
        will-change: transform, opacity;
    }

    .reveal-line {
        will-change: filter, opacity, transform;
    }

    .hover-text .letter {
        display: inline-block;
        will-change: transform, color;
        transform-origin: center bottom;
    }

    /* ========================================================= */
    /* 💧 LIQUID GLASS — DESIGN SYSTEM (dipakai di semua section) */
    /* ========================================================= */
    .lg {
        position: relative;
        isolation: isolate;
        background: linear-gradient(135deg, rgba(255, 255, 255, .38), rgba(255, 255, 255, .08) 45%, rgba(186, 230, 253, .22));
        border: 1px solid rgba(255, 255, 255, .55);
        backdrop-filter: blur(22px) saturate(200%) brightness(1.06);
        -webkit-backdrop-filter: blur(22px) saturate(200%) brightness(1.06);
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, .95), inset -1px -1px 1px rgba(255, 255, 255, .45),
            inset 0 0 40px rgba(255, 255, 255, .28), 0 30px 70px -20px rgba(31, 38, 135, .22), 0 8px 24px rgba(31, 38, 135, .06);
    }

    .lg::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        pointer-events: none;
        z-index: -1;
        background: linear-gradient(115deg, rgba(255, 255, 255, .5), rgba(255, 255, 255, 0) 28%, rgba(255, 255, 255, 0) 72%, rgba(255, 255, 255, .22));
    }

    .lg-soft {
        backdrop-filter: blur(16px) saturate(190%) brightness(1.05);
        -webkit-backdrop-filter: blur(16px) saturate(190%) brightness(1.05);
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, .9), inset -1px -1px 1px rgba(255, 255, 255, .4),
            inset 0 0 20px rgba(255, 255, 255, .22), 0 12px 30px -12px rgba(31, 38, 135, .2);
    }

    .lg-dark {
        background: linear-gradient(135deg, rgba(255, 255, 255, .26), rgba(255, 255, 255, .06) 55%, rgba(125, 211, 252, .14));
        border-color: rgba(255, 255, 255, .4);
        color: #fff;
    }

    .lg-blue {
        background: linear-gradient(135deg, rgba(56, 189, 248, .85), rgba(14, 165, 233, .7));
        border-color: rgba(186, 230, 253, .8);
        color: #fff;
    }

    .lg-btn {
        overflow: hidden;
        transition: transform .35s cubic-bezier(.2, .8, .2, 1), box-shadow .35s ease, background .35s ease;
    }

    .lg-btn::after {
        content: "";
        position: absolute;
        top: 0;
        bottom: 0;
        left: -60%;
        width: 40%;
        pointer-events: none;
        background: linear-gradient(100deg, transparent, rgba(255, 255, 255, .75), transparent);
        transform: skewX(-20deg);
        transition: left .7s ease;
    }

    .lg-btn:hover {
        transform: translateY(-3px);
    }

    .lg-btn:hover::after {
        left: 130%;
    }

    /* ========================================================= */
    /* ☁️ SKY — BACKGROUND AWAN BERGERAK                          */
    /* ========================================================= */
    .sky {
        position: fixed;
        inset: 0;
        z-index: -10;
        overflow: hidden;
        background: linear-gradient(180deg, #4f9cf0 0%, #8ec8fb 45%, #dff0ff 100%);
    }

    .sky-photo {
        position: absolute;
        inset: -10%;
        background-size: cover;
        background-position: center;
        opacity: .5;
        mix-blend-mode: soft-light;
        filter: blur(6px);
        animation: bg-pan 40s infinite alternate ease-in-out;
        will-change: transform;
    }

    .cloud {
        position: absolute;
        left: 0;
        top: var(--t, 10%);
        width: var(--w, 640px);
        height: calc(var(--w, 640px) * .36);
        opacity: var(--o, .9);
        filter: blur(var(--b, 16px));
        background:
            radial-gradient(circle, #fff 0, rgba(255, 255, 255, 0) 68%) 0% 72% / 36% 70% no-repeat,
            radial-gradient(circle, #fff 0, rgba(255, 255, 255, 0) 68%) 24% 38% / 40% 100% no-repeat,
            radial-gradient(circle, #fff 0, rgba(255, 255, 255, 0) 68%) 56% 55% / 42% 90% no-repeat,
            radial-gradient(circle, #fff 0, rgba(255, 255, 255, 0) 68%) 92% 76% / 34% 66% no-repeat;
        animation: cloud-drift var(--d, 90s) linear infinite;
        animation-delay: var(--delay, 0s);
        will-change: transform;
    }

    .sky::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, .14);
        pointer-events: none;
    }

    @keyframes cloud-drift {
        from {
            transform: translate3d(-110%, 0, 0);
        }

        to {
            transform: translate3d(100vw, 0, 0);
        }
    }

    @keyframes bg-pan {
        0% {
            transform: scale(1) translate(0, 0);
        }

        100% {
            transform: scale(1.15) translate(-2%, -3%);
        }
    }

    .bg-moving {
        animation: bg-pan 30s infinite alternate ease-in-out;
    }

    @keyframes orb-float {

        0%,
        100% {
            transform: translate3d(0, 0, 0);
        }

        50% {
            transform: translate3d(4%, 3%, 0);
        }
    }

    .orb-float {
        animation: orb-float 18s ease-in-out infinite;
    }

    @keyframes pulse-ring {
        0% {
            transform: scale(.8);
            opacity: .8;
        }

        100% {
            transform: scale(2.2);
            opacity: 0;
        }
    }

    /* ========================================================= */
    /* ✨ LEBIH HIDUP: spotlight kursor, ikon melayang, awan pic   */
    /* ========================================================= */
    .lg-spot::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        pointer-events: none;
        z-index: -1;
        opacity: 0;
        transition: opacity .4s ease;
        background: radial-gradient(280px circle at var(--mx, 50%) var(--my, 50%), rgba(255, 255, 255, .7), rgba(255, 255, 255, 0) 62%);
    }

    .lg-spot:hover::after {
        opacity: 1;
    }

    .std-card {
        transition: transform .5s cubic-bezier(.2, .8, .2, 1), box-shadow .5s ease;
    }

    .std-card:hover {
        transform: translateY(-8px);
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, 1), inset 0 0 40px rgba(255, 255, 255, .4), 0 40px 70px -24px rgba(14, 165, 233, .4);
    }

    .std-card:hover .float-y {
        animation-duration: 2s;
    }

    @keyframes float-y {
        from {
            transform: translateY(0) rotate(0deg);
        }

        to {
            transform: translateY(-7px) rotate(3deg);
        }
    }

    .float-y {
        animation: float-y 3.6s ease-in-out infinite alternate;
    }

    .std-card:nth-child(2) .float-y {
        animation-delay: -1.2s;
    }

    .std-card:nth-child(3) .float-y {
        animation-delay: -2.4s;
    }

    /* ---- Awan Gambar (pengganti .bubble) ---- */
    .cloud-pic {
        position: absolute;
        width: var(--w);
        aspect-ratio: 520 / 297;
        background: var(--cloud) center / contain no-repeat;
        opacity: var(--o, .95);
        filter: drop-shadow(0 22px 26px rgba(56, 130, 200, .28));
        animation: cp var(--d, 16s) ease-in-out infinite alternate;
        animation-delay: var(--dl, 0s);
    }

    @keyframes cp {
        from {
            transform: translate3d(-40px, 0, 0);
        }

        to {
            transform: translate3d(70px, -26px, 0);
        }
    }

    /* ========================================================= */
    /* 🧭 HEADER LIQUID GLASS                                    */
    /* ========================================================= */
    .lg-header {
        background: linear-gradient(135deg, rgba(255, 255, 255, .55), rgba(255, 255, 255, .16) 50%, rgba(186, 230, 253, .3));
        border: 1px solid rgba(255, 255, 255, .65);
        backdrop-filter: blur(24px) saturate(210%) brightness(1.06);
        -webkit-backdrop-filter: blur(24px) saturate(210%) brightness(1.06);
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, .95), inset -1px -1px 1px rgba(255, 255, 255, .45),
            inset 0 0 24px rgba(255, 255, 255, .35), 0 14px 40px -12px rgba(31, 38, 135, .25);
    }

    .lg-header::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        pointer-events: none;
        background: linear-gradient(115deg, rgba(255, 255, 255, .55), rgba(255, 255, 255, 0) 30%, rgba(255, 255, 255, 0) 70%, rgba(255, 255, 255, .25));
    }

    .nav-link {
        position: relative;
        border-radius: 999px;
        color: #475569;
        transition: background .3s ease, color .3s ease, box-shadow .3s ease;
    }

    .nav-link:hover {
        color: #0f172a;
        background: rgba(255, 255, 255, .55);
        box-shadow: inset 1px 1px 1px rgba(255, 255, 255, .95), 0 4px 12px -4px rgba(31, 38, 135, .2);
    }

    .nav-link.is-active {
        color: #0f172a;
        background: rgba(255, 255, 255, .75);
        box-shadow: inset 1px 1px 1px #fff, 0 4px 14px -4px rgba(31, 38, 135, .25);
    }

    /* ========================================================= */
    /* 🗂️ CATEGORIES — SCROLL HORIZONTAL BARU                    */
    /* ========================================================= */
    .cat-track {
        display: flex;
        align-items: center;
        gap: 24px;
        width: max-content;
        padding-inline: calc(50vw - 140px);
    }

    @media (min-width: 768px) {
        .cat-track {
            padding-inline: calc(50vw - 180px);
        }
    }

    .cat-card {
        position: relative;
        flex: none;
        width: 280px;
        height: min(440px, 54vh);
        border-radius: 3rem;
        padding: 10px;
        cursor: pointer;
        will-change: transform, opacity;
        transition: box-shadow .5s ease, border-color .5s ease;
    }

    @media (min-width: 768px) {
        .cat-card {
            width: 360px;
        }
    }

    .cat-card:nth-child(even) {
        margin-top: 56px;
    }

    .cat-card:nth-child(odd) {
        margin-bottom: 56px;
    }

    .cat-card.is-active {
        border-color: #fff;
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, 1), inset 0 0 40px rgba(255, 255, 255, .35), 0 40px 80px -25px rgba(14, 165, 233, .5);
    }

    .cat-media {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 2.4rem;
        overflow: hidden;
    }

    .cat-card img {
        position: absolute;
        top: 0;
        left: -12%;
        width: 124%;
        height: 100%;
        object-fit: cover;
        will-change: transform;
        transition: filter .6s ease;
    }

    .cat-card:hover img {
        filter: saturate(1.15) brightness(1.05);
    }

    .cat-shade {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, .65), rgba(15, 23, 42, .03) 55%, transparent);
    }

    .cat-panel {
        position: absolute;
        left: 12px;
        right: 12px;
        bottom: 12px;
        border-radius: 1.75rem;
        padding: 14px 16px;
        transition: transform .5s cubic-bezier(.2, .8, .2, 1), background .4s ease;
    }

    .cat-card:hover .cat-panel {
        transform: translateY(-4px);
        background: linear-gradient(135deg, rgba(255, 255, 255, .38), rgba(255, 255, 255, .12));
    }

    .cat-arrow {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        flex: none;
        transition: transform .4s ease;
    }

    .cat-card:hover .cat-arrow {
        transform: rotate(-45deg) scale(1.08);
    }

    /* ========================================================= */
    /* ❓ FAQ — VERSI BARU                                        */
    /* ========================================================= */
    .faq-item {
        border-radius: 1.75rem;
        transition: box-shadow .5s ease, border-color .5s ease, transform .5s cubic-bezier(.2, .8, .2, 1);
    }

    .faq-item:hover {
        transform: translateY(-2px);
    }

    .faq-item.is-open {
        border-color: rgba(255, 255, 255, .95);
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, 1), inset 0 0 30px rgba(255, 255, 255, .4),
            0 24px 50px -18px rgba(14, 165, 233, .35);
    }

    .faq-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px 22px;
        text-align: left;
        background: none;
        border: 0;
        cursor: pointer;
    }

    .faq-btn:focus-visible {
        outline: 2px solid #38bdf8;
        outline-offset: -4px;
        border-radius: 1.75rem;
    }

    .faq-num {
        font-family: 'Playfair Display', serif;
        font-style: italic;
        font-size: 1.1rem;
        color: #0ea5e9;
        width: 28px;
        flex: none;
    }

    .faq-q {
        flex: 1;
        font-weight: 700;
        color: #0f172a;
        font-size: 15px;
        line-height: 1.4;
    }

    .faq-icon {
        position: relative;
        width: 34px;
        height: 34px;
        flex: none;
        border-radius: 50%;
        background: rgba(255, 255, 255, .7);
        box-shadow: inset 1px 1px 1px #fff, 0 4px 10px -4px rgba(31, 38, 135, .25);
        transition: transform .5s cubic-bezier(.2, .8, .2, 1), background .3s ease;
    }

    .faq-icon::before,
    .faq-icon::after {
        content: "";
        position: absolute;
        left: 50%;
        top: 50%;
        width: 12px;
        height: 2px;
        margin: -1px 0 0 -6px;
        border-radius: 2px;
        background: #0f172a;
        transition: transform .4s ease, background .3s ease;
    }

    .faq-icon::after {
        transform: rotate(90deg);
    }

    .faq-item.is-open .faq-icon {
        transform: rotate(135deg);
        background: #0ea5e9;
    }

    .faq-item.is-open .faq-icon::before,
    .faq-item.is-open .faq-icon::after {
        background: #fff;
    }

    .faq-panel {
        height: 0;
        overflow: hidden;
    }

    .faq-body {
        padding: 0 22px 22px 66px;
        color: #475569;
        font-size: 14px;
        line-height: 1.7;
    }

    /* ========================================================= */
    /* 🌟 LIQUID GLASS FOLDER (tf-) — DIGABUNG & DISESUAIKAN      */
    /* ========================================================= */
    .tf-stage {
        position: relative;
        width: min(720px, 100%);
        padding: 48px 24px 28px;
        border-radius: 3rem;
        text-align: center;
        isolation: isolate;
        background: linear-gradient(135deg, rgba(255, 255, 255, .38), rgba(255, 255, 255, .08) 45%, rgba(186, 230, 253, .22));
        border: 1px solid rgba(255, 255, 255, .55);
        backdrop-filter: blur(22px) saturate(200%) brightness(1.06);
        -webkit-backdrop-filter: blur(22px) saturate(200%) brightness(1.06);
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, .95), inset -1px -1px 1px rgba(255, 255, 255, .45), inset 0 0 40px rgba(255, 255, 255, .28), 0 30px 70px -20px rgba(31, 38, 135, .22), 0 8px 24px rgba(31, 38, 135, .06);
    }

    /* Panel kategori: lebar ke samping */
    .tf-stage--wide {
        width: min(1440px, 100%);
        padding: 32px 20px 28px;
    }

    .tf-stage::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        pointer-events: none;
        background: linear-gradient(115deg, rgba(255, 255, 255, .5), rgba(255, 255, 255, 0) 28%, rgba(255, 255, 255, 0) 72%, rgba(255, 255, 255, .22));
    }

    .tf-stage>*:not(.tf-glow) {
        position: relative;
        z-index: 1;
    }

    .tf-glow {
        position: absolute;
        left: 50%;
        top: 58%;
        width: 600px;
        height: 600px;
        max-width: 100vw;
        transform: translate(-50%, -50%);
        background: rgba(125, 211, 252, .3);
        border-radius: 50%;
        filter: blur(120px);
        pointer-events: none;
        z-index: -1;
    }

    .tf-zone {
        position: relative;
        width: 100%;
        max-width: 460px;
        height: 450px;
        margin: 8px auto 0;
        cursor: pointer;
    }

    /* Height & posisi folder diisi JS */
    .tf-zone--row {
        max-width: none;
        margin-top: 20px;
    }

    .tf-folder {
        position: absolute;
        left: 50%;
        bottom: 18px;
        width: 320px;
        height: 262px;
        margin-left: -160px;
        perspective: 900px;
    }

    .tf-shadow {
        position: absolute;
        left: 26px;
        right: 26px;
        bottom: -6px;
        height: 34px;
        border-radius: 50%;
        background: rgba(56, 189, 248, .28);
        filter: blur(22px);
    }

    .tf-back {
        position: absolute;
        inset: 0;
        z-index: 1;
        clip-path: path('M0 22Q0 0 22 0L108 0C124 0 126 32 142 32L296 32Q320 32 320 56L320 238Q320 262 296 262L24 262Q0 262 0 238Z');
        background: linear-gradient(160deg, rgba(255, 255, 255, .34), rgba(186, 230, 253, .22));
        backdrop-filter: blur(12px) saturate(170%);
        -webkit-backdrop-filter: blur(12px) saturate(170%);
    }

    .tf-outline {
        position: absolute;
        inset: 0;
        width: 320px;
        height: 262px;
        z-index: 1;
        pointer-events: none;
        overflow: visible;
    }

    .tf-front {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 150px;
        border-radius: 26px;
        z-index: 10;
        transform-origin: 50% 100%;
        padding: 20px 22px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        text-align: left;
        will-change: transform;
        background: linear-gradient(to top, rgba(125, 211, 252, .5), rgba(255, 255, 255, .22));
        border: 1px solid rgba(255, 255, 255, .5);
        backdrop-filter: blur(18px) saturate(190%) brightness(1.05);
        -webkit-backdrop-filter: blur(18px) saturate(190%) brightness(1.05);
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, .95), inset -1px -1px 1px rgba(255, 255, 255, .4), inset 0 0 28px rgba(255, 255, 255, .3), inset 0 -14px 24px rgba(56, 189, 248, .18), 0 -8px 30px rgba(31, 38, 135, .1);
    }

    .tf-front::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        pointer-events: none;
        background: linear-gradient(120deg, rgba(255, 255, 255, .6), rgba(255, 255, 255, 0) 32%, rgba(255, 255, 255, 0) 70%, rgba(255, 255, 255, .22));
    }

    .tf-stars {
        color: #f59e0b;
        font-size: 12px;
        display: flex;
        gap: 8px;
        align-items: center;
        position: relative;
    }

    .tf-stars span {
        font-size: 10px;
        font-weight: 700;
        background: rgba(255, 255, 255, .6);
        color: #0c4a6e;
        padding: 2px 7px;
        border-radius: 7px;
    }

    .tf-front p {
        font-size: 12px;
        line-height: 1.5;
        font-style: italic;
        font-weight: 500;
        margin: 7px 0 0;
        color: #0f172a;
        position: relative;
    }

    .tf-who {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 9px;
        padding-top: 8px;
        border-top: 1px solid rgba(255, 255, 255, .7);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .08em;
        color: #0c4a6e;
        text-transform: uppercase;
        position: relative;
    }

    .tf-ok {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #0ea5e9;
        color: #fff;
        display: grid;
        place-items: center;
        font-size: 11px;
        box-shadow: inset 1px 1px 1px rgba(255, 255, 255, .6);
    }

    .tf-card {
        position: absolute;
        left: 50%;
        bottom: 62px;
        width: 132px;
        height: 172px;
        margin-left: -66px;
        z-index: 5;
        will-change: transform, opacity;
        display: block;
    }

    /* Ukuran dasar kartu kategori; JS yang menskalakan */
    .tf-zone--row .tf-card {
        top: 0;
        bottom: auto;
        width: 230px;
        height: 300px;
        margin-left: -115px;
    }

    .tf-card[data-slot="2"] {
        z-index: 8;
    }

    .tf-card[data-slot="1"],
    .tf-card[data-slot="3"] {
        z-index: 6;
    }

    .tf-card .tf-fl {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .7);
        background: #cbd5e1;
        box-shadow: 0 18px 36px -12px rgba(15, 23, 42, .35);
        transition: box-shadow .4s ease;
    }

    .tf-card:hover .tf-fl {
        box-shadow: 0 30px 55px -14px rgba(14, 165, 233, .55);
    }

    .tf-card .tf-fl::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: inherit;
        z-index: 3;
        pointer-events: none;
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, .8), inset -1px -1px 1px rgba(255, 255, 255, .35), inset 0 0 14px rgba(255, 255, 255, .25);
    }

    .tf-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .6s cubic-bezier(.2, .8, .2, 1);
        transform-origin: 50% 55%;
    }

    .tf-card:hover img {
        transform: scale(1.14);
    }

    .tf-card .tf-fl::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, .78), transparent 58%);
    }

    .tf-cap {
        position: absolute;
        left: 12px;
        right: 10px;
        bottom: 10px;
        z-index: 4;
        text-align: left;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        line-height: 1.25;
    }

    .tf-cap em {
        display: block;
        font-style: normal;
        font-weight: 600;
        font-size: 11px;
        opacity: .9;
        margin-top: 1px;
    }

    .tf-zone--row .tf-cap {
        left: 20px;
        bottom: 20px;
        font-size: 23px;
    }

    .tf-zone--row .tf-cap em {
        font-size: 16px;
    }

    .tf-badge {
        position: absolute;
        left: 50%;
        bottom: 150px;
        z-index: 20;
        pointer-events: none;
        will-change: transform, opacity;
    }

    .tf-badge .tf-fl {
        padding: 8px 12px;
        border-radius: 14px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
        color: #0f172a;
        background: linear-gradient(135deg, rgba(255, 255, 255, .6), rgba(255, 255, 255, .22));
        border: 1px solid rgba(255, 255, 255, .6);
        backdrop-filter: blur(14px) saturate(190%);
        -webkit-backdrop-filter: blur(14px) saturate(190%);
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, .95), inset -1px -1px 1px rgba(255, 255, 255, .4), 0 12px 28px -8px rgba(15, 23, 42, .25);
    }

    .tf-bd-b .tf-fl {
        color: #fff;
        background: linear-gradient(135deg, rgba(56, 189, 248, .85), rgba(14, 165, 233, .7));
        border-color: rgba(186, 230, 253, .8);
    }

    .tf-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 14px;
        margin-bottom: 14px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: #0369a1;
    }

    .tf-kicker i {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #0ea5e9;
        box-shadow: 0 0 8px rgba(14, 165, 233, .8);
    }

    .tf-tab {
        position: absolute;
        left: 20px;
        top: 7px;
        z-index: 2;
        font-size: 9px;
        font-weight: 800;
        letter-spacing: .18em;
        text-transform: uppercase;
        color: #0c4a6e;
        opacity: .75;
        pointer-events: none;
    }

    .tf-hint {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 4px;
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        color: #0c4a6e;
    }

    .tf-hint .dot {
        position: relative;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #0ea5e9;
    }

    .tf-hint .dot::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: #0ea5e9;
        animation: pulse-ring 1.8s ease-out infinite;
    }

    .tf-stats {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-top: 18px;
    }

    .tf-stat {
        padding: 10px 16px;
        border-radius: 1.1rem;
        text-align: center;
        min-width: 118px;
    }

    .tf-stat b {
        display: block;
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        color: #0f172a;
        line-height: 1.1;
    }

    .tf-stat span {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #475569;
    }

    .tf-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 20px;
        padding: 13px 26px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 700;
        color: #0f172a;
    }

    /* ========================================================= */
    /* ♿ ACCESSIBILITY: REDUCED MOTION                          */
    /* ========================================================= */
    @media (prefers-reduced-motion: reduce) {

        .cloud,
        .sky-photo,
        .orb-float,
        .bg-moving,
        .cloud-pic,
        .float-y {
            animation: none !important;
        }

        .cloud {
            transform: translate3d(calc(var(--x, 20) * 1vw), 0, 0);
        }
    }

    /* 🪟 Pane liquid glass — lapisan kaca terpisah (sibling) agar kartu di dalamnya tetap mengaburkan langit */
    .pane-glow {
        position: absolute;
        inset: 0;
        border-radius: inherit;
        overflow: hidden;
        pointer-events: none
    }

    .pane-glow i {
        position: absolute;
        border-radius: 50%;
        filter: blur(70px)
    }

    .pane-glow .g1 {
        top: -8%;
        right: -6%;
        width: 340px;
        height: 340px;
        background: rgba(253, 224, 71, .45)
    }

    .pane-glow .g2 {
        bottom: 4%;
        left: -8%;
        width: 360px;
        height: 360px;
        background: rgba(251, 191, 36, .28)
    }

    .pane-glow .g3 {
        top: 40%;
        left: 32%;
        width: 300px;
        height: 300px;
        background: rgba(125, 211, 252, .3)
    }

    .sparkle {
        position: absolute;
        line-height: 1;
        color: #fbbf24;
        text-shadow: 0 0 14px rgba(251, 146, 60, .55);
        pointer-events: none
    }

    .lg-gold {
        background: linear-gradient(135deg, rgba(253, 230, 138, .96), rgba(251, 191, 36, .86));
        border-color: rgba(254, 243, 199, .95);
        color: #78350f;
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, .85), inset -1px -1px 1px rgba(255, 255, 255, .35), 0 10px 24px -8px rgba(245, 158, 11, .55)
    }

    /* Halaman About — animasi & dekorasi tambahan (liquid glass) */
    @keyframes about-marquee {
        from {
            transform: translateX(0);
        }

        to {
            transform: translateX(-50%);
        }
    }

    .about-marquee {
        display: flex;
        width: max-content;
        animation: about-marquee 34s linear infinite;
    }

    .about-marquee:hover {
        animation-play-state: paused;
    }

    @keyframes twinkle {

        0%,
        100% {
            opacity: .55;
            transform: scale(.85) rotate(0deg);
        }

        50% {
            opacity: 1;
            transform: scale(1.15) rotate(12deg);
        }
    }

    .twinkle {
        animation: twinkle 3.2s ease-in-out infinite;
    }

    .twinkle.d2 {
        animation-delay: -1.1s;
    }

    .twinkle.d3 {
        animation-delay: -2.2s;
    }

    .about-photo img {
        transition: transform .8s cubic-bezier(.2, .8, .2, 1);
    }

    .about-photo:hover img {
        transform: scale(1.07);
    }


    @media (prefers-reduced-motion: reduce) {

        .about-marquee,
        .twinkle {
            animation: none !important;
        }
    }

    /* ---------- SENTUHAN AIR ---------- */
    .step-card {
        transition: box-shadow .5s ease;
    }

    .step-card:hover {
        box-shadow: inset 1.5px 1.5px 1px #fff, inset 0 0 30px rgba(255, 255, 255, .4), 0 26px 50px -18px rgba(14, 165, 233, .45);
    }

    .step-card,
    .about-stat {
        overflow: hidden;
    }

    .dot-ripple {
        border-color: #fbbf24;
        background: radial-gradient(circle, rgba(253, 230, 138, .35), rgba(251, 191, 36, .12) 60%, rgba(255, 255, 255, 0) 72%);
        box-shadow: 0 0 16px rgba(251, 191, 36, .6);
    }

    .water-ripple {
        position: absolute;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        pointer-events: none;
        z-index: 6;
        border: 2px solid rgba(255, 255, 255, .95);
        background: radial-gradient(circle, rgba(255, 255, 255, .35), rgba(125, 211, 252, .18) 55%, rgba(255, 255, 255, 0) 72%);
        box-shadow: 0 0 18px rgba(125, 211, 252, .75), inset 0 0 12px rgba(255, 255, 255, .7);
    }

    /* ---------- ANIMASI TAMBAHAN ---------- */
    @keyframes glow-drift {
        from {
            transform: translate3d(0, 0, 0) scale(1);
        }

        to {
            transform: translate3d(5%, 7%, 0) scale(1.18);
        }
    }

    .pane-glow i {
        animation: glow-drift 12s ease-in-out infinite alternate;
    }

    .pane-glow .g2 {
        animation-duration: 16s;
        animation-delay: -5s;
    }

    .pane-glow .g3 {
        animation-duration: 19s;
        animation-delay: -9s;
    }

    @keyframes shimmer {
        from {
            background-position: 0% 50%;
        }

        to {
            background-position: -200% 50%;
        }
    }

    .text-shimmer {
        background: linear-gradient(100deg, #0369a1 20%, #f59e0b 45%, #38bdf8 60%, #0369a1 80%);
        background-size: 200% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent !important;
        animation: shimmer 6s linear infinite;
    }

    @keyframes rise {
        0% {
            transform: translateY(40px) rotate(0deg);
            opacity: 0;
        }

        20% {
            opacity: .9;
        }

        100% {
            transform: translateY(-380px) rotate(160deg);
            opacity: 0;
        }
    }

    .rise {
        position: absolute;
        line-height: 1;
        font-size: var(--s, 14px);
        color: #fbbf24;
        text-shadow: 0 0 14px rgba(251, 146, 60, .55);
        opacity: 0;
        animation: rise var(--d, 9s) ease-in-out infinite;
        animation-delay: var(--dl, 0s);
    }

    @keyframes ring {
        0% {
            transform: scale(1);
            opacity: .75;
        }

        100% {
            transform: scale(1.9);
            opacity: 0;
        }
    }

    .about-ring {
        position: absolute;
        inset: 0;
        border-radius: 9999px;
        border: 2px solid #fbbf24;
        pointer-events: none;
        display: none;
    }

    @keyframes bob {
        from {
            transform: translateY(0);
        }

        to {
            transform: translateY(-5px);
        }
    }

    .about-stat .lg-gold {
        animation: bob 2.6s ease-in-out infinite alternate;
    }

    .about-stat:nth-child(2) .lg-gold {
        animation-delay: -.6s;
    }

    .about-stat:nth-child(3) .lg-gold {
        animation-delay: -1.2s;
    }

    .about-stat:nth-child(4) .lg-gold {
        animation-delay: -1.8s;
    }

    @keyframes auto-shine {

        0%,
        55% {
            left: -60%;
        }

        100% {
            left: 130%;
        }
    }

    .auto-shine::after {
        animation: auto-shine 4.5s ease-in-out infinite;
    }

    @media (prefers-reduced-motion: reduce) {

        .pane-glow i,
        .text-shimmer,
        .rise,
        .about-ring,
        .about-stat .lg-gold,
        .auto-shine::after {
            animation: none !important;
        }

        .rise {
            display: none;
        }
    }

    /* Halaman Contact — melengkapi design system liquid glass di layout (.lg, .lg-soft, .lg-gold, .sky, dst.) */

    /* ---------- Status "online" berdenyut ---------- */
    @keyframes c-ping {
        0% {
            transform: scale(1);
            opacity: .7;
        }

        100% {
            transform: scale(2.6);
            opacity: 0;
        }
    }

    .live-dot {
        position: relative;
        display: inline-block;
        flex: none;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #94a3b8;
    }

    .live-dot::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: inherit;
        opacity: 0;
    }

    .is-open .live-dot {
        background: #10b981;
        box-shadow: 0 0 8px rgba(16, 185, 129, .8);
    }

    .is-open .live-dot::after {
        animation: c-ping 1.8s ease-out infinite;
    }

    .office-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: #475569;
    }

    .office-badge.is-open {
        color: #047857;
    }

    /* ---------- Tombol salin ---------- */
    .copy-btn {
        margin-top: .9rem;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .4rem .95rem;
        border-radius: 999px;
        font-size: .68rem;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #0c4a6e;
        cursor: pointer;
        transition: transform .3s cubic-bezier(.2, .8, .2, 1), background .3s ease, color .3s ease;
    }

    .copy-btn:hover {
        transform: translateY(-2px);
    }

    .copy-btn:focus-visible {
        outline: 2px solid #38bdf8;
        outline-offset: 2px;
    }

    .copy-btn.is-done {
        color: #78350f;
        background: linear-gradient(135deg, rgba(253, 230, 138, .96), rgba(251, 191, 36, .86));
        border-color: rgba(254, 243, 199, .95);
    }

    /* ---------- Pilihan topik ---------- */
    .topic-chip {
        cursor: pointer;
    }

    .topic-chip span {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .55rem 1rem;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 700;
        color: #334155;
        transition: transform .35s cubic-bezier(.34, 1.56, .64, 1), background .3s ease, color .3s ease;
    }

    .topic-chip:hover span {
        transform: translateY(-3px);
    }

    .topic-chip input:checked+span {
        color: #78350f;
        transform: scale(1.06);
        background: linear-gradient(135deg, rgba(253, 230, 138, .96), rgba(251, 191, 36, .86));
        border-color: rgba(254, 243, 199, .95);
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, .85), 0 10px 22px -8px rgba(245, 158, 11, .6);
    }

    .topic-chip input:focus-visible+span {
        outline: 2px solid #38bdf8;
        outline-offset: 3px;
    }

    /* ---------- Input kaca dengan label melayang ---------- */
    .field {
        position: relative;
    }

    .field input,
    .field textarea {
        width: 100%;
        padding: 1.5rem 1.1rem .6rem;
        border-radius: 1.1rem;
        color: #0f172a;
        font-weight: 500;
        outline: none;
        background: rgba(255, 255, 255, .5);
        border: 1px solid rgba(255, 255, 255, .85);
        box-shadow: inset 1px 1px 1px rgba(255, 255, 255, .9), 0 8px 18px -12px rgba(31, 38, 135, .35);
        transition: background .3s ease, border-color .3s ease, box-shadow .3s ease;
    }

    .field textarea {
        resize: none;
        min-height: 140px;
        padding-bottom: 1.8rem;
    }

    .field label {
        position: absolute;
        left: 1.1rem;
        top: 1.05rem;
        font-size: .9rem;
        font-weight: 500;
        color: #64748b;
        pointer-events: none;
        transform-origin: left top;
        transition: top .25s cubic-bezier(.2, .8, .2, 1), font-size .25s ease, letter-spacing .25s ease, color .25s ease;
    }

    .field input:focus,
    .field textarea:focus {
        background: rgba(255, 255, 255, .88);
        border-color: #fbbf24;
        box-shadow: 0 0 0 4px rgba(251, 191, 36, .25), inset 1px 1px 1px #fff;
    }

    .field input:focus+label,
    .field textarea:focus+label,
    .field input:not(:placeholder-shown)+label,
    .field textarea:not(:placeholder-shown)+label {
        top: .5rem;
        font-size: .62rem;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #0369a1;
    }

    .msg-count {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .08em;
        color: #64748b;
        transition: color .3s ease;
    }

    .msg-count.is-near {
        color: #d97706;
    }

    /* ---------- Tombol kirim ---------- */
    @keyframes c-shine {

        0%,
        55% {
            left: -60%;
        }

        100% {
            left: 130%;
        }
    }

    .contact-shine::after {
        animation: c-shine 4.5s ease-in-out infinite;
    }

    .send-btn .plane {
        transition: transform .35s cubic-bezier(.2, .8, .2, 1);
    }

    .send-btn:hover .plane {
        transform: translate(3px, -3px) rotate(-8deg);
    }

    @keyframes c-fly {

        0%,
        100% {
            transform: translate(0, 0) rotate(0deg);
        }

        50% {
            transform: translate(5px, -5px) rotate(-12deg);
        }
    }

    .send-btn.is-loading {
        pointer-events: none;
    }

    .send-btn.is-loading .plane {
        animation: c-fly .8s ease-in-out infinite;
    }

    /* ---------- Tampilan sukses ---------- */
    .contact-form {
        transition: opacity .4s ease, transform .5s cubic-bezier(.2, .8, .2, 1);
    }

    .contact-card.is-sent .contact-form {
        opacity: 0;
        transform: scale(.97);
        pointer-events: none;
    }

    .form-success {
        position: absolute;
        inset: 0;
        z-index: 5;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        text-align: center;
        opacity: 0;
        visibility: hidden;
        transform: scale(.96);
        transition: opacity .5s ease, transform .6s cubic-bezier(.2, .8, .2, 1), visibility 0s linear .6s;
    }

    .contact-card.is-sent .form-success {
        opacity: 1;
        visibility: visible;
        transform: none;
        transition-delay: .15s, .15s, 0s;
    }

    .success-check {
        width: 84px;
        height: 84px;
        margin-bottom: 1.25rem;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 2.2rem;
    }

    @keyframes c-pop {
        0% {
            transform: scale(0) rotate(-90deg);
            opacity: 0;
        }

        100% {
            transform: scale(1) rotate(0deg);
            opacity: 1;
        }
    }

    .contact-card.is-sent .success-check {
        animation: c-pop .8s cubic-bezier(.34, 1.56, .64, 1) .3s both;
    }

    .burst-star {
        position: absolute;
        z-index: 6;
        line-height: 1;
        color: #fbbf24;
        text-shadow: 0 0 12px rgba(251, 146, 60, .6);
        pointer-events: none;
    }

    /* ---------- Hari operasional ---------- */
    .day {
        display: grid;
        place-items: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-size: .72rem;
        font-weight: 800;
        color: #64748b;
        background: rgba(255, 255, 255, .45);
        border: 1px solid rgba(255, 255, 255, .85);
        box-shadow: inset 1px 1px 1px rgba(255, 255, 255, .9);
        transition: transform .4s cubic-bezier(.34, 1.56, .64, 1), background .3s ease;
    }

    .day.is-open {
        color: #78350f;
        background: linear-gradient(135deg, rgba(253, 230, 138, .9), rgba(251, 191, 36, .7));
        border-color: rgba(254, 243, 199, .95);
    }

    @keyframes c-today {

        0%,
        100% {
            box-shadow: 0 0 0 3px rgba(14, 165, 233, .45), inset 1px 1px 1px rgba(255, 255, 255, .9);
        }

        50% {
            box-shadow: 0 0 0 8px rgba(14, 165, 233, .1), inset 1px 1px 1px rgba(255, 255, 255, .9);
        }
    }

    .day.is-today {
        transform: translateY(-4px) scale(1.12);
        animation: c-today 2.4s ease-in-out infinite;
    }

    /* ---------- Peta (Leaflet) ---------- */
    .contact-map {
        position: relative;
        z-index: 0;
        isolation: isolate;
        background: #dff0ff;
    }

    .contact-map .leaflet-container {
        width: 100%;
        height: 100%;
        font-family: 'Inter', sans-serif;
        background: #dff0ff;
    }

    .contact-map .leaflet-tile-pane {
        filter: saturate(1.12) hue-rotate(-6deg);
    }

    .loka-pin-wrap {
        background: none;
        border: 0;
    }

    .loka-pin {
        position: relative;
        width: 44px;
        height: 44px;
    }

    .loka-pin i {
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: rgba(251, 191, 36, .5);
        animation: c-ping 2.2s ease-out infinite;
    }

    .loka-pin b {
        position: absolute;
        inset: 6px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        font-size: 16px;
        color: #78350f;
        background: linear-gradient(135deg, #fde68a, #fbbf24);
        border: 2px solid #fff;
        box-shadow: 0 8px 18px -4px rgba(245, 158, 11, .7);
    }

    /* ---------- Aksesibilitas: kurangi gerak ---------- */
    @media (prefers-reduced-motion: reduce) {

        .contact-shine::after,
        .is-open .live-dot::after,
        .day.is-today,
        .loka-pin i,
        .send-btn.is-loading .plane,
        .contact-card.is-sent .success-check {
            animation: none !important;
        }

        .contact-form,
        .form-success,
        .topic-chip span,
        .copy-btn {
            transition: none !important;
        }
    }

    /* Courier Dashboard — liquid glass, selaras dengan halaman About.
   Memakai class dari layout: lg, lg-soft, lg-blue, lg-gold, lg-btn, lg-spot, sky, cloud-pic, pane-glow, sparkle, float-y, font-serif-display */

    .cd-cap {
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #64748b;
    }

    .cd-touch {
        overflow: hidden;
    }

    .cd-lift {
        transition: transform .45s cubic-bezier(.2, .8, .2, 1), box-shadow .45s ease;
    }

    .cd-lift:hover {
        transform: translateY(-6px);
    }

    /* hijau kaca (tombol Delivered, centang toast) */
    .lg-green {
        background: linear-gradient(135deg, rgba(52, 211, 153, .95), rgba(16, 185, 129, .85));
        border-color: rgba(167, 243, 208, .9);
        color: #fff;
        box-shadow: inset 1.5px 1.5px 1px rgba(255, 255, 255, .6), 0 10px 24px -8px rgba(16, 185, 129, .55);
    }

    /* GPS */
    .cd-gps {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 999px;
        max-width: 190px;
        color: #475569;
        transition: color .3s;
    }

    .cd-gps.is-on {
        color: #047857;
    }

    .cd-dot {
        position: relative;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #94a3b8;
        flex: none;
    }

    .cd-dot.is-on {
        background: #10b981;
        box-shadow: 0 0 10px rgba(16, 185, 129, .8);
    }

    .cd-dot.is-on::after {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background: #10b981;
        animation: cd-ping 1.8s ease-out infinite;
    }

    @keyframes cd-ping {
        0% {
            transform: scale(1);
            opacity: .7;
        }

        100% {
            transform: scale(2.6);
            opacity: 0;
        }
    }

    /* tombol status */
    .cd-status {
        min-width: 190px;
        padding: 14px 32px;
        border-radius: 999px;
        font-weight: 700;
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .cd-status.is-online:hover {
        background: linear-gradient(135deg, rgba(248, 113, 113, .92), rgba(239, 68, 68, .85));
        color: #fff;
        border-color: rgba(254, 202, 202, .9);
    }

    .cd-status[disabled] {
        cursor: not-allowed;
        opacity: .65;
    }

    /* peringkat & avatar huruf */
    .cd-rank {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-weight: 800;
        flex: none;
    }

    .cd-av {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-weight: 800;
        color: #fff;
        background: linear-gradient(135deg, #38bdf8, #0ea5e9);
        flex: none;
    }

    /* rute: garis putus-putus + pin */
    .cd-route {
        position: relative;
        padding-left: 30px;
    }

    .cd-route::before {
        content: "";
        position: absolute;
        left: 8px;
        top: 18px;
        bottom: 18px;
        border-left: 2px dashed rgba(245, 158, 11, .65);
    }

    .cd-pin {
        position: absolute;
        left: -30px;
        top: 2px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 4px 10px rgba(31, 38, 135, .25);
    }

    .cd-pin-gold {
        background: #fbbf24;
    }

    .cd-pin-sky {
        background: #0ea5e9;
    }

    /* form kaca */
    .cd-label {
        display: block;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: #475569;
        margin-bottom: 6px;
    }

    .cd-input {
        width: 100%;
        padding: 12px 16px;
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, .95);
        background: rgba(255, 255, 255, .6);
        color: #0f172a;
        outline: none;
        box-shadow: inset 0 2px 6px rgba(31, 38, 135, .06);
        transition: box-shadow .3s, border-color .3s;
    }

    .cd-input:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, .35);
    }

    .cd-select {
        appearance: none;
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        outline: none;
        cursor: pointer;
    }

    .cd-panel {
        background: linear-gradient(135deg, rgba(255, 255, 255, .86), rgba(255, 255, 255, .62) 50%, rgba(186, 230, 253, .5));
    }

    /* riak air: satu sentuhan */
    .water-ripple {
        position: absolute;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        pointer-events: none;
        z-index: 6;
        border: 2px solid rgba(255, 255, 255, .95);
        background: radial-gradient(circle, rgba(255, 255, 255, .35), rgba(125, 211, 252, .18) 55%, rgba(255, 255, 255, 0) 72%);
        box-shadow: 0 0 18px rgba(125, 211, 252, .75), inset 0 0 12px rgba(255, 255, 255, .7);
    }

    /* hidup */
    @keyframes glow-drift {
        from {
            transform: translate3d(0, 0, 0) scale(1);
        }

        to {
            transform: translate3d(5%, 7%, 0) scale(1.18);
        }
    }

    .pane-glow i {
        animation: glow-drift 12s ease-in-out infinite alternate;
    }

    .pane-glow .g2 {
        animation-duration: 16s;
        animation-delay: -5s;
    }

    .pane-glow .g3 {
        animation-duration: 19s;
        animation-delay: -9s;
    }

    @keyframes twinkle {

        0%,
        100% {
            opacity: .55;
            transform: scale(.85) rotate(0);
        }

        50% {
            opacity: 1;
            transform: scale(1.15) rotate(12deg);
        }
    }

    .twinkle {
        animation: twinkle 3.2s ease-in-out infinite;
    }

    .twinkle.d2 {
        animation-delay: -1.1s;
    }

    .twinkle.d3 {
        animation-delay: -2.2s;
    }

    @keyframes shimmer {
        from {
            background-position: 0% 50%;
        }

        to {
            background-position: -200% 50%;
        }
    }

    .text-shimmer {
        background: linear-gradient(100deg, #0369a1 20%, #f59e0b 45%, #38bdf8 60%, #0369a1 80%);
        background-size: 200% 100%;
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent !important;
        animation: shimmer 6s linear infinite;
    }

    @keyframes auto-shine {

        0%,
        55% {
            left: -60%;
        }

        100% {
            left: 130%;
        }
    }

    .auto-shine::after {
        animation: auto-shine 4.5s ease-in-out infinite;
    }

    /* target harian */
    .cd-bar {
        height: 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .55);
        box-shadow: inset 0 2px 4px rgba(31, 38, 135, .1);
        overflow: hidden;
    }

    .cd-bar i {
        display: block;
        height: 100%;
        width: 0;
        border-radius: inherit;
        background: linear-gradient(90deg, #38bdf8, #fbbf24);
        box-shadow: 0 0 14px rgba(251, 191, 36, .6);
        transition: width 1.4s cubic-bezier(.2, .8, .2, 1);
    }

    /* layar kecil: kurangi hiasan agar ringan & fokus */
    @media (max-width: 767px) {
        .sparkle {
            display: none;
        }

        .pane-glow i,
        .text-shimmer,
        .auto-shine::after,
        .float-y {
            animation: none !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {

        .pane-glow i,
        .twinkle,
        .text-shimmer,
        .auto-shine::after,
        .cd-dot.is-on::after {
            animation: none !important;
        }
    }
</style>