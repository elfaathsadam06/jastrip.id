@extends('owner.layout')
@section('title','Dashboard')

@section('content')

{{-- HEADER --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">
            Dashboard Owner
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Ringkasan aktivitas sistem keseluruhan Jastrip.id
        </p>
    </div>
</div>
{{-- KPI CARDS --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5 mb-10">

    {{-- TOTAL PESANAN --}}
    <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
        <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <p class="text-2xl font-bold">{{ $totalPesanan }}</p>
        </div>
    </div>

    {{-- TRANSAKSI SUKSES --}}
    <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
        <div class="p-3 rounded-lg bg-green-100 text-green-600">
        <svg xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
                </div>
        <div>
            <p class="text-sm text-gray-500">Transaksi Sukses</p>
            <p class="text-2xl font-bold">{{ $transaksiSukses }}</p>
        </div>
    </div>

    {{-- CUSTOMER --}}
    <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
        <div class="p-3 rounded-lg bg-indigo-100 text-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Customer</p>
            <p class="text-2xl font-bold">{{ $pelangganAktif }}</p>
        </div>
    </div>

    {{-- ADMIN --}}
    <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
        <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M12 3l7 4v5c0 5-3.5 9-7 9s-7-4-7-9V7l7-4z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Admin</p>
            <p class="text-2xl font-bold">{{ $totalAdmin }}</p>
        </div>
    </div>

    {{-- TRANSKRIPTOR --}}
    <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
        <div class="p-3 rounded-lg bg-pink-100 text-pink-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M4 15v-3a8 8 0 0116 0v3M4 15a2 2 0 002 2h1v-4H6a2 2 0 00-2 2zm16 0a2 2 0 01-2 2h-1v-4h1a2 2 0 012 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Transkriptor</p>
            <p class="text-2xl font-bold">{{ $totalTranskriptor }}</p>
        </div>
    </div>
</div>

{{-- CHART SECTION --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- STATUS PESANAN --}}
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center gap-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 text-black-600"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M11 3v18m4-12v12m4-6v6M7 9v12"/>
            </svg>
            <h3 class="font-semibold">Status Pesanan</h3>
        </div>

        <div class="h-[260px] flex justify-center">
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    {{-- KPI RINGKASAN --}}
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center gap-2 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
            <h3 class="font-semibold">Ringkasan KPI</h3>
        </div>

        <ul class="space-y-4 text-sm">
            <li class="flex items-center gap-2">
                <span class="text-green-600">●</span>
                Completion Rate:
                <b>
                    {{ $totalPesanan > 0
                        ? round(($chartCompleted / $totalPesanan) * 100)
                        : 0 }}%
                </b>
            </li>

            <li class="flex items-center gap-2">
                <span class="text-yellow-500">●</span>
                Pesanan Diproses:
                <b>{{ $chartProcessing }}</b>
            </li>

            <li class="flex items-center gap-2">
                <span class="text-red-500">●</span>
                Menunggu Pembayaran:
                <b>{{ $chartWaiting }}</b>
            </li>
        </ul>
    </div>
</div>

{{-- CHART JS --}}
<script>
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Selesai', 'Diproses', 'Menunggu'],
        datasets: [{
            data: [
                {{ $chartCompleted }},
                {{ $chartProcessing }},
                {{ $chartWaiting }}
            ],
            backgroundColor: ['#22c55e','#facc15','#ef4444']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>
@endsection
