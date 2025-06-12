@extends('layouts.app')  <!-- Extiende la plantilla base 'app' para usar su estructura. -->

@section('titulo', 'Menú') <!-- Define el título de la página como 'Menú'. -->

@section('contenido') <!-- Inicia la sección de contenido que se insertará en la plantilla base. -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Configura la vista para dispositivos móviles. -->
    <link rel="icon" href="{{ asset('img/icono.PNG') }}" type="image/PNG"> <!-- Icono de la página. -->

    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>

            body { /* Estilos para el cuerpo de la página. */
            background: url('img/4-4.jpg') no-repeat center center fixed; /* Imagen de fondo centrada y fija. */
            background-size: 1550px 780px; /* Ancho x Alto de la imagen de fondo .*/
            transition: background 2s ease-in-out; /* Transición suave para el fondo. */
            }    

           body::before { /* Crea un efecto de degradado sobre el fondo. */
            content: ""; /* Contenido vacío para el pseudo-elemento. */
            position: fixed; /* Posición fija para cubrir toda la pantalla. */
            top: 0; /* Alinear al top. */
            left: 0; /* Alinear a la izquierda. */
            width: 100%; /* Ancho completo. */
            height: 100%; /* Alto completo. */
            background: linear-gradient(rgba(43, 42, 42, 0.3), rgba(43, 42, 42, 0.7)); /* Degradado de gris. */
            z-index: -1; /* Colocar detrás del contenido. */
        }



        /* Estilo del sidebar .*/
        .sidebar { /* Estilos para la barra lateral .*/
            width: 250px; /* Ancho de la barra lateral. */
            height: 100vh; /* Alto completo de la ventana. */
            position: fixed; /* Posición fija .*/
            left: 0; /* Alinear a la izquierda. */
            top: 0; /* Alinear al top .*/
            background: rgba(52, 58, 64, 0.9); /* Fondo gris oscuro con opacidad. */
            padding: 15px; /* Padding interno. */
            color: white; /* Color del texto. */
            transition: all 0.3s; /* Transición suave para cambios. */
        }

        .sidebar .nav-link { /* Estilos para los enlaces de navegación en la barra lateral .*/
            color: white; /* Color del texto .*/
            font-weight: bold; /* Negrita. */
            padding: 10px; /* Padding interno .*/
            display: block; /* Mostrar como bloque .*/
            border-radius: 5px; /* Bordes redondeados. */
        }

        .sidebar .nav-link:hover { /* Estilos al pasar el mouse sobre los enlaces. */
            background: #28a745; /* Fondo verde al pasar el mouse .*/
            color: white; /* Color del texto. */
        }

        .sidebar .nav-link.active { /* Estilos para el enlace activo .*/
            background: #1c7430; /* Fondo verde oscuro. */
            font-weight: 900; /* Negrita */
        }

        .content { /* Estilos para el contenido principal. */
            margin-left: 260px; /* Margen izquierdo para dejar espacio para la barra lateral. */
            padding: 20px; /* Padding interno .*/
            transition: margin-left 0.3s; /* Transición suave para el margen .*/
        }

        /* Navbar */
        .navbar {
            background: rgba(0, 0, 0, 0.7) !important;
        }

        .navbar .navbar-brand { /* Estilos para la marca de la barra de navegación. */
            color: white !important; /* Color del texto blanco. */
        }

        /* Botón de ocultar */
        #toggleSidebar { /* Estilos para el botón de ocultar la barra lateral. */
            position: fixed; /* Posición fija. */
            top: 15px; /* Alinear al top. */
            left: 260px; /* Alinear a la derecha de la barra lateral. */
            z-index: 1000; /* Z-index alto para superposición. */
            background: rgba(0, 0, 0, 0.8); /* Fondo negro con opacidad. */
            border: none; /* Sin borde. */
            padding: 10px 15px; /* Padding interno. */
            color: white; /* Color del texto- */
            cursor: pointer; /* Cursor de puntero. */
            border-radius: 5px; /* Bordes redondeados. */
            transition: left 0.3s; /* Transición suave para el desplazamiento. */
        }

        /* Estilos cuando el menú está oculto .*/
         .sidebar.hidden { /* Estilos para la barra lateral oculta. */
            left: -250px; /* Mueve la barra lateral fuera de la vista. */
        }

       .content.full-width { /* Estilos para el contenido cuando la barra lateral está oculta. */
            margin-left: 0; /* Sin margen izquierdo. */
        }
        #toggleSidebar.hidden { /* Estilos para el botón de ocultar cuando la barra lateral está oculta. */
            left: 10px; /* Mueve el botón a la izquierda .*/
        }

         /* Estilos para el mensaje de bienvenida. */
        .welcome-footer h1 { 
            position: fixed; /* Posición fija. */
            bottom: 40px; /* Alinear al fondo. */
            left: 50%; /* Centrar horizontalmente. */
            transform: translateX(-50%); /* Ajustar para centrar. */
            width: 100%; /* Ancho completo. */
            text-align: center; /* Centrar texto. */
            font-size: 40px; /* Tamaño de la fuente. */
            padding: 15px 0; /* Aumentar el espacio arriba y abajo .*/
            color: white; /* Color del texto. */
            font-family: 'Bebas Neue', sans-serif; /* Fuente Bebas Neue. */
            letter-spacing: 2px; /* Espaciado entre letras. */
            word-spacing: 5px; /* Espaciado entre palabras. */
        }

       /* Ajuste para móviles. */
        @media (max-width: 768px) { /* Estilos para pantallas pequeñas. */
            .sidebar { /* Estilos para la barra lateral .*/
                left: -250px; /* Mueve la barra lateral fuera de la vista. */
            }
            .content { /* Estilos para el contenido .*/
                margin-left: 0; /* Sin margen izquierdo. */
            }
            #toggleSidebar { /* Estilos para el botón de ocultar. */
                left: 10px; /* Mueve el botón a la izquierda. */
            }
        }
    </style>
</head>
<body>

<!-- Mensaje de bienvenida en la parte inferior. -->
<footer class="welcome-footer"> <!-- Contenedor para el mensaje de bienvenida. -->
    <h1 class="text-center">Bienvenid@, {{ Auth::user()->name }}</h1> <!-- Mensaje de bienvenida con el nombre del usuario. -->
</footer>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let images = [ // Array de imágenes de fondo.
            "img/1-1.jpg",
            "img/2-2.jpg",
            "img/3-3.jpg",
            "img/4-4.jpg",
            "img/5-5.jpg",
            "img/6-6.jpg",
        ];
        
        let index = 0; // Índice para las imágenes.
        
        function changeBackground() { // Función para cambiar el fondo.
            document.body.style.backgroundImage = `url('${images[index]}')`; // Cambia la imagen de fondo.
            index = (index + 1) % images.length; // Cicla las imágenes.
        }

        setInterval(changeBackground, 5000); // Cambia cada 5 segundos.
    });
</script>
</body>
</html>
