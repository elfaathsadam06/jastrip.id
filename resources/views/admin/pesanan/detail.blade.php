@extends('admin.layout')
@section('title','Detail Pesanan')

@section('content')

<a href="{{ url()->previous() }}"
    class="inline-flex items-center gap-2 mb-4 text-sm font-semibold
        text-gray-600 hover:text-blue-600 transition">

    <!-- Arrow Left Heroicon -->
    <svg xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-width="2"
            d="M10 19l-7-7 7-7M3 12h18"/>
    </svg>
    Kembali
</a>

<h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
    <!-- Document Icon -->
    <svg xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
    </svg>
    Detail Pesanan #{{ $pesanan->id }}
</h2>

{{-- CARD INFO --}}
<div class="bg-white p-6 rounded-xl shadow space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- CUSTOMER --}}
        <div>
            <p class="text-sm text-gray-500 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor" class="size-5">
            <path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
            </svg>
                Customer
            </p>
            <p class="font-semibold">{{ $pesanan->user->name }}</p>
        </div>

        {{-- EMAIL --}}
        <div>
            <p class="text-sm text-gray-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-5">
                    <path d="M3 4a2 2 0 0 0-2 2v1.161l8.441 4.221a1.25 1.25 0 0 0 1.118 0L19 7.162V6a2 2 0 0 0-2-2H3Z" />
                    <path d="m19 8.839-7.77 3.885a2.75 2.75 0 0 1-2.46 0L1 8.839V14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8.839Z" />
                </svg>
                Email
            </p>
            <p class="font-semibold">{{ $pesanan->user->email }}</p>
        </div>

        {{-- TOTAL --}}
        <div>
            <p class="text-sm text-gray-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M1 4a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4Zm12 4a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM4 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm13-1a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM1.75 14.5a.75.75 0 0 0 0 1.5c4.417 0 8.693.603 12.749 1.73 1.111.309 2.251-.512 2.251-1.696v-.784a.75.75 0 0 0-1.5 0v.784a.272.272 0 0 1-.35.25A49.043 49.043 0 0 0 1.75 14.5Z" clip-rule="evenodd" />
                </svg>
                Total Biaya
            </p>
            <p class="font-bold text-blue-600">
                Rp {{ number_format($pesanan->total_biaya,0,',','.') }}
            </p>
        </div>

        {{-- STATUS --}}
        <div>
            <p class="text-sm text-gray-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="size-5">
                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                </svg>
                Status Pesanan
            </p>

            @php
                $statusColor = match($pesanan->status) {
                    'waiting_payment' => 'bg-yellow-100 text-yellow-700',
                    'paid' => 'bg-blue-100 text-blue-700',
                    'processing' => 'bg-indigo-100 text-indigo-700',
                    'completed' => 'bg-green-100 text-green-700',
                    'rejected' => 'bg-red-100 text-red-700',
                    default => 'bg-gray-100 text-gray-700'
                };
            @endphp

            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColor }}">
                {{ str_replace('_',' ', ucfirst($pesanan->status)) }}
            </span>
        </div>
    </div>

    {{-- ▶ PROSES AI --}}
    @if($pesanan->status === 'paid')
    <form method="POST" action="{{ route('admin.transkripsi.proses', $pesanan->id) }}">
        @csrf
        <button class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700
            text-white px-6 py-3 rounded-lg font-semibold transition">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M5 3v18l7-5 7 5V3z"/>
            </svg>
            Proses Transkripsi AI
        </button>
    </form>
    @endif

    {{-- 📤 KIRIM KE TRANSKRIPTOR --}}
    @if(
        $pesanan->status === 'completed' &&
        $pesanan->need_transkriptor_verification &&
        !$pesanan->assigned_transkriptor_id
    )
    <div class="bg-purple-50 border border-purple-200 p-6 rounded-xl mt-8">
        <h3 class="font-bold mb-4 flex items-center gap-2 text-purple-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Kirim ke Transkriptor
        </h3>

        <form method="POST" action="{{ route('admin.pesanan.kirim', $pesanan->id) }}">
            @csrf

            <label class="block mb-2 font-semibold text-sm">
                Pilih Transkriptor
            </label>

        <p class="text-xs text-gray-500 mb-2">
            Transkriptor dikelompokkan berdasarkan jumlah tugas aktif
        </p>

            <select name="assigned_transkriptor_id"
                class="border p-3 rounded-lg w-full mb-4" required>

                {{-- BEBAN RINGAN --}}
                <optgroup label="🟢 Beban Ringan">
                    @foreach($transkriptors->where('beban_kerja', '<=', 2) as $t)
                        <option value="{{ $t->id }}">
                            {{ $t->name }} • {{ $t->beban_kerja }} tugas
                        </option>
                    @endforeach
                </optgroup>

                {{-- BEBAN SEDANG --}}
                <optgroup label="🟡 Beban Sedang">
                    @foreach($transkriptors->whereBetween('beban_kerja', [3,5]) as $t)
                        <option value="{{ $t->id }}">
                            {{ $t->name }} • {{ $t->beban_kerja }} tugas
                        </option>
                    @endforeach
                </optgroup>

                {{-- BEBAN TINGGI --}}
                <optgroup label="🔴 Beban Tinggi">
                    @foreach($transkriptors->where('beban_kerja', '>=', 6) as $t)
                        <option value="{{ $t->id }}">
                            {{ $t->name }} • {{ $t->beban_kerja }} tugas
                        </option>
                    @endforeach
                </optgroup>
            </select>

            <button
                class="bg-purple-600 hover:bg-purple-700 text-white
                px-6 py-2 rounded-lg font-semibold transition">
                Kirim Tugas
            </button>
        </form>
    </div>
    @endif

    @if($pesanan->assigned_transkriptor_id)
    <span class="inline-flex items-center gap-2
        bg-purple-100 text-purple-700
        px-3 py-1 rounded-full text-xs font-semibold mt-4">

        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-width="2"
                d="M5 13l4 4L19 7"/>
        </svg>
        Sudah dikirim ke transkriptor
    </span>

@endif

@endsection
