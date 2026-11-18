<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
    /* KEMBALI KE TEMA TERANG DEEPSEEK */
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

    /* 🌟 HEADER KACA KEBIRUAN 🌟 */
    .header-glass-blue {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.4) 0%, rgba(224, 231, 255, 0.2) 100%);
        backdrop-filter: blur(24px) saturate(200%);
        -webkit-backdrop-filter: blur(24px) saturate(200%);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-top: 1px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 10px 30px -5px rgba(31, 38, 135, 0.05), inset 0 0 20px rgba(255, 255, 255, 0.6);
    }

    /* 🌟 KAPSUL MENU TENGAH 🌟 */
    .nav-center-glass {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: inset 0 2px 5px rgba(255, 255, 255, 0.9);
    }

    /* 🌟 MENU AKTIF & HOVER 🌟 */
    .nav-active {
        background: rgba(255, 255, 255, 0.9);
        color: #4f46e5;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .nav-inactive {
        color: #475569;
        transition: all 0.3s ease;
    }

    .nav-inactive:hover {
        background: rgba(255, 255, 255, 0.9);
        color: #4f46e5;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* 🌟 TIPOGRAFI & LIST ALA PLUMEFORM 🌟 */
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

    /* 🌟 EFEK HOVER KARTU PRODUK 🌟 */
    .product-card {
        transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.4s ease;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
    }

    /* 🌟 ANIMASI & UTILITY 🌟 */
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

    /* Mencegah FOUC sebelum GSAP berjalan */
    .hero-anim,
    .scroll-anim,
    .stagger-item,
    .carousel-item {
        opacity: 0;
        will-change: transform, opacity;
    }

    html {
        scroll-behavior: smooth;
        scroll-padding-top: 120px;
        /* Memberi jarak agar tidak tertutup header melayang */
    }

    html {
        scroll-behavior: smooth;
        scroll-padding-top: 120px;
        /* Ini sangat penting agar judul tidak tertutup navbar melayang */
    }

    .reveal-line {
        will-change: filter, opacity, transform;
    }

    .hover-text .letter {
        display: inline-block;
        will-change: transform, color;
        transform-origin: center bottom;
    }
</style>