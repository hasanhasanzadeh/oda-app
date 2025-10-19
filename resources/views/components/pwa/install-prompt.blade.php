{{-- PWA Install Prompt Component --}}
<div id="pwa-install-prompt" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" x-data="{ show: false }" x-show="show" x-transition>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-mobile-alt text-2xl ml-3"></i>
                        <div>
                            <h3 class="text-lg font-bold">نصب اپلیکیشن</h3>
                            <p class="text-blue-100 text-sm">فروشگاه آنلاین</p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-white hover:text-gray-200 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shopping-bag text-3xl text-blue-600"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">اپلیکیشن را نصب کنید</h4>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        برای تجربه بهتر، اپلیکیشن فروشگاه آنلاین را روی دستگاه خود نصب کنید. 
                        دسترسی سریع‌تر، اعلان‌های فوری و عملکرد بهتر در انتظار شماست.
                    </p>
                </div>

                <!-- Features -->
                <div class="space-y-3 mb-6">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-bolt text-green-500 ml-3"></i>
                        <span>دسترسی سریع‌تر</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-bell text-blue-500 ml-3"></i>
                        <span>اعلان‌های فوری</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-wifi text-purple-500 ml-3"></i>
                        <span>کارکرد آفلاین</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-mobile-alt text-orange-500 ml-3"></i>
                        <span>تجربه اپلیکیشن</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button id="pwa-install-btn" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg font-bold hover:bg-blue-700 transition">
                        <i class="fas fa-download ml-2"></i>
                        نصب اپلیکیشن
                    </button>
                    <button @click="show = false" class="px-6 py-3 text-gray-600 hover:text-gray-800 transition">
                        بعداً
                    </button>
                </div>

                <!-- Help Text -->
                <div class="mt-4 text-center">
                    <p class="text-xs text-gray-500">
                        <i class="fas fa-info-circle ml-1"></i>
                        برای نصب روی دکمه منو مرورگر کلیک کنید
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- PWA Update Notification --}}
<div id="pwa-update-notification" class="fixed top-4 right-4 bg-green-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm hidden" x-data="{ show: false }" x-show="show" x-transition>
    <div class="flex items-start justify-between">
        <div class="flex items-start">
            <i class="fas fa-sync-alt text-xl ml-3 mt-1"></i>
            <div>
                <h4 class="font-bold">به‌روزرسانی موجود است!</h4>
                <p class="text-sm text-green-100 mt-1">نسخه جدید اپلیکیشن آماده است.</p>
            </div>
        </div>
        <button @click="show = false" class="text-white hover:text-green-200 transition">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="mt-3 flex gap-2">
        <button onclick="window.location.reload()" class="bg-white text-green-600 px-4 py-2 rounded text-sm font-bold hover:bg-green-50 transition">
            <i class="fas fa-download ml-1"></i>
            به‌روزرسانی
        </button>
        <button @click="show = false" class="text-green-100 hover:text-white text-sm transition">
            بعداً
        </button>
    </div>
</div>

{{-- PWA Success Message --}}
<div id="pwa-success-message" class="fixed top-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden" x-data="{ show: false }" x-show="show" x-transition>
    <div class="flex items-center">
        <i class="fas fa-check-circle text-xl ml-3"></i>
        <div>
            <h4 class="font-bold">موفقیت!</h4>
            <p class="text-sm text-green-100">اپلیکیشن با موفقیت نصب شد.</p>
        </div>
    </div>
</div>

{{-- PWA Offline Indicator --}}
<div id="pwa-offline-indicator" class="fixed bottom-4 right-4 bg-red-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 hidden" x-data="{ show: false }" x-show="show" x-transition>
    <div class="flex items-center">
        <i class="fas fa-wifi-slash ml-2"></i>
        <span>شما آفلاین هستید</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // PWA Install Prompt Logic
    let deferredPrompt;
    let installPromptShown = false;

    // Show install prompt after delay
    setTimeout(() => {
        if (!installPromptShown && !window.matchMedia('(display-mode: standalone)').matches) {
            showInstallPrompt();
        }
    }, 5000);

    // Listen for beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        showInstallPrompt();
    });

    // Listen for appinstalled event
    window.addEventListener('appinstalled', () => {
        hideInstallPrompt();
        showSuccessMessage();
    });

    function showInstallPrompt() {
        const prompt = document.getElementById('pwa-install-prompt');
        if (prompt) {
            prompt.classList.remove('hidden');
            prompt._x_dataStack[0].show = true;
        }
    }

    function hideInstallPrompt() {
        const prompt = document.getElementById('pwa-install-prompt');
        if (prompt) {
            prompt.classList.add('hidden');
            prompt._x_dataStack[0].show = false;
        }
    }

    function showSuccessMessage() {
        const success = document.getElementById('pwa-success-message');
        if (success) {
            success.classList.remove('hidden');
            success._x_dataStack[0].show = true;
            setTimeout(() => {
                success.classList.add('hidden');
                success._x_dataStack[0].show = false;
            }, 3000);
        }
    }

    // Install button click handler
    document.addEventListener('click', function(e) {
        if (e.target.id === 'pwa-install-btn') {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    } else {
                        console.log('User dismissed the install prompt');
                    }
                    deferredPrompt = null;
                    hideInstallPrompt();
                });
            } else {
                // Fallback for browsers that don't support beforeinstallprompt
                alert('برای نصب اپلیکیشن، روی دکمه منو مرورگر کلیک کرده و "Add to Home Screen" را انتخاب کنید.');
                hideInstallPrompt();
            }
        }
    });

    // Offline detection
    function updateOnlineStatus() {
        const offlineIndicator = document.getElementById('pwa-offline-indicator');
        if (offlineIndicator) {
            if (navigator.onLine) {
                offlineIndicator.classList.add('hidden');
                offlineIndicator._x_dataStack[0].show = false;
            } else {
                offlineIndicator.classList.remove('hidden');
                offlineIndicator._x_dataStack[0].show = true;
            }
        }
    }

    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
    updateOnlineStatus();
});
</script>
