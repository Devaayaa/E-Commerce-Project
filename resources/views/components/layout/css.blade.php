<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>
    /* KEMBALI KE TEMA TERANG DEEPSEEK */
    body { 
        font-family: 'Inter', sans-serif; 
        background-color: #f6f9fc; 
        overflow-x: hidden; 
    }
    
    .bg-grid {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
        background-image: linear-gradient(to right, rgba(0,0,0,0.03) 1px, transparent 1px),
                          linear-gradient(to bottom, rgba(0,0,0,0.03) 1px, transparent 1px);
        background-size: 40px 40px;
    }
    .glow-orb { position: fixed; border-radius: 50%; filter: blur(100px); z-index: -1; opacity: 0.5; }
    .orb-1 { top: -10%; left: -10%; width: 50vw; height: 50vw; background: #e0e7ff; }
    .orb-2 { bottom: -10%; right: -10%; width: 40vw; height: 40vw; background: #dbeafe; }

    /* 🌟 HEADER KACA KEBIRUAN (SANGAT TRANSPARAN) 🌟 */
    .header-glass-blue {
        /* Warna putih kebiruan dengan transparansi tinggi (20% - 40%) */
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.4) 0%, rgba(224, 231, 255, 0.2) 100%);
        backdrop-filter: blur(24px) saturate(200%);
        -webkit-backdrop-filter: blur(24px) saturate(200%);
        /* Border tipis kaca */
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-top: 1px solid rgba(255, 255, 255, 0.9);
        /* Bayangan halus dan pendaran dalam */
        box-shadow: 0 10px 30px -5px rgba(31, 38, 135, 0.05), 
                    inset 0 0 20px rgba(255, 255, 255, 0.6);
    }

    /* 🌟 KAPSUL MENU TENGAH (Lebih pekat sedikit) 🌟 */
    .nav-center-glass {
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: inset 0 2px 5px rgba(255, 255, 255, 0.9);
    }

       /* Menu Aktif (Beranda saat ini) */
    .nav-active {
        background: rgba(255, 255, 255, 0.9);
        color: #4f46e5; /* Warna Indigo/DeepSeek */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* Menu Tidak Aktif */
    .nav-inactive {
        color: #475569;
        transition: all 0.3s ease;
    }
    
    /* 🌟 EFEK HOVER (Menjadi Kaca Putih seperti Beranda) 🌟 */
    .nav-inactive:hover {
        background: rgba(255, 255, 255, 0.9); /* Latar putih kaca */
        color: #4f46e5; /* Teks membiru */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); /* Bayangan lembut */
    }

     /* 🌟 GAYA TAMBAHAN ALA TRACED.LIFE 🌟 */
    .font-serif-display {
        font-family: 'Georgia', 'Times New Roman', serif;
        letter-spacing: -0.02em;
    }
    .section-divider {
        border-top: 1px solid rgba(0, 0, 0, 0.08);
        padding-top: 3rem;
        margin-top: 3rem;
    }
    .step-number {
        font-size: 3rem;
        line-height: 1;
        font-weight: 700;
        color: #e2e8f0; /* Warna angka yang sangat pudar */
        font-family: 'Georgia', serif;
    }
    .glass-panel {
        background: rgba(255, 255, 255, 0.6);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.05);
    }

        /* 🌟 ANIMASI ALA PLUMEFORM 🌟 */
    
    /* Animasi Fade Up (Untuk Elemen Hero) */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Animasi Fade In Sederhana */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Class Utility untuk Animasi */
    .animate-fade-up {
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0; /* Mulai transparan */
    }
    
    .animate-fade-in {
        animation: fadeIn 1s ease forwards;
        opacity: 0;
    }

    /* Delay Bertingkat (Staggered Delay) */
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    .delay-400 { animation-delay: 0.4s; }
    .delay-500 { animation-delay: 0.5s; }

    /* Efek Hover Halus untuk Kartu Produk */
    .product-card {
        transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.4s ease;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
    }

    /* Garis Dekoratif Editorial */
    .editorial-line {
        height: 1px;
        background: linear-gradient(to right, transparent, rgba(0,0,0,0.1), transparent);
        margin: 2rem 0;
    }

        /* 🌟 GAYA EDITORIAL ALA PLUMEFORM TEMPLATES 🌟 */
    .font-serif-display {
        font-family: 'Playfair Display', 'Georgia', serif;
        letter-spacing: -0.02em;
    }

    /* List Item dengan Garis Pembatas Tipis */
    .template-list-item {
        border-bottom: 1px solid #e2e8f0;
        padding: 2.5rem 0;
        transition: background-color 0.3s ease;
    }
    .template-list-item:last-child {
        border-bottom: none;
    }
    .template-list-item:hover {
        background-color: #f8fafc; /* Sedikit highlight saat di-hover */
    }

    /* Tag Kecil untuk Kategori */
    .tag-mini {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: #64748b;
    }

    /* Animasi Masuk */
    .reveal-list {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
    }
    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
} 

</style>