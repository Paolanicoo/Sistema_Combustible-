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
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <!-- Fuente Poppins para el texto general -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <!-- Fuente Cinzel con pesos 400 y 700 para títulos y subtítulos -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome versión 6 para íconos adicionales -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <!-- Bootstrap 5.2, está repetido, por compatibilidad -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Título principal */
        .title-panel {
            font-family: 'Cinzel', serif;
            font-size: 26px; /* Menor que el tamaño del título de inicio de sesión */
            font-weight: 700;
            color: #000;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 30px;
            padding: 10px 20px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.57); /* Fondo blanco semitransparente */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        }

        /* Icono de usuario más pequeño y sin fondo */
        .input-icon i {
            font-size: 18px;
            color: #333;
            background: none; /* Sin fondo */
        }

        /* Imagen de fondo */
        body {
            font-family: 'Poppins', sans-serif;
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
            font-family: 'Cinzel', serif;
            font-size: 30px;
            font-weight: 700;
            color: #000;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 30px;
            padding: 10px 20px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.57); /* Fondo blanco semitransparente */
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        }

        /* Contenedor del login */
        .login-container {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        /* Imagen dentro del login */
        .login-container img {
            width: 80px;
            display: block;
            margin: 0 auto 15px;
        }
        
        /* Header del formulario */
        .login-header {
            background-color: rgb(226, 228, 230);
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
            text-align: center;
        }
         /* Estilo para el título h3 */
        h3 {
            color: #344767;
            font-weight: 600;
            margin-bottom: 0;
        }
        
        /* Campos del formulario */
        .form-label {
            color: #334155;
            font-weight: 600;
        }
          /* Estilo para los campos de formulario */
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
         /* Estilo cuando el campo está enfocado */
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }
        
        /* Botón de inicio de sesión */
        .btn-primary {
            background-color: #0ea5e9;
            border-color: #0ea5e9;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            border-radius: 8px;
            margin-top: 10px;
        }
        /* Efecto hover en el botón principal */
        .btn-primary:hover {
            background-color: #0284c7;
            border-color: #0284c7;
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
            transform: translateY(-2px);
        }

        /* Botón secundario */
        .btn-secondary {
            background-color: #64748b;
            border-color: #64748b;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            border-radius: 8px;
            margin-top: 10px;
        }
        /* Efecto hover en el botón secundario */
        .btn-secondary:hover {
            background-color: #475569;
            border-color: #475569;
            box-shadow: 0 4px 10px rgba(100, 116, 139, 0.3);
            transform: translateY(-2px);
        }
        
        /* Alertas */
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
        /* Estilos para alertas de éxito */
        .alert-success {
            background-color: #dcfce7;
            border-color: #86efac;
            color: #166534;
        }
         /* Estilos para alertas de error */
        .alert-danger {
            background-color: #fee2e2;
            border-color: #fca5a5;
            color: #991b1b;
        }
          /* Contenedor para la información de la empresa */
        .company-branding {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 25px;
        }
        /* Ícono grande para la marca */
        .brand-icon {
            font-size: 42px;
            color: #0ea5e9;
            margin-bottom: 15px;
        }
         /* Contenedor del título de la empresa */
        .company-title {
            width: 100%;
        }
         /* Título principal de la empresa */
        .main-title {
            font-size: 24px;
            font-weight: 700;
            color: #344767;
            margin-bottom: 8px;
        }
         /* Nombre de la empresa */
        .company-name {
            font-size: 18px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }
         /* Grupo o filial de la empresa */
        .company-group {
            font-size: 16px;
            font-weight: 500;
            color: #64748b;
            margin: 0;
        }

        /* Mejora en la apariencia del contenedor de login */
        .login-container {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            padding: 30px;
            max-width: 400px;
            background-color: white;
        }

        .login-header {
            margin-bottom: 25px;
        }

        /* Asegurar que los inputs tengan bordes redondeados consistentes */
        .input-with-icon {
            border-radius: 8px !important;
            padding-left: 35px;
        }

        .input-group {
            position: relative;
        }
        /* Ícono dentro del input posicionado a la izquierda */
        .input-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            color: #64748b;
        }

        /* Estilos para el icono de toggle de contraseña */
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            cursor: pointer;
            color: #64748b;
        }

        .input-group, .input-group-text {
            border-radius: 8px;
            border: none;
            background: transparent;
        }

        .input-group .form-control {
            width: 100%;
            border-radius: 8px !important;
        }
        
        /* Asegurarse que el campo password no tenga el ícono predeterminado del navegador */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>
    </head>
    <body>
        <!-- Contenedor del Login -->
        <div class="login-container">
            <div class="login-header">
                <!-- Logo y título mejorado -->
                <div class="company-branding">
                    <i class="fas fa-gas-pump brand-icon"></i> <!-- Ícono bomba de gasolina -->
                    <div class="company-title">
                        <h2 class="main-title">Gestión de Combustible</h2> <!-- Título principal -->
                        <h3 class="company-name">Clasificadora y Exportadora de Tabaco S.A</h3> <!-- Nombre empresa -->
                        <h4 class="company-group">Grupo Plasencia</h4>
                    </div>
                </div>
            </div>
            <!-- Mensaje de éxito después de una acción (como registro) -->
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif
               <!-- Mostrar errores de validación del formulario -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
             <!-- Formulario de login que envía datos al route 'login' -->
            <form method="POST" action="{{ route('login') }}">
                @csrf <!-- Token para seguridad CSRF -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de usuario</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-user-circle" style="font-size: 18px; color: #333;"></i>
                        </span>
                        <input type="text" id="nombre" name="nombre" class="form-control input-with-icon" required placeholder="Ingrese su nombre de usuario">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" id="password" name="password" class="form-control input-with-icon" required placeholder="Ingrese su contraseña">
                        <span class="toggle-password" onclick="togglePassword()">
                            <i id="togglePasswordIcon" class="fas fa-eye"></i> <!-- Ícono para mostrar/ocultar contraseña -->
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button> <!-- Botón de envío -->
            </form>
        </div>
        <script>
            // Este script debe ejecutarse después de un inicio de sesión exitoso
            sessionStorage.setItem('isPostLogin', 'true');
            
            function togglePassword() {
                const passwordInput = document.getElementById("password");
                const toggleIcon = document.getElementById("togglePasswordIcon");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text"; // Mostrar texto
                    toggleIcon.classList.remove("fa-eye");
                    toggleIcon.classList.add("fa-eye-slash");
                } else {
                    passwordInput.type = "password"; // Ocultar texto
                    toggleIcon.classList.remove("fa-eye-slash");
                    toggleIcon.classList.add("fa-eye");
                }
            }
        </script>
    </body>
</html>