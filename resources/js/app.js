import './bootstrap';

import Alpine from 'alpinejs';
import flatpickr from "flatpickr";
import "flatpickr/dist/themes/dark.css";
import { Spanish } from "flatpickr/dist/l10n/es.js";

const toggle = document.getElementById('theme-toggle');

    if (toggle) {

        const circle = document.getElementById('toggle-circle');
        const moonIcon = document.getElementById('moon-icon');
        const sunIcon = document.getElementById('sun-icon');

        function applyTheme(theme) {

            if (theme === 'dark') {

                document.documentElement.classList.add('dark');

                circle.classList.remove('left-1');
                circle.classList.add('right-1');

                moonIcon.classList.remove('hidden');
                sunIcon.classList.add('hidden');

            } else {

                document.documentElement.classList.remove('dark');

                circle.classList.remove('right-1');
                circle.classList.add('left-1');

                moonIcon.classList.add('hidden');
                sunIcon.classList.remove('hidden');
            }

        }

        const savedTheme =
            localStorage.getItem('theme') || 'dark';

        applyTheme(savedTheme);

        toggle.addEventListener('click', () => {

            const isDark =
                document.documentElement.classList.contains('dark');

            const newTheme =
                isDark ? 'light' : 'dark';

            localStorage.setItem('theme', newTheme);

            applyTheme(newTheme);

        });

    }

window.Alpine = Alpine;
window.flatpickr = flatpickr;
window.Spanish = Spanish;

Alpine.start();
