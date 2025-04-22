<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Combustible</title>
    <link rel="icon" href="{{ asset('img/icono.PNG') }}" type="image/PNG">
    
    <!-- Otros estilos y scripts que ya tenías en el head -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    

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
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
        }

        .sidebar .brand {
            color: #344767;
            font-weight: 900;
            font-size: 1.4rem;
            text-align: center;
            display: block;
            width: 100%;
            transition: all 0.3s ease;
            padding: 10px;
            border-radius: 8px;
            margin: 0 15px;
            margin-left: -1px; /* Igual que el activo */
            text-decoration: none;
        }

        .sidebar .brand.active {
            background: #0ea5e9;
            color: white;
            font-weight: 900;
            margin-left: -1px;
        }

        /* Estilos generales para todos los enlaces del menú (como estaban antes) */
        .sidebar .nav-link {
            color: #333;
            background: transparent;
            font-weight: 600;
            border-radius: 5px;
            margin-bottom: 5px;
            padding: 10px 15px;
            display: block;
            transition: all 0.3s ease;
        }

        /* Solo para el enlace del menú principal */
        .sidebar .nav-link.menu-principal {
            background: #0ea5e9;
            color: white;
        }

        /* Movimiento al pasar el mouse solo en el enlace del menú principal */
        .sidebar .nav-link.menu-principal:hover {
            transform: translateX(5px);
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

        /* Botón para toggle del sidebar */
        #toggleSidebar {
            cursor: pointer;
            font-size: 2.2rem; 
            color: #0ea5e9; 
            font-weight: 700;
            background-color: #f8fafc;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 30px;
            right: -24px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1001;
        }

        #toggleSidebar:hover {
            transform: scale(1.1);
            background-color: #e2e8f0;
        }

        /* Estilos para el botón cuando el sidebar está oculto */
        #toggleSidebar.hidden {
            right: auto;
            left: 20px;
            background-color: #0ea5e9;
            color: white;
        }

        /* Estilos cuando el menú está oculto */
        .sidebar.hidden {
            left: -380px;
        }

        .content.full-width {
            margin-left: 0;
        }

        /* Ajuste para móviles */
        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
            }

            .content {
                margin-left: 0;
            }

            #toggleSidebar.hidden {
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

        /* Estilos adicionales para el botón flotante */
        .floating-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #0ea5e9;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 1100;
            font-weight: 700;
            font-size: 2.2rem;
            transition: transform 0.3s ease;
        }
        
        .floating-toggle:hover {
            transform: scale(1.1);
        }

        /* Sticky footer que permanece abajo aunque no haya contenido suficiente */
        html {
            height: 100%;
        }

        body {
            min-height: 100%;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1 0 auto;
        }

        .footer {
            flex-shrink: 0;
            background-color: #f8f9fa;
            text-align: center;
            padding: 0.10rem 0;
            border-top: 1px solid #e2e8f0;
            width: 100%;
        }

        .footer-content {
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            color: #718096;
        }
    </style>

    @yield('styles')
    </head>
    <body>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Botón para mostrar/ocultar el menú -->
            <div id="toggleSidebar">≡</div>

            <div class="brand-container">
                <a href="{{ route('menu') }}" class="brand {{ (request()->is('menu') || request()->is('/') || request()->is('home')) ? 'active' : '' }}" id="brandLink">
                    Gestión de Combustible
                </a>
            </div>

            <!-- Usuario con función de logout -->
            @if(Auth::check())
            <div class="user-info" id="user-profile">
                <i class="fas fa-user user-icon"></i>
                <div class="user-details">
                    <h5>{{ Auth::user()->name }}</h5>
                    <small>{{ Auth::user()->role }}</small>
                </div>
                <i class="fas fa-sign-out-alt logout-icon"></i>
            </div>

            <div class="sidebar-section-title">ADMINISTRACIÓN DE REGISTROS</div>
            
            <a href="{{ route('registrovehicular.index') }}" class="nav-link {{ request()->routeIs('registrovehicular.*') ? 'active' : '' }}">
                <i class="fas fa-car"></i> Registro vehicular
            </a>
            <a href="{{ route('registrocombustible.index') }}" class="nav-link {{ request()->routeIs('registrocombustible.*') ? 'active' : '' }}">
                <i class="fa fa-id-card"></i> Registro combustible
            </a>
            @if(Auth::user()->role === 'Administrador')
            <a href="{{ route('combus.index') }}" class="nav-link {{ request()->routeIs('combus.*') ? 'active' : '' }}">
                <i class="fas fa-gas-pump"></i> Inventario combustible
            </a>
            @endif
            <a href="{{ route('registroimporte.index') }}" class="nav-link {{ request()->routeIs('registroimporte.*') ? 'active' : '' }}">
                <i class="fas fa-dollar-sign"></i> Importe
            </a>
            <a href="{{ route('RIndex') }}" class="nav-link {{ request()->routeIs('RIndex') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Reportes
            </a>

            @if(Auth::user()->role === 'Administrador')
            <div class="sidebar-section-title">ADMINISTRACIÓN DE USUARIO</div>
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Registro de usuario
            </a>
            <a href="{{ route('registrorol.table') }}" class="nav-link {{ request()->routeIs('registrorol.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Gestor de roles
            </a>
            @endif
            
            <!-- Formulario oculto para logout -->
            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                @csrf
            </form>
            @else
            <!-- Mostrar opción de login para usuarios no autenticados -->
            <div class="user-info" onclick="window.location.href='{{ route('login') }}'">
                <i class="fas fa-sign-in-alt user-icon"></i>
                <div class="user-details">
                    <h5>Iniciar sesión</h5>
                </div>
            </div>
            @endif
        </div>

        <!-- Botón P flotante cuando el sidebar está oculto -->
        <div id="floatingToggle" class="floating-toggle">≡</div>

        <!-- Botón flotante para móviles -->
        <button class="mobile-toggle" id="mobileToggle">
            <span>≡</span>
        </button>

        <!-- Contenido principal -->
        <div class="content">
            <div class="container mt-4">
                @yield('contenido')
            </div>
        </div>

        <div class="content-wrapper">
            <!-- Todo el contenido de tus vistas irá aquí -->
            @yield('content')
        </div>
        
        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    © 2025 Todos los derechos reservados. Grupo Plasencia (Gestión Combustible) - Clasificadora y Exportadora de Tabaco S.A. 
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const sidebar = document.querySelector('.sidebar');
                const toggleBtn = document.getElementById('toggleSidebar');
                const floatingToggle = document.getElementById('floatingToggle');
                const mobileToggle = document.getElementById('mobileToggle');
                const content = document.querySelector('.content');
                const links = document.querySelectorAll('.nav-link');

                // Función para actualizar la visibilidad de los botones de toggle
                function updateToggleVisibility(isSidebarHidden) {
                    if (isSidebarHidden) {
                        toggleBtn.classList.add('hidden');
                        floatingToggle.style.display = 'flex';
                    } else {
                        toggleBtn.classList.remove('hidden');
                        floatingToggle.style.display = 'none';
                    }
                }

                // FORZAR MENÚ OCULTO DESPUÉS DE INICIAR SESIÓN
                // Verificar si venimos directamente del login
                const isPostLogin = sessionStorage.getItem('isPostLogin') === 'true';
                const pathname = window.location.pathname;
                
                // Si acabamos de iniciar sesión O estamos en la página principal después del login
                if (isPostLogin || pathname === '/home' || pathname === '/' || pathname === '/menu') {
                    // Forzar menú oculto
                    sidebar.classList.add('hidden');
                    content.classList.add('full-width');
                    localStorage.setItem('sidebarHidden', 'true');
                    updateToggleVisibility(true);
                    
                    // Limpiar bandera de post-login
                    sessionStorage.removeItem('isPostLogin');
                } else {
                    // Para otras navegaciones, usar la preferencia guardada
                    const shouldHideSidebar = localStorage.getItem('sidebarHidden') === 'true';
                    
                    if (shouldHideSidebar) {
                        sidebar.classList.add('hidden');
                        content.classList.add('full-width');
                        updateToggleVisibility(true);
                    } else {
                        sidebar.classList.remove('hidden');
                        content.classList.remove('full-width');
                        updateToggleVisibility(false);
                    }
                }

                // Mostrar u ocultar el menú lateral (y guardar el estado)
                toggleBtn.addEventListener('click', function () {
                    sidebar.classList.add('hidden');
                    content.classList.add('full-width');
                    
                    // Guardar el estado actual
                    localStorage.setItem('sidebarHidden', 'true');
                    updateToggleVisibility(true);
                });
                
                // Botón flotante para mostrar el menú cuando está oculto
                floatingToggle.addEventListener('click', function() {
                    sidebar.classList.remove('hidden');
                    content.classList.remove('full-width');
                    
                    localStorage.setItem('sidebarHidden', 'false');
                    updateToggleVisibility(false);
                });
                
                // Botón móvil para mostrar el menú
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.remove('hidden');
                    content.classList.remove('full-width');
                    localStorage.setItem('sidebarHidden', 'false');
                    updateToggleVisibility(false);
                });

                // Ocultar el menú cuando se selecciona una opción en pantallas pequeñas
                links.forEach(link => {
                    link.addEventListener('click', function () {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.add('hidden');
                            content.classList.add('full-width');
                            localStorage.setItem('sidebarHidden', 'true');
                            updateToggleVisibility(true);
                        }
                    });
                });

                // Ajustes especiales para móviles
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('hidden');
                    content.classList.add('full-width');
                    localStorage.setItem('sidebarHidden', 'true');
                    updateToggleVisibility(true);
                }
                
                // Marcar el enlace activo según la URL actual
                if (typeof $ !== 'undefined') {
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
                        
                        if (typeof Swal !== 'undefined') {
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
                        } else {
                            if (confirm('¿Estás seguro que deseas cerrar tu sesión?')) {
                                localStorage.removeItem('sidebarHidden');
                                document.getElementById('logout-form').submit();
                            }
                        }
                    });
                }
            });
        </script>
    </body>
</html>