<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Combustible</title>
    <link rel="icon" href="{{ asset('img/icono.PNG') }}" type="image/PNG">
    
    <!-- Otros estilos y scripts que ya tenías en el head. -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   <!-- Fuente Poppins para el texto general. -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
     <!-- Fuente Cinzel con pesos 400 y 700 para títulos y subtítulos. -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome versión 6 para íconos adicionales. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <!-- Bootstrap 5.2, está repetido, por compatibilidad. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Título principal */
        .title-panel {
           font-family: 'Cinzel', serif; /* Fuente utilizada para el título. */
        font-size: 26px; /* Tamaño de fuente del título. */
        font-weight: 700; /* Grosor de la fuente. */
        color: #000; /* Color del texto. */
        text-align: center; /* Centra el texto. */
        text-transform: uppercase; /* Convierte el texto a mayúsculas. */
        letter-spacing: 1.5px; /* Espaciado entre letras. */
        margin-bottom: 30px; /* Margen inferior. */
        padding: 10px 20px; /* Espaciado interno. */
        border-radius: 12px; /* Bordes redondeados. */
        background: rgba(255, 255, 255, 0.57); /* Fondo blanco semitransparente. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra. */
        }

        /* Icono de usuario más pequeño y sin fondo. */
        .input-icon i {
        font-size: 18px; /* Tamaño del icono. */
        color: #333; /* Color del icono. */
        background: none; /* Sin fondo. */
        }

        /* Imagen de fondo */
        body {
        font-family: 'Poppins', sans-serif; /* Fuente utilizada para el cuerpo. */
        background: url("{{ asset('img/fondo_inicio.jpg') }}") no-repeat center center fixed; /* Imagen de fondo. */
        background-size: cover; /* Cubre todo el fondo. */
        height: 100vh; /* Altura completa de la ventana. */
        display: flex; /* Flexbox para centrar contenido. */
        flex-direction: column; /* Dirección de los elementos en columna. */
        align-items: center; /* Centra horizontalmente. */
        justify-content: center; /* Centra verticalmente. */
        }

        /* Título principal */
        .title-panel {
        font-family: 'Cinzel', serif; /* Fuente utilizada para el título. */
        font-size: 30px; /* Tamaño de fuente del título. */
        font-weight: 700; /* Grosor de la fuente. */
        color: #000; /* Color del texto. */
        text-align: center; /* Centra el texto. */
        text-transform: uppercase; /* Convierte el texto a mayúsculas. */
        letter-spacing: 1.5px; /* Espaciado entre letras. */
        margin-bottom: 30px; /* Margen inferior. */
        padding: 10px 20px; /* Espaciado interno. */
        border-radius: 12px; /* Bordes redondeados. */
        background: rgba(255, 255, 255, 0.57); /* Fondo blanco semitransparente. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08); /* Sombra. */
        }

        /* Contenedor del login */
        .login-container {
        width: 100%; /* Ancho completo. */
        max-width: 400px; /* Ancho máximo. */
        background: rgba(255, 255, 255, 0.95); /* Fondo blanco semitransparente. */
        padding: 30px; /* Espaciado interno. */
        border-radius: 15px; /* Bordes redondeados. */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); /* Sombra. */
        }

        /* Imagen dentro del login */
        .login-container img {
        width: 80px; /* Ancho de la imagen. */
        display: block; /* Muestra como bloque. */
        margin: 0 auto 15px; /* Centra la imagen y margen inferior. */
        }
        
        /* Header del formulario */
        .login-header {
        background-color: rgb(226, 228, 230); /* Color de fondo del encabezado. */
        border-radius: 8px; /* Bordes redondeados. */
        margin-bottom: 20px; /* Margen inferior. */
        padding: 15px; /* Espaciado interno. */
        text-align: center; /* Centra el texto. */
        }
         /* Estilo para el título h3 */
        h3 {
        color: #344767; /* Color del texto. */
        font-weight: 600; /* Grosor de la fuente. */
        margin-bottom: 0; /* Sin margen inferior. */
        }
        
        /* Campos del formulario */
        .form-label {
        color: #334155; /* Color del texto de la etiqueta. */
        font-weight: 600; /* Grosor de la fuente. */
        }
          /* Estilo para los campos de formulario. */
        .form-control {
        border: 1px solid #e2e8f0; /* Borde del campo. */
        border-radius: 8px; /* Bordes redondeados. */
        padding: 0.75rem 1rem; /* Espaciado interno. */
        font-size: 0.9rem; /* Tamaño de fuente. */
        transition: all 0.3s ease; /* Transición suave. */
        }
         /* Estilo cuando el campo está enfocado. */
        .form-control:focus {
        border-color: #3b82f6; /* Color del borde al enfocar. */
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25); /* Sombra al enfocar. */
        }
        
        /* Botón de inicio de sesión. */
        .btn-primary {
        background-color: #0ea5e9; /* Color de fondo. */
        border-color: #0ea5e9; /* Color del borde. */
        color: white; /* Color del texto. */
        font-weight: 600; /* Grosor de la fuente. */
        transition: all 0.3s ease; /* Transición suave. */
        padding: 0.75rem 1rem; /* Espaciado interno. */
        font-size: 0.9rem; /* Tamaño de fuente. */
        border-radius: 8px; /* Bordes redondeados. */
        margin-top: 10px; /* Margen superior. */
        }
        /* Efecto hover en el botón principal. */
        .btn-primary:hover {
        background-color: #0284c7; /* Color de fondo al pasar el mouse. */
        border-color: #0284c7; /* Color del borde al pasar el mouse. */
        box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3); /* Sombra al pasar el mouse. */
        transform: translateY(-2px); /* Eleva el botón al pasar el mouse. */
        }

        /* Botón secundario. */
        .btn-secondary {
        background-color: #64748b; /* Color de fondo. */
        border-color: #64748b; /* Color del borde. */
        color: white; /* Color del texto. */
        font-weight: 600; /* Grosor de la fuente. */
        transition: all 0.3s ease; /* Transición suave. */
        padding: 0.75rem 1rem; /* Espaciado interno. */
        font-size: 0.9rem; /* Tamaño de fuente. */
        border-radius: 8px; /* Bordes redondeados. */
        margin-top: 10px; /* Margen superior. */
        }
        /* Efecto hover en el botón secundario. */
        .btn-secondary:hover {
        background-color: #475569; /* Color de fondo al pasar el mouse. */
        border-color: #475569; /* Color del borde al pasar el mouse. */
        box-shadow: 0 4px 10px rgba(100, 116, 139, 0.3); /* Sombra al pasar el mouse. */
        transform: translateY(-2px); /* Eleva el botón al pasar el mouse. */
        }
        
        /* Alertas. */
        .alert {
        border-radius: 8px; /* Bordes redondeados. */
        margin-bottom: 20px; /* Margen inferior. */
        }
        /* Estilos para alertas de éxito. */
        .alert-success {
        background-color: #dcfce7; /* Color de fondo para éxito. */
        border-color: #86efac; /* Color del borde para éxito. */
        color: #166534; /* Color del texto para éxito. */
        }
         /* Estilos para alertas de error. */
        .alert-danger {
        background-color: #fee2e2; /* Color de fondo para error. */
        border-color: #fca5a5; /* Color del borde para error. */
        color: #991b1b; /* Color del texto para error. */
        }
          /* Contenedor para la información de la empresa. */
        .company-branding {
        display: flex; /* Flexbox para alinear elementos. */
        flex-direction: column; /* Dirección de los elementos en columna. */
        align-items: center; /* Centra horizontalmente. */
        text-align: center; /* Centra el texto. */
        margin-bottom: 25px; /* Margen inferior. */
        }
        /* Ícono grande para la marca. */
        .brand-icon {
        font-size: 42px; /* Tamaño del ícono de la marca. */
        color: #0ea5e9; /* Color del ícono. */
        margin-bottom: 15px; /* Margen inferior. */
        }
         /* Contenedor del título de la empresa. */
        .company-title {
            width: 100%;
        }
         /* Título principal de la empresa. */
        .main-title {
        font-size: 24px; /* Tamaño de fuente del título principal. */
        font-weight: 700; /* Grosor de la fuente. */
        color: #344767; /* Color del texto. */
        margin-bottom: 8px; /* Margen inferior. */
        }
         /* Nombre de la empresa. */
        .company-name {
        font-size: 18px; /* Tamaño de fuente del nombre de la empresa. */
        font-weight: 600; /* Grosor de la fuente. */
        color: #475569; /* Color del texto. */
        margin-bottom: 6px; /* Margen inferior. */
        }
         /* Grupo o filial de la empresa. */
        .company-group {
        font-size: 16px; /* Tamaño de fuente del grupo de la empresa. */
        font-weight: 500; /* Grosor de la fuente. */
        color: #64748b; /* Color del texto. */
        margin: 0; /* Sin margen. */
        }

        /* Mejora en la apariencia del contenedor de login. */
        .login-container {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); /* Sombra. */
        border-radius: 16px; /* Bordes redondeados. */
        padding: 30px; /* Espaciado interno. */
        max-width: 400px; /* Ancho máximo. */
        background-color: white; /* Color de fondo. */
        }

        .login-header {
        margin-bottom: 25px; /* Margen inferior. */
        }

        /* Asegurar que los inputs tengan bordes redondeados consistentes. */
        .input-with-icon {
        border-radius: 8px !important; /* Bordes redondeados. */
        padding-left: 35px; /* Espaciado interno a la izquierda. */
        }

       .input-group {
        position: relative; /* Posicionamiento relativo para el ícono. */
    }

    /* Ícono dentro del input posicionado a la izquierda. */
    .input-icon {
        position: absolute; /* Posicionamiento absoluto. */
        left: 10px; /* Posición a la izquierda. */
        top: 50%; /* Centra verticalmente. */
        transform: translateY(-50%); /* Ajusta la posición vertical. */
        z-index: 10; /* Asegura que el ícono esté por encima. */
        color: #64748b; /* Color del ícono. */
    }


        /* Estilos para el icono de toggle de contraseña. */
        .toggle-password {
        position: absolute; /* Posicionamiento absoluto. */
        right: 10px; /* Posición a la derecha .*/
        top: 50%; /* Centra verticalmente. */
        transform: translateY(-50%); /* Ajusta la posición vertical. */
        z-index: 10; /* Asegura que el ícono esté por encima. */
        cursor: pointer; /* Cambia el cursor al pasar sobre el ícono .*/
        color: #64748b; /* Color del ícono. */
    }

    .input-group, .input-group-text {
        border-radius: 8px; /* Bordes redondeados. */
        border: none; /* Sin borde. */
        background: transparent; /* Fondo transparente. */
    }

        .input-group .form-control {
        width: 100%; /* Ancho completo. */
        border-radius: 8px !important; /* Bordes redondeados. */
    }
    
    /* Asegurarse que el campo password no tenga el ícono predeterminado del navegador. */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none; /* Oculta el ícono de revelado y borrado. */
    }
    </style>
    </head>
    <body>
        <!-- Contenedor del Login. -->
        <div class="login-container">
            <div class="login-header">
                <!-- Logo y título mejorado. -->
                <div class="company-branding">
                    <i class="fas fa-gas-pump brand-icon"></i> <!-- Ícono bomba de gasolina. -->
                    <div class="company-title">
                        <h2 class="main-title">Gestión de Combustible</h2> <!-- Título principal. -->
                        <h3 class="company-name">Clasificadora y Exportadora de Tabaco S.A</h3> <!-- Nombre empresa. -->
                        <h4 class="company-group">Grupo Plasencia</h4>
                    </div>
                </div>
            </div>
            <!-- Mensaje de éxito después de una acción (como registro). -->
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif
               <!-- Mostrar errores de validación del formulario. -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
             <!-- Formulario de login que envía datos al route 'login'. -->
            <form method="POST" action="{{ route('login') }}">
                @csrf <!-- Token para seguridad CSRF. -->
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
                            <i id="togglePasswordIcon" class="fas fa-eye"></i> <!-- Ícono para mostrar/ocultar contraseña. -->
                        </span>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button> <!-- Botón de envío. -->
            </form>
        </div>
        <script>
            // Este script debe ejecutarse después de un inicio de sesión exitoso.
            sessionStorage.setItem('isPostLogin', 'true');
            
            function togglePassword() {
                const passwordInput = document.getElementById("password");
                const toggleIcon = document.getElementById("togglePasswordIcon");

                if (passwordInput.type === "password") {
                    passwordInput.type = "text"; // Mostrar texto.
                    toggleIcon.classList.remove("fa-eye");
                    toggleIcon.classList.add("fa-eye-slash");
                } else {
                    passwordInput.type = "password"; // Ocultar texto.
                    toggleIcon.classList.remove("fa-eye-slash");
                    toggleIcon.classList.add("fa-eye");
                }
            }
        </script>
    </body>
</html>