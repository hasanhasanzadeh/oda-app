<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>آفلاین - فروشگاه آنلاین</title>
    <meta name="theme-color" content="#3b82f6">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" href="/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Vazirmatn', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <!-- Offline Icon -->
            <div class="mb-8">
                <div class="w-32 h-32 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-wifi-slash text-6xl text-red-500"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">شما آفلاین هستید</h1>
                <p class="text-gray-600 text-lg">اتصال اینترنت خود را بررسی کنید</p>
            </div>

            <!-- Offline Message -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="flex items-start mb-4">
                    <i class="fas fa-info-circle text-blue-500 text-xl ml-3 mt-1"></i>
                    <div class="text-right">
                        <h3 class="font-bold text-gray-800 mb-2">چه اتفاقی افتاده؟</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            اتصال اینترنت شما قطع شده است. برخی از قابلیت‌ها ممکن است در دسترس نباشند، 
                            اما می‌توانید از محتوای ذخیره شده استفاده کنید.
                        </p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-check text-green-500 ml-3"></i>
                        <span>مشاهده محصولات ذخیره شده</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-check text-green-500 ml-3"></i>
                        <span>دسترسی به سبد خرید</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-check text-green-500 ml-3"></i>
                        <span>مشاهده پروفایل کاربری</span>
                    </div>
                    <div class="flex items-center text-sm text-red-500">
                        <i class="fas fa-times ml-3"></i>
                        <span>خرید آنلاین (نیاز به اینترنت)</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <button onclick="window.location.reload()" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-bold hover:bg-blue-700 transition">
                    <i class="fas fa-sync-alt ml-2"></i>
                    تلاش مجدد
                </button>
                
                <button onclick="goHome()" class="w-full bg-gray-200 text-gray-700 py-3 px-6 rounded-lg font-bold hover:bg-gray-300 transition">
                    <i class="fas fa-home ml-2"></i>
                    بازگشت به خانه
                </button>
            </div>

            <!-- Connection Status -->
            <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                <div class="flex items-center justify-center">
                    <div id="connection-indicator" class="w-3 h-3 bg-red-500 rounded-full ml-2"></div>
                    <span id="connection-text" class="text-sm text-gray-600">آفلاین</span>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    این صفحه به صورت خودکار به‌روزرسانی می‌شود
                </p>
            </div>

            <!-- Help Section -->
            <div class="mt-6 text-center">
                <h4 class="font-bold text-gray-800 mb-3">راهنمای حل مشکل</h4>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>• اتصال Wi-Fi یا داده موبایل را بررسی کنید</p>
                    <p>• مودم یا روتر را ریست کنید</p>
                    <p>• از شبکه دیگری استفاده کنید</p>
                    <p>• با ارائه‌دهنده اینترنت تماس بگیرید</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Connection status monitoring
        function updateConnectionStatus() {
            const indicator = document.getElementById('connection-indicator');
            const text = document.getElementById('connection-text');
            
            if (navigator.onLine) {
                indicator.className = 'w-3 h-3 bg-green-500 rounded-full ml-2';
                text.textContent = 'آنلاین';
                
                // Auto redirect when online
                setTimeout(() => {
                    window.location.href = '/';
                }, 2000);
            } else {
                indicator.className = 'w-3 h-3 bg-red-500 rounded-full ml-2';
                text.textContent = 'آفلاین';
            }
        }

        // Go home function
        function goHome() {
            window.location.href = '/';
        }

        // Event listeners
        window.addEventListener('online', updateConnectionStatus);
        window.addEventListener('offline', updateConnectionStatus);
        
        // Initial status check
        updateConnectionStatus();

        // Periodic status check
        setInterval(updateConnectionStatus, 5000);

        // Service Worker registration
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('Service Worker registered:', registration);
                })
                .catch(error => {
                    console.log('Service Worker registration failed:', error);
                });
        }
    </script>
</body>
</html>
