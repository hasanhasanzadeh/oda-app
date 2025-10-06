<div class="hidden lg:flex items-center justify-center flex-1 relative overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-purple-700 dark:from-blue-800 dark:via-blue-900 dark:to-purple-900">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" opacity="0.3"/>
                    </pattern>
                </defs>
                <rect width="100" height="100" fill="url(#grid)" />
            </svg>
        </div>
        <div class="absolute top-20 left-20 w-32 h-32 bg-white bg-opacity-5 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-32 right-16 w-24 h-24 bg-white bg-opacity-5 rounded-full blur-xl animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 right-32 w-16 h-16 bg-white bg-opacity-5 rounded-full blur-xl animate-pulse" style="animation-delay: 4s;"></div>
    </div>
    <div class="relative z-10 text-center max-w-lg px-8">
        <div class="mb-12">
            <h1 class="text-5xl lg:text-6xl font-black text-white mb-4 leading-tight">
                {{ $setting->title }}
            </h1>
            <div class="w-24 h-1 bg-white bg-opacity-60 mx-auto rounded-full"></div>
        </div>
        <div class="relative mb-12">
            <div class="relative z-10">
                <img
                        src="{{ asset('/images/imag-4355.png') }}"
                        alt="{{ config('app.name') }}"
                        class="w-full max-w-md mx-auto drop-shadow-2xl hover:scale-105 transition-transform duration-500"
                >
            </div>
            <div class="absolute inset-0 bg-white bg-opacity-10 rounded-full blur-3xl scale-75 -z-10"></div>
        </div>
        <div class="space-y-6 text-white text-opacity-90">
            <div class="flex items-center justify-center space-x-4 space-x-reverse">
                <div class="flex items-center space-x-2 space-x-reverse">
                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">امن و مطمئن</span>
                </div>
                <div class="flex items-center space-x-2 space-x-reverse">
                    <svg class="w-5 h-5 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-sm font-medium">سریع و آسان</span>
                </div>
            </div>

            <p class="text-lg text-white text-opacity-80 leading-relaxed max-w-sm mx-auto">
                به بهترین پلتفرم ما خوش آمدید. تجربه‌ای نو و متفاوت را آغاز کنید
            </p>
        </div>
    </div>
</div>