@extends('layouts.app')

@section('title', 'Profil Saya - Jastrip.id')

@section('content')
<style>
.dashboard-container { max-width:1000px; margin:40px auto; background:#fff; padding:30px; border-radius:16px; box-shadow:0 10px 30px rgba(0,0,0,0.06); font-family:'Poppins',sans-serif; }
.profile-hero { max-width:1000px; margin:40px auto 0; background:linear-gradient(135deg,#2563eb,#0ea5e9); color:#fff; padding:50px 30px; border-radius:20px; text-align:center; box-shadow:0 12px 35px rgba(0,0,0,.1);}
.profile-hero h1 { font-size:30px; font-weight:800;}
.profile-hero p { opacity:.95; margin-top:10px;}
.profile-container { max-width:560px; margin:-40px auto 80px; background:white; padding:40px; border-radius:18px; box-shadow:0 10px 30px rgba(0,0,0,.08);}
.form-group { margin-bottom:18px; }
.form-label { font-weight:600; margin-bottom:6px; display:block; }
.input-icon { position:relative; }
.input-icon svg { position:absolute; left:12px; top:50%; transform:translateY(-50%); width:20px; height:20px; color:#2563eb; }
.form-control { width:100%; padding:12px 14px 12px 44px; border-radius:10px; border:1px solid #dbeafe; transition:.2s; }
.form-control:focus { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.15); }
.button-group { display:flex; gap:12px; margin-top:30px; }
.btn { flex:1; display:inline-flex; align-items:center; justify-content:center; gap:8px; padding:12px; border-radius:10px; font-weight:600; border:none; cursor:pointer; transition:.3s; }
.btn-primary { background:linear-gradient(135deg,#2563eb,#0ea5e9); color:white; }
.btn-secondary { background:#e0e7ff; color:#2563eb; }
.btn:hover { transform:translateY(-3px); box-shadow:0 8px 20px rgba(37,99,235,.25);}
.alert { background:#eff6ff; color:#2563eb; padding:14px; border-radius:12px; margin-bottom:20px; font-weight:600; text-align:center;}
</style>

{{-- HERO --}}
<div class="profile-hero">
    <h1>Profil Saya</h1>
    <p>Kelola informasi akun Anda dengan aman</p>
</div>

{{-- FORM --}}
<div class="profile-container">

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf

        {{-- Nama --}}
        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <div class="input-icon">
                <!-- User Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 1112 21a9 9 0 01-6.879-3.196zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}" required>
            </div>
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label class="form-label">Email</label>
            <div class="input-icon">
                <!-- Envelope Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l-4-4m4 4l4-4m0 8H8m0 0l-4 4m4-4l4 4"/>
                </svg>
                <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}" required>
            </div>
        </div>

        {{-- Phone --}}
        <div class="form-group">
            <label class="form-label">Nomor HP</label>
            <div class="input-icon">
                <!-- Phone Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V8a1 1 0 01-1 1H6a1 1 0 00-1 1v2a1 1 0 001 1h2a1 1 0 011 1v1.586a1 1 0 01-.293.707l-2.414 2.414A1 1 0 015.586 19H5a2 2 0 01-2-2V5z"/>
                </svg>
                <input type="text" name="phone" class="form-control" value="{{ old('phone',$user->phone) }}">
            </div>
        </div>

        {{-- Address --}}
        <div class="form-group">
            <label class="form-label">Alamat</label>
            <div class="input-icon">
                <!-- Location Marker Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5s-3 1.343-3 3 1.343 3 3 3z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21s9-5.686 9-11a9 9 0 10-18 0c0 5.314 9 11 9 11z"/>
                </svg>
                <textarea name="address" rows="3" class="form-control">{{ old('address',$user->address) }}</textarea>
            </div>
        </div>

        <hr>

        {{-- Password --}}
        <div class="form-group">
            <label class="form-label">Password Baru</label>
            <div class="input-icon">
                <!-- Lock Closed Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3 1.343 3 3v3H9v-3c0-1.657 1.343-3 3-3z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-icon">
                <!-- Lock Closed Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.657 0 3 1.343 3 3v3H9v-3c0-1.657 1.343-3 3-3z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11V7a5 5 0 0110 0v4"/>
                </svg>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
            </div>
        </div>

        <div class="button-group">
            <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary">← Kembali</a>
            <button class="btn btn-primary">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
