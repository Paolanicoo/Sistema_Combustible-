<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Combustible</title>
    
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
   
</head>
<body>

    <!-- Navbar -->
    @unless (request()->routeIs('register'))
    @unless (request()->routeIs('login'))
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <img src="{{ asset('img/plasencia.jpg') }}" alt="Logo" width="50" height="50" class="d-inline-block align-text-top me-3">
            <a style="font-family: 'Times New Roman', sans-serif; font-size: 30px; font-weight: bold;" class="navbar-brand" href="#">Gestión de Combustible Grupo Plasencia</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"> 
                        <a class="nav-link" href="{{ route('registrovehicular.index') }}">Registro Vehicular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('registrocombustible.index') }}">Registro Combustible</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('registroimporte.index') }}">Importe</a>
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

