/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./public/**/*.html",
        "./public/pwa-test.html",
        "./public/offline.html",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Lahzeh', 'Vazirmatn', 'sans-serif'],
            },
            colors: {
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#3b82f6',
                    600: '#2563eb',
                    700: '#1d4ed8',
                    800: '#1e40af',
                    900: '#1e3a8a',
                },
                // PWA specific colors
                pwa: {
                    blue: '#3b82f6',
                    purple: '#8b5cf6',
                    green: '#10b981',
                    red: '#ef4444',
                    yellow: '#f59e0b',
                }
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '2rem',
                    lg: '4rem',
                    xl: '5rem',
                    '2xl': '6rem',
                },
            },
            // PWA specific spacing
            spacing: {
                'safe-top': 'env(safe-area-inset-top)',
                'safe-bottom': 'env(safe-area-inset-bottom)',
                'safe-left': 'env(safe-area-inset-left)',
                'safe-right': 'env(safe-area-inset-right)',
            },
            // PWA specific animations
            animation: {
                'pulse-slow': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'bounce-slow': 'bounce 2s infinite',
                'ping-slow': 'ping 2s cubic-bezier(0, 0, 0.2, 1) infinite',
                'fade-in': 'fadeIn 0.5s ease-out',
                'slide-in': 'slideIn 0.3s ease-out',
                'scale-in': 'scaleIn 0.2s ease-out',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideIn: {
                    '0%': { transform: 'translateX(-100%)' },
                    '100%': { transform: 'translateX(0)' },
                },
                scaleIn: {
                    '0%': { transform: 'scale(0.95)', opacity: '0' },
                    '100%': { transform: 'scale(1)', opacity: '1' },
                },
            },
            // PWA specific backdrop blur
            backdropBlur: {
                'xs': '2px',
            },
            // PWA specific z-index
            zIndex: {
                '60': '60',
                '70': '70',
                '80': '80',
                '90': '90',
                '100': '100',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        // Custom PWA utilities plugin
        function({ addUtilities, addComponents, theme }) {
            const newUtilities = {
                // PWA specific utilities
                '.pwa-safe-area': {
                    paddingTop: 'env(safe-area-inset-top)',
                    paddingBottom: 'env(safe-area-inset-bottom)',
                    paddingLeft: 'env(safe-area-inset-left)',
                    paddingRight: 'env(safe-area-inset-right)',
                },
                '.pwa-no-scroll': {
                    overflow: 'hidden',
                    position: 'fixed',
                    width: '100%',
                },
                '.pwa-touch-action': {
                    touchAction: 'manipulation',
                },
                '.pwa-select-none': {
                    userSelect: 'none',
                    '-webkit-user-select': 'none',
                    '-moz-user-select': 'none',
                    '-ms-user-select': 'none',
                },
                // PWA notification styles
                '.pwa-notification': {
                    position: 'fixed',
                    top: '1rem',
                    right: '1rem',
                    zIndex: '50',
                    maxWidth: '24rem',
                    backgroundColor: theme('colors.white'),
                    borderRadius: '0.5rem',
                    boxShadow: '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                    padding: '1rem',
                },
                // PWA install prompt styles
                '.pwa-install-prompt': {
                    position: 'fixed',
                    bottom: '1rem',
                    left: '1rem',
                    right: '1rem',
                    zIndex: '50',
                    backgroundColor: theme('colors.white'),
                    borderRadius: '0.75rem',
                    boxShadow: '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
                    padding: '1.5rem',
                },
                // PWA offline indicator
                '.pwa-offline-indicator': {
                    position: 'fixed',
                    bottom: '1rem',
                    right: '1rem',
                    zIndex: '50',
                    backgroundColor: theme('colors.red.600'),
                    color: theme('colors.white'),
                    borderRadius: '0.5rem',
                    padding: '0.75rem 1rem',
                    fontSize: '0.875rem',
                    fontWeight: '500',
                },
            };

            const newComponents = {
                // PWA button components
                '.btn-pwa': {
                    display: 'inline-flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    padding: '0.75rem 1.5rem',
                    borderRadius: '0.5rem',
                    fontWeight: '600',
                    fontSize: '0.875rem',
                    lineHeight: '1.25rem',
                    transition: 'all 0.2s',
                    cursor: 'pointer',
                    border: 'none',
                    outline: 'none',
                    '&:focus': {
                        outline: '2px solid transparent',
                        outlineOffset: '2px',
                        boxShadow: '0 0 0 3px rgba(59, 130, 246, 0.5)',
                    },
                },
                '.btn-pwa-primary': {
                    backgroundColor: theme('colors.blue.600'),
                    color: theme('colors.white'),
                    '&:hover': {
                        backgroundColor: theme('colors.blue.700'),
                        transform: 'translateY(-1px)',
                        boxShadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1)',
                    },
                },
                '.btn-pwa-secondary': {
                    backgroundColor: theme('colors.gray.200'),
                    color: theme('colors.gray.700'),
                    '&:hover': {
                        backgroundColor: theme('colors.gray.300'),
                    },
                },
                // PWA card components
                '.card-pwa': {
                    backgroundColor: theme('colors.white'),
                    borderRadius: '0.75rem',
                    boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
                    overflow: 'hidden',
                    transition: 'all 0.3s ease',
                    '&:hover': {
                        boxShadow: '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                        transform: 'translateY(-2px)',
                    },
                },
            };

            addUtilities(newUtilities);
            addComponents(newComponents);
        },
    ],
}
