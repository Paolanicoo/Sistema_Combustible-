<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     
    <title>@yield('titulo')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Cambiar el color del texto del título a blanco */
        .navbar-brand {
            font-size: 24px; /* Tamaño grande */
            font-weight: bold; /* En negrita */
            color: #fff !important; /* Color blanco */
            text-transform: uppercase; /* Mayúsculas */
            letter-spacing: 2px; /* Espaciado entre letras */
        }

        .title-panel {
            font-size: 36px; /* Aumentamos el tamaño del título */
            font-weight: 700; /* Negrita */
            color: #343a40; /* Color oscuro */
            text-align: center; /* Centrado */
            margin-bottom: 20px; /* Margen inferior */
            text-transform: uppercase; /* Mayúsculas */
            letter-spacing: 1.5px; /* Espaciado entre letras */
        }

        .card-body {
            padding: 30px; /* Padding para mayor espacio */
        }

        .navbar-nav .nav-link {
            font-size: 18px; /* Tamaño de texto para los enlaces */
        }

        .nav-item {
            margin-right: 15px; /* Espacio entre los enlaces */
        }
    </style>

</head>
<body>
    <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <!-- Título con color negro y estilo personalizado -->
                <a class="navbar-brand text-dark fs-4 fw-bold" href="#">Gestión de Combustible Grupo Plasencia</a>
                
                <!-- Botón para colapsar el menú en dispositivos móviles -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Enlaces del menú -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto"> <!-- ms-auto para alinear a la derecha -->
                        <!-- Registro Vehicular -->
                        <li class="nav-item mx-2"> <!-- mx-2 para agregar espacio entre los enlaces -->
                            <a class="nav-link active" href="{{ route('registrovehicular.index') }}">
                                <i class="fa fa-car"></i> Registro vehicular
                            </a>
                        </li>
                        
                        <!-- Registro Combustible -->
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('registrocombustible.index') }}">
                                <i class="fa fa-gas-pump"></i> Registro combustible
                            </a>
                        </li>
                        
                        <!-- Importe -->
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('registroimporte.index') }}">
                                <i class="fa fa-money-bill"></i> Importe
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


    <!-- Contenido principal -->
    <div>
         @yield('contenido')
    </div>

</body>
</html>
