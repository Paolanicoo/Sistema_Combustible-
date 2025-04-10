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
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script> 
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    @if(session('isPostLogin'))
        <script>
            sessionStorage.setItem('isPostLogin', 'true');
        </script>
    @endif
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        /* Estilo del sidebar */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: white;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
            padding: 0 0 20px 0;
            color: #344767;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar .brand-container {
            padding: 15px;
            margin-bottom: 20px;
            background-color: transparent; /* Quitado el fondo gris */
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            justify-content: center;
            align-items: center;
        }

        .sidebar .brand {
            color: #344767;
            font-weight: 600;
            font-size: 1.4rem; /* Aumentado el tamaño de fuente */
            text-align: center;
            display: block;
            width: 75%;
        }

        .sidebar .user-info {
            padding: 15px;
            background-color: #f8f9fa;
            margin: 0 15px 20px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .sidebar .user-info:hover {
            background-color: #e2e8f0;
        }

        .sidebar .user-info i.user-icon {
            background-color: #0ea5e9;
            color: white;
            padding: 10px;
            border-radius: 8px;
        }

        .sidebar .user-info .user-details {
            flex: 1;
        }

        .sidebar .user-info h5 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .sidebar .user-info .logout-icon {
            color: #ef4444;
            margin-left: auto;
        }

        .sidebar .nav-link {
            color: #64748b;
            font-weight: 500;
            padding: 12px 15px;
            margin: 0 15px 5px 15px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-link:hover {
            background: #f1f5f9;
            color: #0ea5e9;
            transform: translateX(5px);
        }

        .sidebar .nav-link.active {
            background: #0ea5e9;
            color: white;
            font-weight: 600;
        }

        /* Contenido principal */
        .content {
            margin-left: 280px;
            padding: 30px;
            transition: margin-left 0.3s;
        }

        /* Botón de ocultar - Revertido a posición original */
        #toggleSidebar {
            position: fixed;
            top: 30px; /* Separado un poco más del borde superior */
            left: 230px;
            z-index: 1000;
            background:  #0ea5e9;
            border: none;
            padding: 10px 15px;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: left 0.3s;
        }

        /* Estilos cuando el menú está oculto */
        .sidebar.hidden {
            left: -380px;
        }

        .content.full-width {
            margin-left: 0;
        }

        #toggleSidebar.hidden {
            left: 5px;
        }

        /* Ajuste para móviles */
        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
            }

            .content {
                margin-left: 0;
            }

            #toggleSidebar {
                left: 10px;
            }
        }

        /* Divider */
        .sidebar-divider {
            border-top: 1px solid #e2e8f0;
            margin: 15px;
        }

        /* Estilos para secciones */
        .sidebar-section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            font-weight: 600;
            padding: 0 15px;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        /* Botón flotante para mostrar menú en móviles */
        .mobile-toggle {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1002;
            background: #0ea5e9;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
            border: none;
        }

        @media (max-width: 768px) {
            .mobile-toggle {
                display: flex;
            }
        }

        .circle-letter {
            display: inline-block;
            background-color: #0ea5e9;
            color: white;
            font-weight: bold;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            text-align: center;
            line-height: 35px; /* igual al height para centrar verticalmente */
            margin-right: 8px;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Botón para mostrar/ocultar el menú -->
        <button id="toggleSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <div class="brand-container">
            <a href="{{ route('menu') }}" class="brand text-decoration-none">
                <span class="circle-letter">P</span> Gestión de Combustible
            </a>
        </div>


        <!-- Usuario con función de logout -->
        <div class="user-info" id="user-profile">
            <i class="fas fa-user user-icon"></i>
            <div class="user-details">
                <h5>{{ Auth::user()->name }}</h5>
                <small>{{ Auth::user()->role }}</small>
            </div>
            <i class="fas fa-sign-out-alt logout-icon"></i>
        </div>

        <div class="sidebar-section-title">ADMINISTRACIÓN DE REGISTROS</div>
        
        <a href="{{ route('registrovehicular.index') }}" class="nav-link">
            <i class="fas fa-car"></i> Registro vehicular
        </a>
        <a href="{{ route('registrocombustible.index') }}" class="nav-link">
            <i class="fa fa-id-card"></i> Registro combustible
        </a>
        <a href="{{ route('combus.index') }}" class="nav-link">
            <i class="fas fa-gas-pump"></i> Inventario combustible
        </a>
        <a href="{{ route('registroimporte.index') }}" class="nav-link">
            <i class="fas fa-dollar-sign"></i> Importe
        </a>
        <a href="{{ route('RIndex') }}" class="nav-link">
            <i class="fas fa-chart-line"></i> Reportes
        </a>

        @if(Auth::user()->role === 'Administrador')
        <div class="sidebar-section-title">ADMINISTRACIÓN DE USUARIO</div>
        <a href="{{ route('user.index') }}" class="nav-link">
            <i class="fas fa-user"></i> Registro de usuario
        </a>
        <a href="{{ route('registrorol.table') }}" class="nav-link">
            <i class="fas fa-users"></i> Gestor de roles
        </a>
        @endif
        
        <!-- Formulario oculto para logout -->
        @auth
        <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
            @csrf
        </form>
        @endauth
    </div>

    <!-- Botón flotante para móviles -->
    <button class="mobile-toggle" id="mobileToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Contenido principal -->
    <div class="content">
        <div class="container mt-4">
            @yield('contenido')
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const sidebar = document.querySelector('.sidebar');
            const toggleBtn = document.getElementById('toggleSidebar');
            const mobileToggle = document.getElementById('mobileToggle');
            const content = document.querySelector('.content');
            const links = document.querySelectorAll('.nav-link');

            // FORZAR MENÚ OCULTO DESPUÉS DE INICIAR SESIÓN
            // Verificar si venimos directamente del login
            const isPostLogin = sessionStorage.getItem('isPostLogin') === 'true';
            const pathname = window.location.pathname;
            
            // Si acabamos de iniciar sesión O estamos en la página principal después del login
            if (isPostLogin || pathname === '/home' || pathname === '/' || pathname === '/menu') {
                // Forzar menú oculto
                sidebar.classList.add('hidden');
                content.classList.add('full-width');
                toggleBtn.classList.add('hidden');
                localStorage.setItem('sidebarHidden', 'true');
                
                // Limpiar bandera de post-login
                sessionStorage.removeItem('isPostLogin');
            } else {
                // Para otras navegaciones, usar la preferencia guardada
                const shouldHideSidebar = localStorage.getItem('sidebarHidden') === 'true';
                
                if (shouldHideSidebar) {
                    sidebar.classList.add('hidden');
                    content.classList.add('full-width');
                    toggleBtn.classList.add('hidden');
                } else {
                    sidebar.classList.remove('hidden');
                    content.classList.remove('full-width');
                    toggleBtn.classList.remove('hidden');
                }
            }

            // Mostrar u ocultar el menú lateral (y guardar el estado)
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('hidden');
                content.classList.toggle('full-width');
                toggleBtn.classList.toggle('hidden');
                
                // Guardar el estado actual
                const isNowHidden = sidebar.classList.contains('hidden');
                localStorage.setItem('sidebarHidden', isNowHidden ? 'true' : 'false');
            });
            
            // Botón móvil para mostrar el menú
            mobileToggle.addEventListener('click', function() {
                sidebar.classList.remove('hidden');
                content.classList.remove('full-width');
                toggleBtn.classList.remove('hidden');
                localStorage.setItem('sidebarHidden', 'false');
            });

            // Ocultar el menú cuando se selecciona una opción en pantallas pequeñas
            links.forEach(link => {
                link.addEventListener('click', function () {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.add('hidden');
                        content.classList.add('full-width');
                        toggleBtn.classList.add('hidden');
                        localStorage.setItem('sidebarHidden', 'true');
                    }
                });
            });

            // Ajustes especiales para móviles
            if (window.innerWidth <= 768) {
                sidebar.classList.add('hidden');
                content.classList.add('full-width');
                toggleBtn.classList.add('hidden');
                localStorage.setItem('sidebarHidden', 'true');
            }
            
            // Marcar el enlace activo según la URL actual
            const currentUrl = window.location.href;
            $('.nav-link').each(function() {
                const linkUrl = $(this).attr('href');
                if (currentUrl.includes(linkUrl) && linkUrl !== '{{ route("menu") }}') {
                    $(this).addClass('active');
                }
            });
            
            // Cerrar sesión y resetear preferencias
            $('#user-profile').on('click', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: '¿Cerrar sesión?',
                    text: '¿Estás seguro que deseas cerrar tu sesión?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#0ea5e9',
                    confirmButtonText: 'Sí, cerrar sesión',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Establecer bandera para la próxima sesión
                        localStorage.removeItem('sidebarHidden');
                        // Enviar formulario de logout
                        document.getElementById('logout-form').submit();
                    }
                });
            });
        });
    </script>
</body>
</html>