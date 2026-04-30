<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('icons/ico/icono-soundWave.ico') }}">
    <title>{{ $title ?? 'Identificación' }} - SOUNDWAVE STORE</title>

    {{-- Script Anti-Parpadeo (Crucial para que no se vea blanco un segundo al cargar) --}}
    <script>
        (function() {
            const theme = localStorage.getItem('theme');
            if (theme === 'light') {
                document.documentElement.classList.add('light');
            }
        })();
    </script>

    <link rel="stylesheet" href="{{ asset('vendor/css/bootstrap.min.css') }}">
    {{-- Vinculamos styles.css donde están nuestras variables y clases adaptativas --}}
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        /* Ajuste específico para centrar el contenido de auth sin scroll innecesario */
        body.fondo {
            background-color: var(--color-uno);
            color: var(--color-texto);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .auth-container {
            max-width: 450px;
            width: 100%;
        }
    </style>
</head>

<body class="fondo d-flex align-items-center justify-content-center" style="min-height: 100vh; overflow-x: hidden;">

    {{-- Switch de Tema --}}
    <div style="position: absolute; top: 20px; right: 20px; z-index: 1000;">
        <button id="theme-toggle" class="btn-brand p-0 rounded-circle shadow"
            style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border: none;">
            <i id="theme-toggle-icon" class="bi bi-sun fs-5"></i>
        </button>
    </div>

    {{-- El contenedor donde caerán Login o Registro --}}
    <div class="auth-container animate__animated animate__fadeIn">
        <div class="text-center mb-4">
            {{-- Logo Adaptativo --}}
            <h1 class="fw-bold mb-0" style="letter-spacing: -1px;">
                <span class="texto-rojo">SOUNDWAVE</span><span class="color-adaptativo">STORE</span>
            </h1>
            <p class="text-muted-adaptativo small text-uppercase fw-bold" style="letter-spacing: 2px;">Audio & Music Lab
            </p>
        </div>

        {{ $slot }}

        {{-- Footer simple para Auth --}}
        <div class="text-center mt-4">
            <p class="small text-muted-adaptativo">
                &copy; {{ date('Y') }} Soundwave Store Corrientes.
            </p>
        </div>
    </div>

    <script src="{{ asset('vendor/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        const themeToggleBtn = document.getElementById('theme-toggle');
        const icon = document.getElementById('theme-toggle-icon');

        function updateIcon() {
            if (document.documentElement.classList.contains('light')) {
                icon.classList.replace('bi-sun', 'bi-moon-stars-fill');
            } else {
                icon.classList.replace('bi-moon-stars-fill', 'bi-sun');
            }
        }

        updateIcon();

        themeToggleBtn.addEventListener('click', function() {
            if (document.documentElement.classList.contains('light')) {
                document.documentElement.classList.remove('light');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.add('light');
                localStorage.setItem('theme', 'light');
            }
            updateIcon();
        });
    </script>
</body>

</html>
