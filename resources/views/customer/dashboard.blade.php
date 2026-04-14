@extends('layouts.app')

@section('title', 'Dashboard Customer')

@section('content')

<style>
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

.order-again-wrapper {
    margin: 10px 0 16px;
}

.btn-order-small {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    background: #2563eb;
    color: white;
    border-radius: 999px;
    text-decoration: none;
    transition: .2s;
}

.btn-order-small .icon {
    width: 14px;
    height: 14px;
}

.btn-order-small:hover { background: #1e40af; }

.summary-boxes {
    display: flex;
    gap: 16px;
    margin-top: 24px;
}

.summary-item {
    flex: 1;
    background: white;
    color: #111;
    padding: 18px;
    border-radius: 12px;
    text-align: center;
}

.table-style {
    width: 100%;
    border-collapse: collapse;
}

.table-style th {
    background: #f1f5f9;
    text-align: left;
    padding: 14px;
    font-weight: 600;
}

.table-style td {
    padding: 14px;
    border-bottom: 1px solid #e5e7eb;
}

.status {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.status.completed { background:#dcfce7; color:#166534; }
.status.processing { background:#dbeafe; color:#1e40af; }
.status.waiting { background:#fef3c7; color:#92400e; }
.status.waiting_verification {background: #fef3c7; color: #92400e; }
.status.failed { background:#fee2e2; color:#991b1b; }

.btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
}

.btn-blue { background:#2563eb; color:white; }
.btn-gray { background:#e5e7eb; color:#111; }

.transcript-box {
    background: #f8fafc;
    padding: 18px;
    border-radius: 12px;
    border-left: 4px solid #2563eb;
}

.transcript-text {
    white-space: pre-wrap;
    line-height: 1.8;
    font-size: 14px;
    max-height: 300px;
    overflow-y: auto;
}

.transcript-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 14px;
}

.download-actions {
    display: flex;
    gap: 8px;
}

.btn-download {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    color: white;
}

.btn-word { background: #2563eb; }
.btn-pdf  { background: #dc2626; }

.btn-download:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,.15);
}
</style>

<div class="dashboard-container">

    {{-- HEADER --}}
    <div class="landing-box">
        <h2 class="text-2xl font-bold">Halo, {{ Auth::user()->name }} 👋</h2>
        <p class="opacity-90 mt-1">Pantau dan unduh hasil transkripsi Anda di sini</p>

        <div class="summary-boxes">
            <div class="summary-item">
                <h3>{{ $pesanan->count() }}</h3>
                <span>Total Pesanan</span>
            </div>

            <div class="summary-item">
                <h3>
                    {{ $pesanan->whereNotIn('status', ['completed','failed','rejected'])->count() }}
                </h3>
                <span>Diproses</span>
            </div>

            <div class="summary-item">
                <h3>{{ $pesanan->where('status','completed')->count() }}</h3>
                <span>Selesai</span>
            </div>

            <div class="summary-item">
                <h3>
                    {{ $pesanan->whereIn('status',['failed','rejected'])->count() }}
                </h3>
                <span>Gagal</span>
            </div>
        </div>
    </div>

    <div class="order-again-wrapper">
        <a href="{{ route('pemesanan.create') }}" class="btn-order-small">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4"/>
            </svg>
            Pesan Lagi
        </a>
    </div>

    <h3 class="text-xl font-bold mb-4">📌 Daftar Pesanan</h3>

    <table class="table-style">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Total</th>
                <th>Status</th>
                <th>Speech (AI)</th>
                <th>Verifikasi (Transkriptor)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pesanan as $item)
        <tr>
            <td class="font-semibold">#{{ $item->order_number }}</td>
            <td class="text-blue-600 font-semibold">Rp{{ number_format($item->total_biaya,0,',','.') }}</td>
            <td>
                <span class="status {{ in_array($item->status, ['failed','rejected']) ? 'failed' : $item->status }}">
                    {{ ucfirst(str_replace('_',' ',$item->status)) }}
                </span>
            </td>

            {{-- AI --}}
            <td>
                @if($item->status === 'rejected')
                    <span class="status failed">Failed</span>
                @elseif(!$item->transkripsi)
                    <span class="status waiting">Waiting</span>
                @elseif($item->transkripsi->status === 'processing')
                    <span class="status processing">Processing</span>
                @elseif($item->transkripsi->status === 'done')
                    <span class="status completed">Completed</span>
                @else
                    <span class="status failed">Failed</span>
                @endif
            </td>

            {{-- Verifikasi transkriptor --}}
            <td>
                @if($item->status === 'rejected')
                    <span class="status failed text-xs px-2 py-1 rounded-full">
                        Failed
                    </span>

                @elseif(!$item->need_transkriptor_verification)
                    <span class="text-gray-400">-</span>

                @elseif($item->status_transkriptor === 'working')
                    <span class="status processing text-xs px-2 py-1 rounded-full flex items-center gap-1">
                        Working
                    </span>

                @elseif(
                    $item->status_transkriptor === 'submitted' &&
                    $item->transkripsi?->revisiTerakhir
                )
                    <span class="status completed text-xs px-2 py-1 rounded-full flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Completed
                    </span>

                @else
                    <span class="status waiting text-xs px-2 py-1 rounded-full">
                        Waiting
                    </span>
                @endif
            </td>

            {{-- Aksi --}}
            <td class="space-x-2">
                @if($item->status === 'waiting_payment')
                    <a href="{{ route('payment.pay',$item->id) }}" class="btn btn-blue">Bayar</a>
                @elseif($item->status === 'waiting_verification')
                    <span class="status processing">⏳ Verifikasi Admin</span>
                @elseif($item->status === 'processing')
                    <span class="status processing">Diproses</span>
                @elseif($item->transkripsi && $item->transkripsi->status === 'done')
                    <button class="btn btn-gray" onclick="toggleAI({{ $item->id }})">
                        Speech
                    </button>
                    @if($item->need_transkriptor_verification && $item->transkripsi->revisiTerakhir)
                        <button class="btn btn-blue" onclick="toggleRevisi({{ $item->id }})">
                            Revisi
                        </button>
                    @endif
                @endif
            </td>
        </tr>

        {{-- DETAIL AI --}}
        @if($item->transkripsi)
        <tr id="ai-{{ $item->id }}" style="display:none">
            <td colspan="6">
                <div class="transcript-box">
                    <div class="transcript-header">
                        <div class="flex items-center gap-2 font-semibold text-gray-800">
                            {{-- Heroicon: Microphone --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-width="1.8"
                                    d="M12 1.5a3 3 0 013 3v6a3 3 0 11-6 0v-6a3 3 0 013-3z"/>
                                <path stroke-width="1.8"
                                    d="M19.5 10.5a7.5 7.5 0 01-15 0"/>
                                <path stroke-width="1.8"
                                    d="M12 18v4.5"/>
                            </svg>
                            Transkripsi Google Speech
                        </div>

                        @if($item->transkripsi->status === 'done')
                        <div class="download-actions">
                            <a href="{{ route('customer.transcript.word', $item->id) }}"
                            class="btn-download btn-word">
                                {{-- Heroicon: Document --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-width="1.8"
                                        d="M12 3v12m0 0l-3-3m3 3l3-3"/>
                                </svg>
                                Word
                            </a>

                            <a href="{{ route('customer.transcript.pdf', $item->id) }}"
                            class="btn-download btn-pdf">
                                {{-- Heroicon: Arrow Down Tray --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-width="1.8"
                                        d="M12 16l4-4m0 0l-4-4m4 4H8"/>
                                </svg>
                                PDF
                            </a>
                        </div>
                        @endif
                    </div>

                    <div class="transcript-text">
                        {{ $item->transkripsi->hasil }}
                    </div>
                </div>
            </td>
        </tr>
        @endif

        {{-- DETAIL REVISI --}}
        @if(
            $item->status_transkriptor === 'submitted' &&
            $item->transkripsi?->revisiTerakhir
        )
        <tr id="revisi-{{ $item->id }}" style="display:none">
            <td colspan="6">
                <div class="transcript-box" style="border-left:4px solid #16a34a">
                    <div class="transcript-header">
                        <div class="flex items-center gap-2 font-semibold text-gray-800">
                            {{-- Heroicon: Pencil Square --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-width="1.8"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.806.806-2.685a4.5 4.5 0 011.13-1.897L16.862 4.487z"/>
                            </svg>
                            Revisi Transkriptor
                        </div>

                        <div class="download-actions">
                            <a href="{{ route('customer.transcript.word', $item->id) }}"
                            class="btn-download btn-word">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-width="1.8"
                                        d="M12 3v12m0 0l-3-3m3 3l3-3"/>
                                </svg>
                                Word
                            </a>

                            <a href="{{ route('customer.transcript.pdf', $item->id) }}"
                            class="btn-download btn-pdf">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-width="1.8"
                                        d="M12 16l4-4m0 0l-4-4m4 4H8"/>
                                </svg>
                                PDF
                            </a>
                        </div>
                    </div>

                    <div class="transcript-text">
                        {{ $item->transkripsi->revisiTerakhir->hasil_revisi }}
                    </div>

                    @if($item->transkripsi->revisiTerakhir->catatan)
                        <div class="mt-3 text-sm text-gray-600 bg-white p-3 rounded-lg">
                            <strong>Catatan Transkriptor:</strong><br>
                            {{ $item->transkripsi->revisiTerakhir->catatan }}
                        </div>
                    @endif
                </div>
            </td>
        </tr>
        @endif

        @endforeach
        </tbody>
    </table>
</div>

<script>
function toggleAI(id){
    const el = document.getElementById('ai-'+id);
    el.style.display = el.style.display === 'none' ? 'table-row' : 'none';
}
function toggleRevisi(id){
    const el = document.getElementById('revisi-'+id);
    el.style.display = el.style.display === 'none' ? 'table-row' : 'none';
}
</script>

@endsection
