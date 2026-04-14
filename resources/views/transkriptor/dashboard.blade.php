@extends('transkriptor.layout')
@section('title','Dashboard')

@section('content')

{{-- PAGE HEADER --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <h2 class="text-2xl font-extrabold text-gray-800">
            Dashboard Transkriptor
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Ringkasan pengerjaan revisi transkripsi Jastrip.id
        </p>
    </div>
</div>

    {{-- MENUNGGU --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-yellow-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Menunggu</p>
            <p class="text-3xl font-bold">{{ $pending }}</p>
        </div>
    </div>

    {{-- DIKERJAKAN --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-blue-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Dikerjakan</p>
            <p class="text-3xl font-bold">{{ $working }}</p>
        </div>
    </div>

    {{-- DIKIRIM --}}
    <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
        <div class="bg-green-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Dikirim</p>
            <p class="text-3xl font-bold">{{ $submitted }}</p>
        </div>
    </div>

    {{-- CHART KINERJA --}}
    <div class="mt-10 bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            Statistik Kinerja
        </h3>

        <canvas id="taskChart" height="100"></canvas>
    </div>

    <script>
        const ctx = document.getElementById('taskChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Menunggu', 'Dikerjakan', 'Dikirim'],
                datasets: [{
                    label: 'Jumlah Tugas',
                    data: [
                        {{ $pending }},
                        {{ $working }},
                        {{ $submitted }}
                    ],
                    backgroundColor: [
                        '#facc15',
                        '#3b82f6',
                        '#22c55e'
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
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    </script>

</div>
@endsection
