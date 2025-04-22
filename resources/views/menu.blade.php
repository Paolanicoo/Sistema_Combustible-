@extends('layouts.app')

@section('titulo', 'Menú')

@section('contenido')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/icono.PNG') }}" type="image/PNG">

    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>

            body {
                background: url('img/4-4.jpg') no-repeat center center fixed;
                background-size: 1550px 780px; /* Ancho x Alto */
                transition: background 2s ease-in-out; /* Transición suave */
            }

            /* Pseudo-elemento para crear un efecto de degradado */
            body::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(rgba(43, 42, 42, 0.3), rgba(43, 42, 42, 0.7));
                z-index: -1;
            }



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
            background: #28a745;
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

        /* Estilos para el mensaje de bienvenida */
        .welcome-footer h1 {
            position: fixed;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            text-align: center;
            font-size: 40px;
            padding: 15px 0; /* Aumentar el espacio arriba y abajo */
            color: white;
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 2px; /* Espaciado entre letras */
            word-spacing: 5px; /* Espaciado entre palabras */
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

<!-- Mensaje de bienvenida en la parte inferior -->
<footer class="welcome-footer">
    <h1 class="text-center">Bienvenid@, {{ Auth::user()->name }}</h1>
</footer>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let images = [
            "img/1-1.jpg",
            "img/2-2.jpg",
            "img/3-3.jpg",
            "img/4-4.jpg",
            "img/5-5.jpg",
            "img/6-6.jpg",
        ];
        
        let index = 0;
        
        function changeBackground() {
            document.body.style.backgroundImage = `url('${images[index]}')`;
            index = (index + 1) % images.length; // Cicla las imágenes
        }

        setInterval(changeBackground, 5000); // Cambia cada 5 segundos
    });
</script>
</body>
</html>
