<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('icons/ico/icono-soundWave.ico') }}">
    <title>{{ $title ?? 'Inicio' }}</title>

    <!-- SCRIPT ANTI-PARPADEO (Debe ir aquí arriba) -->
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'light') {
                document.documentElement.classList.add('light');
            }
        })();
    </script>

    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Estilo rápido para el botón si no está en el nav */
        #theme-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .hidden { display: none; }
    </style>
</head>

<body class="fondo d-flex flex-column min-vh-100">
    <x-header />

    <button id="theme-toggle" class="btn-brand shadow-lg" title="Cambiar modo">
        <!-- Icono Sol: Se muestra cuando estamos en modo oscuro (porque el botón cambiará a claro) -->
        <span id="theme-toggle-light-icon" class="hidden"><i class="fa-solid fa-sun"></i></span>
        <!-- Icono Luna: Se muestra cuando estamos en modo claro -->
        <span id="theme-toggle-dark-icon" class="hidden"><i class="fa-solid fa-moon"></i></span>
    </button>

    <x-navbar />

    <main class="flex-grow-1">
        {{ $slot }}
    </main>

    <x-cart />
    <x-footer />

    <script src="{{ asset('vendor/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('theme-toggle-light-icon');
        const moonIcon = document.getElementById('theme-toggle-dark-icon');

        function updateIcons() {
            // Si tiene la clase .light, mostramos la LUNA (para volver a oscuro)
            if (document.documentElement.classList.contains('light')) {
                moonIcon.classList.remove('hidden');
                sunIcon.classList.add('hidden');
            } else {
                // Si no tiene .light (está oscuro), mostramos el SOL
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            }
        }

        // Ejecutar al cargar
        updateIcons();

        themeToggleBtn.addEventListener('click', function() {
            if (document.documentElement.classList.contains('light')) {
                document.documentElement.classList.remove('light');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.add('light');
                localStorage.setItem('theme', 'light');
            }
            updateIcons();
        });
    </script>
</body>
</html>
