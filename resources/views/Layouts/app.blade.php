<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Combustible</title>

    <!-- Agregado el meta CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS de SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">
    <!-- JavaScript de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- CSS de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- JavaScript de DataTables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- JavaScript de Bootstrap 5 (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        

        /* Estilo del sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: rgba(52, 58, 64, 0.9);
            padding: 15px;
            color: white;
            transition: all 0.3s;
        }

        .sidebar .nav-link {
            color: white;
            font-weight: bold;
            padding: 10px;
            display: block;
            border-radius: 5px;
        }

        .sidebar .nav-link:hover {
            background: #17a2b8;
            color: white;
        }

        .sidebar .nav-link.active {
            background: #1c7430;
            font-weight: 900;
        }

        /* Contenido principal */
        .content {
            margin-left: 260px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        /* Navbar */
        .navbar {
            background: rgba(0, 0, 0, 0.7) !important;
        }

        .navbar .navbar-brand {
            color: white !important;
        }

        /* Botón de ocultar */
        #toggleSidebar {
            position: fixed;
            top: 15px;
            left: 260px;
            z-index: 1000;
            background: rgba(0, 0, 0, 0.8);
            border: none;
            padding: 10px 15px;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: left 0.3s;
        }

        /* Estilos cuando el menú está oculto */
        .sidebar.hidden {
            left: -250px;
        }

        .content.full-width {
            margin-left: 0;
        }

        #toggleSidebar.hidden {
            left: 10px;
        }

        /* Ajuste para móviles */
        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }

            .content {
                margin-left: 0;
            }

            #toggleSidebar {
                left: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Botón para mostrar/ocultar el menú -->
    <button id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('menu') }}" class="nav-link text-center">
            <h4>Gestión de Combustible</h4>
        </a>
        <hr>
            <h5 class="text-center">
                <i class="fas fa-user"></i> {{ Auth::user()->name }}
            </h5>
            <hr>


        <a href="{{ route('registrovehicular.index') }}" class="nav-link">
            <i class="fas fa-car"></i> Registro vehicular
        </a>
        <a href="{{ route('registrocombustible.index') }}" class="nav-link">
            <i class="fas fa-gas-pump"></i> Registro combustible
        </a>
        <a href="{{ route('registroimporte.index') }}" class="nav-link">
            <i class="fas fa-dollar-sign"></i> Importe
        </a>
        <a href="{{ route('RIndex') }}" class="nav-link">
            <i class="fas fa-chart-bar"></i> Reportes
        </a>

        </a>

        @if( Auth::user()->role === 'Administrador')
        <a href="{{ route('user.index') }}" class="nav-link">
        <i class="fas fa-user"></i> Registro de usuario
        </a>

         <a href="{{ route('registrorol.table') }}" class="nav-link">
        <i class="fas fa-users"></i> Gestor de roles
        </a>
        @endif
        

        @auth
            <form id="logout-form" method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="button" class="btn btn-danger w-100" id="logout-button">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </button>
            </form>
        @endauth



    <!-- Contenido principal -->
    <div class="content">
        <div class="container mt-4">
            @yield('contenido')
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('logout-button').addEventListener('click', function(event) {
            event.preventDefault(); // Previene el envío del formulario inmediatamente

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Cerrar sesión terminará tu sesión actual!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, enviamos el formulario
                    document.getElementById('logout-form').submit();
                }
            });
        });


        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('toggleSidebar');
            const content = document.querySelector('.content');
            const links = document.querySelectorAll('.nav-link');

            

            // Mostrar u ocultar el menú lateral
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
                content.classList.toggle('full-width');
                toggleBtn.classList.toggle('hidden');
            });

            // Ocultar el menú cuando se selecciona una opción en pantallas pequeñas
            links.forEach(link => {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.add('hidden');
                        content.classList.add('full-width');
                        toggleBtn.classList.add('hidden');
                    }
                });
            });

            // Mostrar el botón cuando el menú esté oculto en pantallas pequeñas
            window.addEventListener('resize', function () {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('hidden');
                    content.classList.remove('full-width');
                    toggleBtn.classList.remove('hidden');
                }
            });
        });
    </script>

</body>
</html>

