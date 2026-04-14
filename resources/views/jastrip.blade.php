@extends('layouts.app')

@section('title', 'Jastrip.id - Jasa Transkripsi Profesional')

@section('content')

<style>
html { scroll-behavior: smooth; }

.dashboard-container {
    max-width: 1000px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    font-family: 'Poppins', sans-serif;
}

.landing-box {
    background: linear-gradient(135deg, #2563eb, #0ea5e9);
    color: white;
    padding: 32px;
    border-radius: 18px;
    margin-bottom: 30px;
}

/* ===== HERO ===== */
.hero {
    max-width: 1000px;
    margin: 40px auto;
    background: linear-gradient(135deg, #2563eb, #0ea5e9);
    color: white;
    padding: 80px 40px;
    border-radius: 18px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}

.hero h1 {
    font-size: 40px;
    font-weight: 800;
    margin-bottom: 20px;
}

.hero p {
    font-size: 18px;
    opacity: .95;
    max-width: 720px;
    margin: 0 auto 30px;
    line-height: 1.8;
}

.hero .cta {
    background: white;
    color: #2563eb;
    padding: 14px 34px;
    border-radius: 999px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    transition: .3s;
}

.hero .cta:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(255,255,255,.35);
}

/* ===== SECTION ===== */
.section {
    max-width: 1000px;
    margin: 80px auto;
    text-align: center;
    padding: 0 20px;
    scroll-margin-top: 100px;
}

.section h2 {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 18px;
    color:#2563eb;
}

.section p {
    max-width: 720px;
    margin: 0 auto;
    color:#475569;
    line-height:1.8;
}

/* ===== CARD ===== */
.card-grid,
.price-grid,
.testi-grid {
    display: flex;
    gap: 24px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 40px;
}

.card,
.price-card,
.testi-card {
    background: white;
    padding: 28px;
    border-radius: 18px;
    width: 280px;
    box-shadow: 0 8px 25px rgba(0,0,0,.06);
    transition:.3s;
}

.card:hover,
.price-card:hover,
.testi-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 35px rgba(37,99,235,.18);
}

.icon {
    width:30px;
    height:30px;
    margin-bottom: 12px;
    color:#2563eb;
}

/* ===== PRICE ===== */
.price {
    font-size: 28px;
    font-weight: 800;
    margin: 10px 0;
}

.price-note {
    font-size: 14px;
    color:#64748b;
}

/* ===== TESTIMONI ===== */
.testi-card {
    border-left: 5px solid #2563eb;
    width: 300px;
}

.testi-text {
    font-style: italic;
    color:#334155;
    line-height:1.7;
}

.testi-user {
    margin-top: 14px;
    font-weight: 700;
    color:#2563eb;
}
</style>

{{-- HERO --}}
<div class="hero">
    <h1>Transkripsi Audio Profesional & Cepat</h1>
    <p>Solusi transkripsi modern dengan AI & verifikasi manusia.</p>

    <a href="#harga" class="cta">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13 7l5 5m0 0l-5 5m5-5H6"/>
        </svg>
        Lihat Harga
    </a>
</div>

{{-- LAYANAN --}}
<div class="section" id="layanan">
    <h2>Layanan Kami</h2>
    <p>Beragam layanan transkripsi sesuai kebutuhan Anda.</p>

    <div class="card-grid">
        <div class="card">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M9 12h6m-6 4h6M9 8h6"/>
            </svg>
            <h4>Transkripsi Audio</h4>
            <p>Podcast, wawancara, voice note.</p>
        </div>

        <div class="card">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M8 7h8M8 11h8M8 15h8"/>
            </svg>
            <h4>FGD & Seminar</h4>
            <p>Multi speaker & akademik.</p>
        </div>

        <div class="card">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <h4>Proofreading</h4>
            <p>Verifikasi transkriptor.</p>
        </div>
    </div>
</div>

{{-- HARGA --}}
<div class="section" id="harga" style="background:#f8faff;border-radius:28px;padding:70px 20px">
    <h2>Harga Transkripsi</h2>
    <p>Harga transparan, tanpa biaya tersembunyi.</p>

    <div class="price-grid">
        <div class="price-card">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10v2m0 8v2"/>/>
            </svg>
            <h4>AI Transkripsi</h4>
            <div class="price">Rp3.000</div>
            <div class="price-note">per menit</div>
        </div>

        <div class="price-card">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
            <h4>Verifikasi Transkriptor</h4>
            <div class="price">+ Rp1.000</div>
            <div class="price-note">per menit</div>
        </div>

        <div class="price-card">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <h4>Premium</h4>
            <div class="price">Custom</div>
            <div class="price-note">FGD, Seminar, Multi-speaker</div>
        </div>
    </div>
</div>

{{-- TESTIMONI --}}
<div class="section" id="testimoni">
    <h2>Testimoni Pelanggan</h2>
    <p>Ribuan pengguna telah mempercayakan transkripsi mereka ke Jastrip.id</p>

    <div class="testi-grid">
        <div class="testi-card">
            <p class="testi-text"> “Prosesnya cepat banget dan hasilnya rapi. Cocok untuk penelitian saya.” </p>
            <div class="testi-user">— Nanda, Mahasiswa UI</div>
            </div>

        <div class="testi-card">
            <p class="testi-text"> “Fitur verifikasi transkriptornya sangat membantu, hasilnya akurat.” </p>
            <div class="testi-user">— Rani, Peneliti UGM</div>
            </div>

        <div class="testi-card"> <p class="testi-text"> “Dashboard-nya enak, bisa download Word & PDF langsung.” </p>
        <div class="testi-user">— Fajar, Jurnalis</div>
    </div>
</div>

@endsection
