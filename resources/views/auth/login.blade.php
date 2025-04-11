<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestión de Combustible</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&display=swap" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
        
        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
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
        
        .btn-primary:hover {
            background-color: #0284c7;
            border-color: #0284c7;
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
            transform: translateY(-2px);
        }
        
        /* Alertas */
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: #dcfce7;
            border-color: #86efac;
            color: #166534;
        }
        
        .alert-danger {
            background-color: #fee2e2;
            border-color: #fca5a5;
            color: #991b1b;
        }
        
        /* Campos de entrada con iconos */
        .input-group {
            position: relative;
            margin-bottom: 1rem;
        }
        
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            z-index: 10;
        }
        
        .input-with-icon {
            padding-left: 40px;
        }

        .company-branding {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 25px;
        }

        .brand-icon {
            font-size: 42px;
            color: #0ea5e9;
            margin-bottom: 15px;
        }

        .company-title {
            width: 100%;
        }

        .main-title {
            font-size: 24px;
            font-weight: 700;
            color: #344767;
            margin-bottom: 8px;
        }

        .company-name {
            font-size: 18px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
        }

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
    </style>
</head>
<body>
    <!-- Contenedor del Login -->
    <div class="login-container">
        <div class="login-header">
            <!-- Logo y título mejorado -->
            <div class="company-branding">
                <i class="fas fa-gas-pump brand-icon"></i>
                <div class="company-title">
                    <h2 class="main-title">Gestión de Combustible</h2>
                    <h3 class="company-name">Clasificadora y Exportadora de Tabaco S.A</h3>
                    <h4 class="company-group">Grupo Plasencia</h4>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

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
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
        </form>
    </div>

    <script>
        // Este script debe ejecutarse después de un inicio de sesión exitoso
        sessionStorage.setItem('isPostLogin', 'true');
    </script>
</body>


</html>