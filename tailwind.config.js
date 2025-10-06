import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out',
                'slide-down': 'slideDown 0.3s ease-out',
                'zoom-in': 'zoomIn 0.3s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: 0 },
                    '100%': { opacity: 1 },
                },
                slideDown: {
                    '0%': { transform: 'translateY(-10px)', opacity: 0 },
                    '100%': { transform: 'translateY(0)', opacity: 1 },
                },
                zoomIn: {
                    '0%': { transform: 'scale(0.9)', opacity: 0 },
                    '100%': { transform: 'scale(1)', opacity: 1 },
                },
            },
            fontFamily: {
                sans: ['Nunito','Sans'],
                lahzeh:['Lahzeh']
            },
            colors: {
                'brand': {
                    50: '#fff7ed',
                    100: '#ffedd5',
                    200: '#fed7aa',
                    300: '#fdba74',
                    400: '#fb923c',
                    500: '#f97316',
                    600: '#ea580c',
                    700: '#c2410c',
                    800: '#9a3412',
                    900: '#7c2d12',
                },
                'purple': {
                    50: '#faf5ff',
                    100: '#f3e8ff',
                    200: '#e9d5ff',
                    300: '#d8b4fe',
                    400: '#c084fc',
                    500: '#a855f7',
                    600: '#9333ea',
                    700: '#7c3aed',
                    800: '#6b21a8',
                    900: '#581c87',
                }
            },
            boxShadow: {
                'custom': '0 4px 25px 0 rgba(0, 0, 0, 0.1)',
                'custom-lg': '0 10px 40px 0 rgba(0, 0, 0, 0.15)',
            },
        },
        theme: {
            extend: {
                animation: {
                    'float': 'float 6s ease-in-out infinite',
                    'glow': 'glow 2s ease-in-out infinite alternate',
                    'slide-down': 'slideDown 0.3s ease-out',
                    'slide-up': 'slideUp 0.3s ease-out',
                    'slide-right': 'slideRight 0.3s ease-out',
                    'slide-left': 'slideLeft 0.3s ease-out',
                    'scale-in': 'scaleIn 0.2s ease-out',
                    'bounce-soft': 'bounceSoft 0.6s ease-out',
                    'gradient-x': 'gradient-x 3s ease infinite',
                    'shimmer': 'shimmer 2s linear infinite',
                    'pulse-soft': 'pulseSoft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    'stagger-1': 'stagger 0.3s ease-out 0.1s both',
                    'stagger-2': 'stagger 0.3s ease-out 0.2s both',
                    'stagger-3': 'stagger 0.3s ease-out 0.3s both',
                    'stagger-4': 'stagger 0.3s ease-out 0.4s both',
                    'stagger-5': 'stagger 0.3s ease-out 0.5s both',
                    'flip-in': 'flipIn 0.4s ease-out',
                    'zoom-in': 'zoomIn 0.3s ease-out',
                    'fade-up': 'fadeUp 0.4s ease-out',
                },
                keyframes: {
                    float: {
                        '0%, 100%': { transform: 'translateY(0px)' },
                        '50%': { transform: 'translateY(-10px)' }
                    },
                    glow: {
                        '0%': { boxShadow: '0 0 20px rgba(59, 130, 246, 0.5)' },
                        '100%': { boxShadow: '0 0 30px rgba(59, 130, 246, 0.8), 0 0 40px rgba(59, 130, 246, 0.3)' }
                    },
                    slideDown: {
                        '0%': { opacity: '0', transform: 'translateY(-20px)' },
                        '100%': { opacity: '1', transform: 'translateY(0)' }
                    },
                    slideUp: {
                        '0%': { opacity: '1', transform: 'translateY(0)' },
                        '100%': { opacity: '0', transform: 'translateY(-20px)' }
                    },
                    slideRight: {
                        '0%': { opacity: '0', transform: 'translateX(-20px)' },
                        '100%': { opacity: '1', transform: 'translateX(0)' }
                    },
                    slideLeft: {
                        '0%': { opacity: '0', transform: 'translateX(20px)' },
                        '100%': { opacity: '1', transform: 'translateX(0)' }
                    },
                    scaleIn: {
                        '0%': { opacity: '0', transform: 'scale(0.9)' },
                        '100%': { opacity: '1', transform: 'scale(1)' }
                    },
                    bounceSoft: {
                        '0%, 20%, 53%, 80%, 100%': { transform: 'translate3d(0,0,0)' },
                        '40%, 43%': { transform: 'translate3d(0, -8px, 0)' },
                        '70%': { transform: 'translate3d(0, -4px, 0)' },
                        '90%': { transform: 'translate3d(0, -2px, 0)' }
                    },
                    'gradient-x': {
                        '0%, 100%': { 'background-size': '200% 200%', 'background-position': 'left center' },
                        '50%': { 'background-size': '200% 200%', 'background-position': 'right center' }
                    },
                    shimmer: {
                        '0%': { transform: 'translateX(-100%)' },
                        '100%': { transform: 'translateX(100%)' }
                    },
                    pulseSoft: {
                        '0%, 100%': { opacity: '1' },
                        '50%': { opacity: '0.8' }
                    },
                    stagger: {
                        '0%': { opacity: '0', transform: 'translateY(20px)' },
                        '100%': { opacity: '1', transform: 'translateY(0)' }
                    },
                    flipIn: {
                        '0%': { transform: 'perspective(400px) rotateX(-90deg)', opacity: '0' },
                        '40%': { transform: 'perspective(400px) rotateX(-10deg)' },
                        '70%': { transform: 'perspective(400px) rotateX(10deg)' },
                        '100%': { transform: 'perspective(400px) rotateX(0deg)', opacity: '1' }
                    },
                    zoomIn: {
                        '0%': { opacity: '0', transform: 'scale(0.3)' },
                        '50%': { opacity: '1' }
                    },
                    fadeUp: {
                        '0%': { opacity: '0', transform: 'translate3d(0, 40px, 0)' },
                        '100%': { opacity: '1', transform: 'translate3d(0, 0, 0)' }
                    }
                },
                backdropBlur: {
                    xs: '2px',
                },
                colors: {
                    'glass': 'rgba(255, 255, 255, 0.1)',
                    'glass-dark': 'rgba(0, 0, 0, 0.1)',
                }
            }
        }
    },
    plugins: [
        require('flowbite/plugin')({
            charts: true,
        }),
        forms
    ]
};
