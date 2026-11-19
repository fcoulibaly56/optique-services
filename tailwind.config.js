import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['"DM Serif Display"', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                optique: {
                    bg: '#F9F8F6',      // Fond ivoire clair
                    text: '#1C1C1C',    // Gris très foncé
                    gray: '#6B7280',    // Gris moyen pour le texte secondaire
                    red: '#A33B36',     // Rouge doux (boutons, accents)
                    redhover: '#8C312C',
                    border: '#E5E5E5',  // Bordures légères
                }
            }
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
