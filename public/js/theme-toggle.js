const themeToggleBtn = document.getElementById('theme-toggle');
const sunIcon = document.getElementById('theme-toggle-light-icon');
const moonIcon = document.getElementById('theme-toggle-dark-icon');

function updateIcons() {
    if (document.documentElement.classList.contains('light')) {
        moonIcon.classList.remove('hidden');
        sunIcon.classList.add('hidden');
    } else {
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
