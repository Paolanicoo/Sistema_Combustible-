<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Combustible</title>
    
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
   
</head>
<style>
    .title-custom {
        font-family: 'Times New Roman', sans-serif;
        font-size: 26px !important; /* Aumenté el tamaño */
        font-weight: bold !important;
        color: white !important;
    }

    .navbar-nav .nav-link {
        font-size: 17px !important; /* Aumenté el tamaño de los botones */
        font-weight: bold !important;
    }

    .navbar-nav .nav-link.active {
        font-weight: 900 !important;
        color: white !important;
        background-color: #0056b3 !important;
        border-radius: 5px !important;
        padding: 12px 20px !important;
    }
</style>
<body>

    <!-- Navbar -->
    @unless (request()->routeIs('register'))
    @unless (request()->routeIs('login'))
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <img src="{{ asset('img/plasencia.jpg') }}" alt="Logo" width="50" height="50" class="d-inline-block align-text-top me-3">
        
        <a class="navbar-brand title-custom" href="#">Gestión de combustible grupo Plasencia</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link {{ request()->routeIs('registrovehicular.index') ? 'text-white fw-bold' : '' }}" 
                        href="{{ route('registrovehicular.index') }}">
                        <i class="fa fa-money-bill"></i> Registro vehicular
                    </a>
                </li>
                
                <li class="nav-item mx-2">
                    <a class="nav-link {{ request()->routeIs('registrocombustible.index') ? 'text-white fw-bold' : '' }}" 
                        href="{{ route('registrocombustible.index') }}">
                        <i class="fa fa-money-bill"></i> Registro combustible
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
    @endunless
    @endunless

    <!-- Contenido dinámico -->
    <div class="container mt-4">
        @yield('contenido')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>

