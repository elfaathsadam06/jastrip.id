@extends('admin.layout')
@section('title','Dashboard')

@section('content')

{{-- PAGE HEADER --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">
            Dashboard Admin
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Ringkasan aktivitas sistem Jastrip.id
        </p>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">

    {{-- TOTAL USER --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="p-3 bg-blue-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total User</p>
            <h3 class="text-2xl font-bold text-gray-800">
                {{ $totalUsers }}
            </h3>
        </div>
    </div>

    {{-- TOTAL PESANAN --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="p-3 bg-indigo-100 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2"
                        d="M9 12h6m-6 4h6M7 4h10a2 2
                        0 012 2v12a2 2 0 01-2 2H7a2 2
                        0 01-2-2V6a2 2 0 012-2z"/>
                </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Pesanan</p>
            <h3 class="text-2xl font-bold text-gray-800">
                {{ $totalPesanan }}
            </h3>
        </div>
    </div>

    {{-- WAITING VERIFICATION --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="p-3 bg-yellow-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Menunggu Verifikasi</p>
            <h3 class="text-2xl font-bold text-yellow-600">
                {{ $waitingVerification }}
            </h3>
        </div>
    </div>

    {{-- PAID --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="p-3 bg-green-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Sudah Dibayar</p>
            <h3 class="text-2xl font-bold text-green-600">
                {{ $waitingPayment }}
            </h3>
        </div>
    </div>

    {{-- PROCESSING --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="p-3 bg-blue-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
    <div>
        <p class="text-sm text-gray-500">Sedang Diproses</p>
        <h3 class="text-2xl font-bold text-blue-600">
            {{ $processing }}
        </h3>
    </div>
</div>

    {{-- COMPLETED --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="p-3 bg-emerald-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Selesai</p>
            <h3 class="text-2xl font-bold text-emerald-600">
                {{ $completed }}
            </h3>
        </div>
    </div>

</div>

{{-- CHART --}}
<div class="bg-white rounded-xl shadow p-6">
    <div class="flex items-center gap-2 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
        </svg>
        <h3 class="text-lg font-semibold text-gray-700">
            Statistik Pesanan
        </h3>
    </div>

    <canvas id="chart" height="90"></canvas>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('chart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                'Waiting Verification',
                'Paid',
                'Processing',
                'Completed'
            ],
            datasets: [{
                data: [
                    {{ $waitingVerification }},
                    {{ $waitingPayment }},
                    {{ $processing }},
                    {{ $completed }}
                ],
                backgroundColor: [
                    '#facc15',
                    '#22c55e',
                    '#60a5fa',
                    '#16a34a'
                ],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            }
        }
    });
});
</script>

@endsection
