<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: #fff !important;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .title-panel {
            font-size: 36px;
            font-weight: 700;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .card-body {
            padding: 30px;
        }

        .navbar-nav .nav-link {
            font-size: 18px;
        }

        .nav-item {
            margin-right: 15px;
        }
    </style>

</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gestión de Combustible Grupo Plasencia</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-2">
                        <a class="nav-link {{ request()->routeIs('registrovehicular.index') ? 'text-white fw-bold' : '' }}" 
                        href="{{ route('registrovehicular.index') }}">
                            <i class="fa fa-car"></i> Registro vehicular
                        </a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link {{ request()->routeIs('registrocombustible.index') ? 'text-white fw-bold' : '' }}" 
                        href="{{ route('registrocombustible.index') }}">
                            <i class="fa fa-gas-pump"></i> Registro combustible
                        </a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link {{ request()->routeIs('registroimporte.index') ? 'text-white fw-bold' : '' }}" 
                        href="{{ route('registroimporte.index') }}">
                            <i class="fa fa-money-bill"></i> Importe
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container mt-4">
        @yield('contenido')
    </div>

</body>
</html>
