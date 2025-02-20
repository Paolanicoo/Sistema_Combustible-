<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Imagen de fondo */
        body {
            background: url("{{ asset('img/fondo_inicio.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* Título principal */
        .title-panel {
            font-size: 36px;
            font-weight: 700;
            color: #000;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 30px;
            padding: 10px 20px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.8); /* Fondo blanco semitransparente */
        }

        /* Contenedor del login */
        .login-container {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
        }

        /* Imagen dentro del login */
        .login-container img {
            width: 80px;
            display: block;
            margin: 0 auto 15px;
        }
    </style>

</head>
<body>

    <!-- Título Principal -->
    <div class="title-panel">
        Gestión de Combustible Grupo Plasencia
    </div>

    <!-- Contenedor del Login -->
    <div class="login-container">
        <div class="text-center">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo">
            <h3 class="fw-bold">Iniciar Sesión</h3>
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

</body>
</html>
