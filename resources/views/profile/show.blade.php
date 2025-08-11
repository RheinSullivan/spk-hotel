@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">

            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body text-center p-4">
                    
                    {{-- Avatar default pakai icon --}}
                    <div class="avatar-circle mx-auto mb-3">
                        <i class="bi bi-person-circle"></i>
                    </div>

                    {{-- Nama & Email --}}
                    <h4 class="fw-bold text-primary">{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>

                    {{-- Tombol Edit --}}
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary rounded-pill px-4 mt-3">
                        <i class="bi bi-pencil-square me-1"></i> Edit Profil
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Style tambahan --}}
<style>
    .avatar-circle {
        font-size: 120px;
        color: #6c757d;
    }
    @media (max-width: 576px) {
        .avatar-circle {
            font-size: 80px;
        }
    }
</style>
@endsection
