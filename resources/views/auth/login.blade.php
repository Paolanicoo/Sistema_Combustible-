@extends('layouts.app')

@section('contenido')
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card shadow-lg p-4" style="width: 400px; border-radius: 15px;">
        <div class="text-center">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" width="100">
            <h3 class="mt-3 fw-bold">Iniciar Sesión</h3>
        </div>

        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Correo Electrónico</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('register') }}" class="text-decoration-none">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>
</div>
@endsection
