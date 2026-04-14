@extends('owner.layout')
@section('title','Laporan Bisnis')

@section('content')

{{-- HEADER --}}
<h2 class="text-2xl font-bold flex items-center gap-3 mb-8">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-600"
        fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-width="2"
            d="M3 3v18h18M9 17V9m4 8V5m4 12v-6"/>
    </svg>
    Laporan Bisnis
</h2>

{{-- KPI --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">

    {{-- TOTAL PESANAN --}}
    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex items-center gap-3 mb-2 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.75H6.912a2.25 2.25 0 0 0-2.15 1.588L2.35 13.177a2.25 2.25 0 0 0-.1.661V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 0 0-2.15-1.588H15M2.25 13.5h3.86a2.25 2.25 0 0 1 2.012 1.244l.256.512a2.25 2.25 0 0 0 2.013 1.244h3.218a2.25 2.25 0 0 0 2.013-1.244l.256-.512a2.25 2.25 0 0 1 2.013-1.244h3.859M12 3v8.25m0 0-3-3m3 3 3-3" />
            </svg>
            Total Pesanan
        </div>
        <p class="text-2xl font-bold">{{ $totalPesanan }}</p>
    </div>

    {{-- SUKSES --}}
    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex items-center gap-3 mb-2 text-green-600">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
            Transaksi Sukses
        </div>
        <p class="text-2xl font-bold text-green-600">{{ $pesananSelesai }}</p>
    </div>

    {{-- DIPROSES --}}
    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex items-center gap-3 mb-2 text-yellow-600">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Sedang Diproses
        </div>
        <p class="text-2xl font-bold text-yellow-600">{{ $pesananDiproses }}</p>
    </div>

    {{-- DITOLAK ADMIN --}}
    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex items-center gap-3 mb-2 text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
            Ditolak Admin
        </div>
        <p class="text-2xl font-bold text-red-600">
            {{ $pesananDitolak }}
        </p>
    </div>

    {{-- OMZET --}}
    <div class="bg-white rounded-xl shadow p-5">
        <div class="flex items-center gap-3 mb-2 text-red-600">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            Total Omzet
        </div>
        <p class="text-2xl font-bold text-red-600">
            Rp{{ number_format($totalOmzet,0,',','.') }}
        </p>
    </div>
</div>

{{-- CHART --}}
<div class="bg-white rounded-xl shadow p-6 mb-10">
    <h3 class="font-semibold mb-4 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
        </svg>
        Distribusi Status Pesanan
    </h3>

    <div class="relative h-[320px]">
        <canvas id="statusChart"></canvas>
    </div>
</div>

{{-- PERFORMA ADMIN --}}
<div class="bg-white rounded-xl shadow p-6 mb-10">
    <h3 class="font-semibold mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M12 3l7 4v5c0 5-3.5 9-7 9s-7-4-7-9V7l7-4z"/>
            </svg>
        Performa Admin
    </h3>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-center">Total Pesanan</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($laporanAdmin as $a)
            <tr>
                <td class="px-4 py-3">{{ $a->name }}</td>
                <td class="px-4 py-3 text-center font-semibold">
                    {{ $a->pesanan_count }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- PERFORMA TRANSKRIPTOR --}}
<div class="bg-white rounded-xl shadow p-6">
    <h3 class="font-semibold mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M4 15v-3a8 8 0 0116 0v3M4 15a2 2 0 002 2h1v-4H6a2 2 0 00-2 2zm16 0a2 2 0 01-2 2h-1v-4h1a2 2 0 012 2z"/>
            </svg>
        Performa Transkriptor
    </h3>

    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-center">Total Transkripsi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @foreach($laporanTranskriptor as $t)
            <tr>
                <td class="px-4 py-3">{{ $t->name }}</td>
                <td class="px-4 py-3 text-center font-semibold">
                    {{ $t->pesanan_count }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- CHART SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('statusChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
                'Selesai',
                'Diproses',
                'Ditolak Admin'
            ],
            datasets: [{
                data: [
                    {{ $chartStatus['completed'] }},
                    {{ $chartStatus['processing'] }},
                    {{ $chartStatus['rejected'] }}
                ],
                backgroundColor: [
                    '#22c55e', // hijau
                    '#facc15', // kuning
                    '#ef4444'  // merah
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>

@endsection
