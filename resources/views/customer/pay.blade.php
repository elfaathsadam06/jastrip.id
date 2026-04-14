@extends('layouts.app')

@section('title', 'Pembayaran Pesanan')

@section('content')
<style>
/* ===== CARD ===== */
.payment-card {
    max-width: 560px;
    margin: 50px auto;
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 12px 35px rgba(0,0,0,.08);
    font-family: 'Poppins', sans-serif;
}

/* ===== HEADER ===== */
.payment-header {
    text-align: center;
    margin-bottom: 30px;
}
.payment-header h2 {
    font-size: 26px;
    font-weight: 800;
}
.total-box {
    margin-top: 14px;
    background:#eff6ff;
    padding: 14px;
    border-radius: 14px;
    color:#2563eb;
    font-size: 18px;
    font-weight: 700;
}

/* ===== LABEL ===== */
.label {
    font-weight: 600;
    color:#334155;
    margin-bottom: 6px;
    display:block;
}

/* ===== INPUT ===== */
.select, .file {
    width:100%;
    padding:12px 14px;
    border-radius:12px;
    border:1px solid #dbeafe;
    background:#f8faff;
    transition:.25s;
}
.select:focus, .file:focus {
    background:white;
    border-color:#2563eb;
    box-shadow:0 0 0 3px rgba(37,99,235,.15);
}

/* ===== PAYMENT INFO ===== */
.payment-info {
    background:#f1f5ff;
    padding:18px;
    border-radius:14px;
    margin-bottom:18px;
    text-align:center;
    font-size:14px;
    display:none;
}

/* ===== ALERT WARNING (SAMA SEPERTI PEMESANAN) ===== */
.alert-warning {
    background:#fef9c3;
    color:#854d0e;
    padding:14px;
    border-radius:12px;
    margin-bottom:20px;
    font-size:14px;
    display:none;
}

/* ===== BUTTON ===== */
.btn-submit {
    width:100%;
    padding:14px;
    border-radius:14px;
    border:none;
    font-weight:700;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    transition:.3s;
    margin-top:28px;

    /* tampil seperti disabled */
    background:#c7d2fe;
    color:#1e3a8a;
    cursor:pointer;
}

.btn-submit.active {
    background:linear-gradient(135deg,#2563eb,#0ea5e9);
    color:white;
}
.btn-submit.active:hover {
    transform:translateY(-3px);
    box-shadow:0 12px 25px rgba(37,99,235,.3);
}

/* ===== ICON ===== */
.icon {
    width:22px;
    height:22px;
}
</style>

<div class="payment-card">

    {{-- HEADER --}}
    <div class="payment-header">
        <h2>Pembayaran Pesanan</h2>
        <div class="text-slate-500">Pesanan #{{ $pesanan->order_number }}</div>
        <div class="total-box">
            Rp{{ number_format($pesanan->total_biaya,0,',','.') }}
        </div>
    </div>

    {{-- WARNING --}}
    <div id="methodWarning" class="alert-warning">
        ⚠️ Silakan pilih metode pembayaran terlebih dahulu.
    </div>

    <form method="POST"
        action="{{ route('payment.upload', $pesanan->id) }}"
        enctype="multipart/form-data"
        onsubmit="return validatePayment()">
        @csrf

        {{-- METODE --}}
        <label class="label">Metode Pembayaran</label>
        <select id="payment_method" name="payment_method"
            class="select mb-4"
            onchange="updatePaymentUI()">
            <option value="">-- Pilih Metode --</option>
            <option value="bca">Bank BCA</option>
            <option value="mandiri">Bank Mandiri</option>
            <option value="qris">QRIS</option>
        </select>

        {{-- INFO --}}
        <div id="payment-info" class="payment-info"></div>

        {{-- UPLOAD --}}
        <label class="label mt-4">Upload Bukti Pembayaran</label>
        <input type="file"
            id="bukti"
            name="bukti_pembayaran"
            class="file mb-5"
            accept="image/*,application/pdf"
            onchange="updatePaymentUI()">

        {{-- BUTTON --}}
        <button type="submit" id="submitBtn" class="btn-submit">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12l4-4m0 0l-4-4m4 4H8"/>
            </svg>
            Kirim Bukti Pembayaran
        </button>
    </form>
</div>

<script>
function updatePaymentUI() {
    const method = payment_method.value;
    const bukti  = buktiInput.value;
    const info   = document.getElementById('payment-info');
    const btn    = document.getElementById('submitBtn');
    const warning = document.getElementById('methodWarning');

    warning.style.display = 'none';
    info.style.display = 'none';
    btn.classList.remove('active');

    if (method) {
        info.style.display = 'block';

        if (method === 'bca') {
            info.innerHTML = `<b>Bank BCA</b><br>No Rek: <b>1234567890</b><br>A/N: PT Jastrip Indonesia`;
        }
        if (method === 'mandiri') {
            info.innerHTML = `<b>Bank Mandiri</b><br>No Rek: <b>0987654321</b><br>A/N: PT Jastrip Indonesia`;
        }
        if (method === 'qris') {
            info.innerHTML = `<b>QRIS</b><br>Scan QR untuk pembayaran`;
        }
    }

    if (method && bukti) {
        btn.classList.add('active');
    }
}

function validatePayment() {
    if (!payment_method.value) {
        methodWarning.style.display = 'block';
        methodWarning.scrollIntoView({ behavior:'smooth' });
        return false;
    }
    return true;
}

const buktiInput = document.getElementById('bukti');
</script>
@endsection
