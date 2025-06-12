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
            font-family: 'Poppins', sans-serif; /* Fuente utilizada para el cuerpo. */
            background-color: #f8f9fa; /* Color de fondo. */
        }

        /* Estilo del sidebar */
        .sidebar {
            width: 280px; /* Ancho del sidebar. */
            height: 100vh; /* Altura completa de la ventana. */
            position: fixed; /* Posición fija .*/
            left: 0; /* Alineado a la izquierda. */
            top: 0; /* Alineado a la parte superior. */
            background: white; /* Color de fondo. */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra. */
            padding: 0 0 20px 0;/* Espaciado interno. */
            color: #344767; /* Color del texto. */
            transition: all 0.3s; /* Transición suave. */
            z-index: 1000; /* Asegura que el sidebar esté por encima de otros elementos. */
        }

        .sidebar .brand-container {
            padding: 15px; /* Espaciado interno. */
            margin-bottom: 20px; /* Margen inferior. */
            background-color: transparent; /* Fondo transparente. */
            border-bottom: 1px solid rgba(0, 0, 0, 0.05); /* Borde inferior. */
            justify-content: center; /* Centra el contenido. */
            align-items: center; /* Centra verticalmente. */
            transition: all 0.3s ease; /* Transición suave. */
        }

        .sidebar .brand {
            color: #344767; /* Color del texto de la marca. */
            font-weight: 900; /* Grosor de la fuente. */
            font-size: 1.4rem; /* Tamaño de fuente. */
            text-align: center; /* Centra el texto. */
            display: block; /* Muestra como bloque. */
            width: 100%; /* Ancho completo. */
            transition: all 0.3s ease; /* Transición suave. */
            padding: 10px; /* Espaciado interno. */
            border-radius: 8px; /* Bordes redondeados. */
            margin: 0 15px; /* Margen lateral. */
            margin-left: -1px; /* Igual que el activo */
            text-decoration: none; /* Sin subrayado. */
        }

        .sidebar .brand.active {
            background: #0ea5e9; /* Color de fondo cuando está activo. */
            color: white; /* Color del texto cuando está activo. */
            font-weight: 900; /* Grosor de la fuente cuando está activo. */
            margin-left: -1px; /* Igual que el activo. */
        }

        /* Estilos generales para todos los enlaces del menú (como estaban antes) */
        .sidebar .nav-link {
            color: #333; /* Color del texto del enlace. */
            background: transparent; /* Fondo transparente. */
            font-weight: 600; /* Grosor de la fuente. */
            border-radius: 5px; /* Bordes redondeados. */
            margin-bottom: 5px; /* Margen inferior. */
            padding: 10px 15px; /* Espaciado interno. */
            display: block; /* Muestra como bloque. */
            transition: all 0.3s ease; /* Transición suave. */
        }

        /* Solo para el enlace del menú principal */
        .sidebar .nav-link.menu-principal {
            background: #0ea5e9; /* Color de fondo del menú principal. */
            color: white; /* Color del texto del menú principal. */
        }

        /* Movimiento al pasar el mouse solo en el enlace del menú principal */
        .sidebar .nav-link.menu-principal:hover {
            transform: translateX(5px); /* Desplaza el enlace hacia la derecha al pasar el mouse. */
        }

        .sidebar .user-info {
            padding: 15px; /* Espaciado interno. */
            background-color: #f8f9fa;/* Color de fondo. */
            margin: 0 15px 20px 15px; /* Margen. */
            border-radius: 10px; /* Bordes redondeados. */
            display: flex; /* Flexbox para alinear elementos. */
            align-items: center; /* Centra verticalmente. */
            gap: 10px; /* Espacio entre elementos. */
            cursor: pointer; /* Cambia el cursor al pasar sobre el elemento. */
            transition: all 0.3s ease; /* Transición suave. */
        }

        .sidebar .user-info:hover {
            background-color: #e2e8f0; /* Color de fondo al pasar el mouse. */
        }

        .sidebar .user-info i.user-icon {
            background-color: #0ea5e9; /* Color de fondo del ícono de usuario. */
            color: white; /* Color del ícono de usuario. */
            padding: 10px;  /* Espaciado interno. */
            border-radius: 8px; /* Bordes redondeados. */
        }

        .sidebar .user-info .user-details {
            flex: 1; /* Permite que el contenedor ocupe el espacio restante. */
        }

        .sidebar .user-info h5 {
            margin: 0; /* Sin margen. */
            font-size: 0.95rem; /* Tamaño de fuente. */
            font-weight: 600; /* Grosor de la fuente. */
        }

        .sidebar .user-info .logout-icon {
            color: #ef4444; /* Color del ícono de logout .*/
            margin-left: auto; /* Alinea a la derecha. */
        }

        .sidebar .nav-link {
            color: #64748b; /* Color del texto de los enlaces. */
            font-weight: 500; /* Grosor de la fuente. */
            padding: 12px 15px; /* Espaciado interno. */
            margin: 0 15px 5px 15px; /* Margen. */
            display: flex; /* Flexbox para alinear elementos. */
            align-items: center; /* Centra verticalmente. */
            border-radius: 8px; /* Bordes redondeados. */
            transition: all 0.3s ease; /* Transición suave. */
            font-size: 0.9rem; /* Tamaño de fuente. */
        }

        .sidebar .nav-link i {
            margin-right: 12px; /* Margen a la derecha del ícono. */
            width: 20px; /* Ancho del ícono. */
            text-align: center; /* Centra el ícono. */
        }

        .sidebar .nav-link:hover {
            background: #f1f5f9; /* Color de fondo al pasar el mouse. */
            color: #0ea5e9; /* Color del texto al pasar el mouse. */
            transform: translateX(5px); /* Desplaza el enlace hacia la derecha al pasar el mouse. */
        }

        .sidebar .nav-link.active {
            background: #0ea5e9; /* Color de fondo cuando está activo. */
            color: white; /* Color del texto cuando está activo. */
            font-weight: 600; /* Grosor de la fuente cuando está activo. */
        }

        /* Contenido principal */
        .content {
            margin-left: 280px; /* Margen izquierdo para el contenido principal. */
            padding: 30px; /* Espaciado interno */
            transition: margin-left 0.3s; /* Transición suave para el margen. */
        }

        /* Botón para toggle del sidebar */
        #toggleSidebar {
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón. */
            font-size: 2.2rem; /* Tamaño de fuente del botón. */
            color: #0ea5e9; /* Color del texto del botón. */
            font-weight: 700; /* Grosor de la fuente. */
            background-color: #f8fafc; /* Color de fondo del botón. */
            width: 50px; /* Ancho del botón. */
            height: 50px; /* Altura del botón. */
            border-radius: 50%; /* Bordes redondeados. */
            display: flex; /* Flexbox para centrar contenido. */
            justify-content: center; /* Centra horizontalmente. */
            align-items: center; /* Centra verticalmente. */
            position: absolute; /* Posicionamiento absoluto. */
            top: 30px; /* Posición desde la parte superior. */
            right: -24px; /* Posición desde la derecha. */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra. */
            transition: all 0.3s ease; /* Transición suave. */
            z-index: 1001; /* Asegura que el botón esté por encima de otros elementos. */
        }

        #toggleSidebar:hover {
            transform: scale(1.1); /* Aumenta el tamaño al pasar el mouse. */
            background-color: #e2e8f0;/* Color de fondo al pasar el mouse. */
        }

        /* Estilos para el botón cuando el sidebar está oculto */
        #toggleSidebar.hidden {
            right: auto;/* Cambia la posición a automática. */
            left: 20px;  /* Posición desde la izquierda. */
            background-color: #0ea5e9; /* Color de fondo cuando está oculto. */
            color: white;/* Color del texto cuando está oculto. */
        }

        /* Estilos cuando el menú está oculto */
        .sidebar.hidden {
            left: -380px; 
        }

        .content.full-width {
            margin-left: 0; /* Elimina el margen izquierdo cuando el contenido es de ancho completo. */
        }

        /* Ajuste para móviles */
        @media (max-width: 768px) {
            .sidebar {
                left: -280px; /* Desplaza el sidebar fuera de la vista en móviles. */
            }

            .content {
                margin-left: 0; /* Elimina el margen izquierdo en móviles .*/
            }

            #toggleSidebar.hidden {
                left: 10px; /* Posición desde la izquierda cuando está oculto en móviles. */
            }
        }

        /* Divider */
        .sidebar-divider {
            border-top: 1px solid #e2e8f0; /* Borde superior. */
            margin: 15px;/* Margen */
        }

        /* Estilos para secciones */
        .sidebar-section-title {
            font-size: 0.75rem; /* Tamaño de fuente del título de sección. */
            text-transform: uppercase; /* Convierte el texto a mayúsculas. */
            letter-spacing: 0.5px; /* Espaciado entre letras. */
            color: #94a3b8; /* Color del texto. */
            font-weight: 600; /* Grosor de la fuente. */
            padding: 0 15px; /* Espaciado interno. */
            margin-top: 15px; /* Margen superior. */
            margin-bottom: 10px; /* Margen inferior. */
        }

        /* Botón flotante para mostrar menú en móviles */
        .mobile-toggle {
            display: none; /* Oculto por defecto. */
            position: fixed; /* Posicionamiento fijo. */
            bottom: 20px; /* Posición desde la parte inferior. */
            right: 20px; /* Posición desde la derecha. */
            z-index: 1002; /* Asegura que el botón esté por encima de otros elementos. */
            background: #0ea5e9; /* Color de fondo. */
            color: white; /* Color del texto. */
            width: 50px; /* Ancho del botón. */
            height: 50px; /* Altura del botón. */
            border-radius: 50%; /* Bordes redondeados. */
            justify-content: center; /* Centra horizontalmente. */
            align-items: center;/* Centra verticalmente. */
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra */
            border: none;/* Sin borde. */
        }

        @media (max-width: 768px) {
            .mobile-toggle {
                display: flex; /* Muestra el botón en móviles. */
            }
        }

        /* Estilos adicionales para el botón flotante */
        .floating-toggle {
            display: none; /* Oculto por defecto. */
            position: fixed; /* Posicionamiento fijo. */
            top: 20px;  /* Posición desde la parte superior. */
            left: 20px; /* Posición desde la izquierda. */
            background-color: #0ea5e9; /* Color de fondo .*/
            color: white; /* Color del texto. */
            width: 50px; /* Ancho del botón. */
            height: 50px; /* Altura del botón. */
            border-radius: 50%; /* Bordes redondeados. */
            justify-content: center; /* Centra horizontalmente. */
            align-items: center; /* Centra verticalmente. */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sombra. */
            cursor: pointer; /* Cambia el cursor al pasar sobre el botón. */
            z-index: 1100; /* Asegura que el botón esté por encima de otros elementos. */
            font-weight: 700; /* Grosor de la fuente. */
            font-size: 2.2rem; /* Tamaño de fuente. */
            transition: transform 0.3s ease; /* Transición suave. */
        }
        
        .floating-toggle:hover {
            transform: scale(1.1); /* Aumenta el tamaño al pasar el mouse .*/
        }

        /* Sticky footer que permanece abajo aunque no haya contenido suficiente */
        html {
            height: 100%;
        }

        body {
            min-height: 100%; /* Altura mínima del cuerpo. */
            display: flex; /* Flexbox para organizar el contenido. */
            flex-direction: column; /* Dirección de los elementos en columna. */
        }

        .content-wrapper {
            flex: 1 0 auto; /* Permite que el contenedor crezca. */
        }

        .footer {
            flex-shrink: 0; /* No permite que el pie de página se reduzca. */
            background-color: #f8f9fa; /* Color de fondo del pie de página. */
            text-align: center; /* Centra el texto. */
            padding: 0.10rem 0; /* Espaciado interno. */
            border-top: 1px solid #e2e8f0; /* Borde superior. */
            width: 100%; /* Ancho completo. */
        }

        .footer-content {
            font-family: 'Poppins', sans-serif; /* Fuente utilizada para el cuerpo. */
            font-size: 0.8rem; /* Tamaño de la fuente. */
            color: #718096; /* Color. */
        }
    </style>

    @yield('styles')
    </head>
    <body>
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Botón para mostrar/ocultar el menú. -->
            <div id="toggleSidebar">≡</div>

            <div class="brand-container">
                <!-- Enlace a la página principal con clase activa si está en la ruta correspondiente. -->
                <a href="{{ route('menu') }}" class="brand {{ (request()->is('menu') || request()->is('/') || request()->is('home')) ? 'active' : '' }}" id="brandLink">
                    Gestión de Combustible <!-- Título -->
                </a>
            </div>

            <!-- Usuario con función de logout. -->
            @if(Auth::check())
            <div class="user-info" id="user-profile">
                <i class="fas fa-user user-icon"></i> <!-- Icono de usuario. -->
                <div class="user-details">
                    <h5>{{ Auth::user()->name }}</h5> <!-- Nombre del usuario autenticado. -->
                    <small>{{ Auth::user()->role }}</small> <!-- Rol del usuario. -->
                </div>
                <i class="fas fa-sign-out-alt logout-icon"></i> <!-- Icono de logout. -->
            </div>

            <div class="sidebar-section-title">ADMINISTRACIÓN DE REGISTROS</div> <!-- Título de sección en el sidebar. -->
            <!-- Enlaces de navegación para diferentes secciones. -->
            <a href="{{ route('registrovehicular.index') }}" class="nav-link {{ request()->routeIs('registrovehicular.*') ? 'active' : '' }}">
                <i class="fas fa-car"></i> Registro vehicular <!-- Enlace a registro vehicular. -->
            </a>
            <a href="{{ route('registrocombustible.index') }}" class="nav-link {{ request()->routeIs('registrocombustible.*') ? 'active' : '' }}">
                <i class="fa fa-id-card"></i> Registro combustible <!-- Enlace a registro de combustible. -->
            </a>
            @if(Auth::user()->role === 'Administrador') <!-- Solo muestra este enlace si el usuario es administrador. -->
            <a href="{{ route('combus.index') }}" class="nav-link {{ request()->routeIs('combus.*') ? 'active' : '' }}">
                <i class="fas fa-gas-pump"></i> Inventario combustible <!-- Enlace a inventario de combustible. -->
            </a>
            @endif
            <a href="{{ route('registroimporte.index') }}" class="nav-link {{ request()->routeIs('registroimporte.*') ? 'active' : '' }}">
                <i class="fas fa-dollar-sign"></i> Importe <!-- Enlace a registro de importes. -->
            </a>
            <a href="{{ route('RIndex') }}" class="nav-link {{ request()->routeIs('RIndex') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Reportes <!-- Enlace a reportes. -->
            </a>

            @if(Auth::user()->role === 'Administrador') <!-- Solo muestra esta sección si el usuario es administrador. -->
            <div class="sidebar-section-title">ADMINISTRACIÓN DE USUARIO</div>
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Registro de usuario <!-- Enlace a registro de usuario. -->
            </a>
            <a href="{{ route('registrorol.table') }}" class="nav-link {{ request()->routeIs('registrorol.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Gestor de roles <!-- Enlace a gestor de roles. -->
            </a>
            @endif
            
            <!-- Formulario oculto para logout -->
            <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                @csrf
            </form>
            @else
            <!-- Mostrar opción de login para usuarios no autenticados. -->
            <div class="user-info" onclick="window.location.href='{{ route('login') }}'"> <!-- Redirige al login al hacer clic. -->
                <i class="fas fa-sign-in-alt user-icon"></i> <!-- Icono de inicio de sesión. -->
                <div class="user-details">
                    <h5>Iniciar sesión</h5> <!-- Texto de inicio de sesión. -->
                </div>
            </div>
            @endif
        </div>

        <!-- Botón P flotante cuando el sidebar está oculto. -->
        <div id="floatingToggle" class="floating-toggle">≡</div>

        <!-- Botón flotante para móviles. -->
        <button class="mobile-toggle" id="mobileToggle">
            <span>≡</span>
        </button>

        <!-- Contenido principal. -->
        <div class="content">
            <div class="container mt-4">
                @yield('contenido')
            </div>
        </div>

        <div class="content-wrapper">
            <!-- Todo el contenido de tus vistas irá aquí. -->
            @yield('content')
        </div>
        
        <footer class="footer"> <!-- Pie de página. -->
            <div class="container">
                <div class="footer-content">
                    © 2025 Todos los derechos reservados. Grupo Plasencia (Gestión Combustible) - Clasificadora y Exportadora de Tabaco S.A. 
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const sidebar = document.querySelector('.sidebar'); // Selecciona el sidebar.
                const toggleBtn = document.getElementById('toggleSidebar'); // Selecciona el botón de toggle
                const floatingToggle = document.getElementById('floatingToggle'); // Selecciona el botón flotante.
                const mobileToggle = document.getElementById('mobileToggle'); // Selecciona el botón móvil.
                const content = document.querySelector('.content'); // Selecciona el contenido principal.
                const links = document.querySelectorAll('.nav-link'); // Selecciona todos los enlaces de navegación.

                // Función para actualizar la visibilidad de los botones de toggle
                function updateToggleVisibility(isSidebarHidden) {
                    if (isSidebarHidden) {
                        toggleBtn.classList.add('hidden'); // Oculta el botón de toggle
                        floatingToggle.style.display = 'flex'; // Muestra el botón flotante.
                    } else {
                        toggleBtn.classList.remove('hidden'); // Muestra el botón de toggle.
                        floatingToggle.style.display = 'none'; // Oculta el botón flotante.
                    }
                }

                // FORZAR MENÚ OCULTO DESPUÉS DE INICIAR SESIÓN.
                // Verificar si venimos directamente del login.
                const isPostLogin = sessionStorage.getItem('isPostLogin') === 'true';
                const pathname = window.location.pathname;
                
                // Si acabamos de iniciar sesión O estamos en la página principal después del login.
                if (isPostLogin || pathname === '/home' || pathname === '/' || pathname === '/menu') {
                    // Forzar menú oculto
                    sidebar.classList.add('hidden');
                    content.classList.add('full-width');
                    localStorage.setItem('sidebarHidden', 'true');
                    updateToggleVisibility(true);
                    
                    // Limpiar bandera de post-login.
                    sessionStorage.removeItem('isPostLogin');
                } else {
                    // Para otras navegaciones, usar la preferencia guardada.
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

                // Mostrar u ocultar el menú lateral (y guardar el estado).
                toggleBtn.addEventListener('click', function () {
                    sidebar.classList.add('hidden');
                    content.classList.add('full-width');
                    
                    // Guardar el estado actual.
                    localStorage.setItem('sidebarHidden', 'true');
                    updateToggleVisibility(true);
                });
                
                // Botón flotante para mostrar el menú cuando está oculto.
                floatingToggle.addEventListener('click', function() {
                    sidebar.classList.remove('hidden');
                    content.classList.remove('full-width');
                    
                    localStorage.setItem('sidebarHidden', 'false');
                    updateToggleVisibility(false);
                });
                
                // Botón móvil para mostrar el menú.
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.remove('hidden');
                    content.classList.remove('full-width');
                    localStorage.setItem('sidebarHidden', 'false');
                    updateToggleVisibility(false);
                });

                // Ocultar el menú cuando se selecciona una opción en pantallas pequeñas.
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

                // Ajustes especiales para móviles.
                if (window.innerWidth <= 768) {
                    sidebar.classList.add('hidden');
                    content.classList.add('full-width');
                    localStorage.setItem('sidebarHidden', 'true');
                    updateToggleVisibility(true);
                }
                
                // Marcar el enlace activo según la URL actual.
                if (typeof $ !== 'undefined') {
                    const currentUrl = window.location.href;
                    $('.nav-link').each(function() {
                        const linkUrl = $(this).attr('href');
                        if (currentUrl.includes(linkUrl) && linkUrl !== '{{ route("menu") }}') {
                            $(this).addClass('active');
                        }
                    });
                    
                    // Cerrar sesión y resetear preferencias.
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
                                    // Establecer bandera para la próxima sesión.
                                    localStorage.removeItem('sidebarHidden');
                                    // Enviar formulario de logout.
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