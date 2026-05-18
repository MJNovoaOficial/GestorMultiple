import './bootstrap';

import Alpine from 'alpinejs';

const toggle = document.getElementById('theme-toggle');

if (toggle) {
    const circle = document.getElementById('toggle-circle');
    const label = document.getElementById('toggle-label');
    const moonIcon = document.getElementById('moon-icon');
    const sunIcon = document.getElementById('sun-icon');

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');

            toggle.classList.remove('bg-slate-200');
            toggle.classList.add('bg-slate-700');

            circle.classList.remove('left-1', 'bg-white');
            circle.classList.add('right-1', 'bg-slate-800');

            label.textContent = 'Dark';
            label.classList.remove('right-3', 'text-slate-600');
            label.classList.add('left-3', 'text-slate-300');

            moonIcon.classList.remove('hidden');
            sunIcon.classList.add('hidden');
        } else {
            document.documentElement.classList.remove('dark');

            toggle.classList.remove('bg-slate-700');
            toggle.classList.add('bg-slate-200');

            circle.classList.remove('right-1', 'bg-slate-800');
            circle.classList.add('left-1', 'bg-white');

            label.textContent = 'Light';
            label.classList.remove('left-3', 'text-slate-300');
            label.classList.add('right-3', 'text-slate-600');

            moonIcon.classList.add('hidden');
            sunIcon.classList.remove('hidden');
        }
    }

    const savedTheme = localStorage.getItem('theme') || 'dark';

    applyTheme(savedTheme);

    toggle.addEventListener('click', () => {
        const isDark = document.documentElement.classList.contains('dark');

        const newTheme = isDark ? 'light' : 'dark';

        localStorage.setItem('theme', newTheme);

        applyTheme(newTheme);
    });
}

window.Alpine = Alpine;

Alpine.start();
