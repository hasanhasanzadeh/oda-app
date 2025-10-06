<!-- Footer -->
<footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
    <div class="max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{ route('home') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">آکادمی آنلاین</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">دوره‌ها</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">فروشگاه</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">استعلام گواهی</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">پشتیبانی</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">
                © {{ date('Y') }}
                <a href="{{ route('home') }}" class="hover:underline">آکادمی آنلاین</a>.
                تمامی حقوق محفوظ است.
            </span>
    </div>
</footer>