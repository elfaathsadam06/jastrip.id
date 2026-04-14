@extends('layouts.app')

@section('title', 'Pemesanan - Jastrip.id')

@section('content')

<style>
/* ======================
BASE
====================== */
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

/* ======================
CONTAINER
====================== */
.pemesanan-container {
    max-width: 900px;
    margin: 40px auto;
    background: #ffffff;
    padding: 32px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
}

/* ======================
HEADER (MATCH DASHBOARD)
====================== */
.header-box {
    background: linear-gradient(135deg, #2563eb, #0ea5e9);
    color: white;
    padding: 30px;
    border-radius: 18px;
    margin-bottom: 30px;
}

.header-box h2 {
    font-size: 26px;
    font-weight: 700;
}

.header-box p {
    opacity: .95;
    margin-top: 6px;
}

/* ======================
FORM
====================== */
.form-group {
    margin-bottom: 22px;
}

label {
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 6px;
}

select, input, textarea {
    width: 100%;
    padding: 12px 14px;
    border-radius: 10px;
    border: 1px solid #dbe2ef;
    font-size: 14px;
}

select:focus, input:focus, textarea:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,.15);
}

.note {
    font-size: 13px;
    color: #64748b;
}

/* ======================
CHECKBOX
====================== */
.checkbox-group {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f8fafc;
    padding: 14px;
    border-radius: 12px;
    border: 1px dashed #c7d2fe;
}

.price-tag {
    color:#2563eb;
    font-weight:600;
}

/* ======================
ESTIMASI
====================== */
.estimasi-box {
    background:#f0f7ff;
    padding:18px;
    border-radius:14px;
    display:flex;
    justify-content:space-between;
    margin-bottom:26px;
}

.estimasi-box strong {
    font-size:16px;
}

.estimasi-total strong {
    color:#2563eb;
    font-size:18px;
}

/* ======================
BUTTON
====================== */
.btn-submit {
    width:100%;
    background: linear-gradient(135deg, #2563eb, #0ea5e9);
    color:white;
    padding:14px;
    border-radius:14px;
    border:none;
    font-size:16px;
    font-weight:700;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:8px;
    cursor:pointer;
    transition:.3s;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(37,99,235,.35);
}

/* ======================
ALERT
====================== */
.alert {
    padding:14px;
    border-radius:12px;
    margin-bottom:20px;
}

.alert.success {
    background:#dcfce7;
    color:#166534;
}

.alert.danger {
    background:#fee2e2;
    color:#991b1b;
}

/* ======================
ICON
====================== */
.icon {
    width:18px;
    height:18px;
}
</style>

<div class="pemesanan-container">

    {{-- HEADER --}}
    <div class="header-box">
        <h2>📝 Buat Pesanan Transkripsi</h2>
        <p>Unggah audio Anda dan biarkan sistem kami bekerja secara otomatis.</p>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert danger">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM --}}
    <form action="{{ route('pemesanan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- LAYANAN --}}
        <div class="form-group">
            <label>
                {{-- Heroicon Clipboard --}}
                <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 12h6m-6 4h6M9 8h6M4 6h16v12H4z"/>
                </svg>
                Jenis Layanan
            </label>
            <select name="layanan" required>
                <option value="">-- Pilih Layanan --</option>
                <option value="transkripsi_audio">Transkripsi Audio</option>
                <option value="fgd_seminar">FGD / Seminar</option>
            </select>
        </div>

        {{-- AUDIO --}}
        <div class="form-group">
            <label>
                {{-- Heroicon Upload --}}
                <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5 5 5M12 5v11"/>
                </svg>
                Upload File Audio
            </label>
            <input type="file" id="audio" name="audio" accept=".mp3,.wav,.m4a" required>
            <small class="note">MP3 / WAV / M4A • Maks 100MB</small>
        </div>

        {{-- VERIFIKASI --}}
        <div class="checkbox-group">
            <input type="hidden" name="verification_transkriptor" value="0">
            <input type="checkbox"
                id="verification_transkriptor"
                name="verification_transkriptor"
                value="1">
            <label for="verification_transkriptor">
                Verifikasi oleh Transkriptor
                <span class="price-tag">+ Rp1.000 / menit</span>
            </label>
        </div>

        {{-- ESTIMASI --}}
        <div id="estimasi-container" class="estimasi-box">
            <div>
                ⏱ Durasi: <strong><span id="durasi-audio">0</span> menit</strong>
            </div>
            <div class="estimasi-total">
                💰 Total: <strong>Rp <span id="total-harga">0</span></strong>
            </div>
        </div>

        {{-- CATATAN --}}
        <div class="form-group">
            <label>Catatan Tambahan</label>
            <textarea name="catatan" rows="4" placeholder="Opsional..."></textarea>
        </div>

        {{-- SUBMIT --}}
        <button type="submit" class="btn-submit">
            {{-- Heroicon Paper Airplane --}}
            <svg class="icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M22 2L11 13M22 2l-7 20-4-9-9-4z"/>
            </svg>
            Kirim Pemesanan
        </button>

    </form>
</div>

<script>
const audioInput = document.getElementById('audio');
const check = document.getElementById('verification_transkriptor');

audioInput.addEventListener('change', hitung);
check.addEventListener('change', hitung);

function hitung(){
    const file = audioInput.files[0];
    if(!file) return;

    const audio = new Audio(URL.createObjectURL(file));
    audio.onloadedmetadata = () => {
        const menit = Math.ceil(audio.duration / 60);
        let harga = menit * 3000;
        if(check.checked) harga += menit * 1000;

        document.getElementById('durasi-audio').innerText = menit;
        document.getElementById('total-harga').innerText = harga.toLocaleString('id-ID');
    }
}
</script>

@endsection
