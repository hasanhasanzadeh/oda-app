<aside class="lg:w-64">
    <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
        <div class="text-center mb-6 pb-6 border-b">
            @if(auth()->user()->avatar)
                <img src="{{auth()->user()->avatar->address}}" alt="{{ auth()->user()->full_name }}" class="w-24 h-24 bg-gradient-to-br object-contain rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3 shadow-md">
            @else
                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3">
                    {{ substr(auth()->user()->full_name, 0, 1) }}
                </div>
            @endif
            <h3 class="font-bold text-lg">{{ auth()->user()->full_name }}</h3>
            <p class="text-sm text-gray-600">{{ auth()->user()->mobile }}</p>
        </div>

        <nav class="space-y-1">
            <a href="{{ route('user.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.dashboard') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-th-large w-5"></i>
                <span>داشبورد</span>
            </a>
            <a href="{{ route('user.orders') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.orders*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-shopping-bag w-5"></i>
                <span>سفارش‌ها</span>
            </a>
            <a href="{{ route('user.favorites') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.favorites') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-heart w-5"></i>
                <span>علاقه‌مندی‌ها</span>
            </a>
            <a href="{{ route('user.profile') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.profile') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-user w-5"></i>
                <span>اطلاعات کاربری</span>
            </a>
            <a href="{{ route('user.comments') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('user.comments') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700 hover:bg-gray-50' }} transition">
                <i class="fas fa-comment w-5"></i>
                <span>نظرات من</span>
            </a>
            <form action="{{route('user.logout')}}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50 transition">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>خروج</span>
                </button>
            </form>
        </nav>
    </div>
</aside>
