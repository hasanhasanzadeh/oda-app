<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مستندات API - لاراول</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .code-block { background: #1e293b; border-radius: 8px; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .hover-scale { transition: transform 0.2s; }
        .hover-scale:hover { transform: translateY(-2px); }
    </style>
</head>
<body class="bg-gray-50">
<!-- Navbar -->
<nav class="gradient-bg text-white shadow-lg">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4 space-x-reverse">
                <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                </svg>
                <h1 class="text-2xl font-bold">API Platform</h1>
            </div>
            <div class="flex items-center space-x-6 space-x-reverse">
                <a href="#" class="hover:text-gray-200">مستندات</a>
                <a href="#" class="hover:text-gray-200">نمونه‌ها</a>
                <button class="bg-white text-purple-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100">
                    دریافت API Key
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="gradient-bg text-white py-16">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-5xl font-bold mb-4">RESTful API قدرتمند و امن</h2>
        <p class="text-xl mb-8 opacity-90">با استفاده از لاراول، بهترین تجربه را برای توسعه‌دهندگان فراهم کنید</p>
        <div class="flex justify-center space-x-4 space-x-reverse">
            <button class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                شروع سریع
            </button>
            <button class="border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600">
                مشاهده نمونه‌ها
            </button>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto px-6 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h3 class="font-bold text-lg mb-4 text-gray-800">فهرست مطالب</h3>
                <ul class="space-y-3">
                    <li><a href="#authentication" class="text-purple-600 hover:text-purple-800">احراز هویت</a></li>
                    <li><a href="#users" class="text-gray-600 hover:text-purple-600">مدیریت کاربران</a></li>
                    <li><a href="#products" class="text-gray-600 hover:text-purple-600">مدیریت محصولات</a></li>
                    <li><a href="#orders" class="text-gray-600 hover:text-purple-600">مدیریت سفارشات</a></li>
                    <li><a href="#errors" class="text-gray-600 hover:text-purple-600">مدیریت خطاها</a></li>
                </ul>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <h4 class="font-semibold text-sm text-gray-700 mb-3">نسخه API</h4>
                    <div class="bg-purple-50 text-purple-700 px-4 py-2 rounded-lg text-center font-semibold">
                        v2.1.0
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="lg:col-span-3 space-y-8">
            <!-- Authentication Section -->
            <div id="authentication" class="bg-white rounded-lg shadow-md p-8 hover-scale">
                <div class="flex items-center mb-6">
                    <div class="bg-purple-100 p-3 rounded-lg ml-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">احراز هویت</h3>
                        <p class="text-gray-600">استفاده از Bearer Token برای احراز هویت</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="font-semibold text-lg mb-3 text-gray-800">دریافت توکن</h4>
                    <div class="code-block p-4 overflow-x-auto">
                            <pre class="text-sm text-gray-300"><code>POST /api/auth/login

{
    "email": "user@example.com",
    "password": "password123"
}

// Response
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGci...",
    "user": {
        "id": 1,
        "name": "علی احمدی",
        "email": "user@example.com"
    }
}</code></pre>
                    </div>
                </div>

                <div class="bg-blue-50 border-r-4 border-blue-500 p-4 rounded">
                    <p class="text-sm text-blue-800">
                        <strong>نکته:</strong> توکن را در هدر Authorization با فرمت Bearer {token} ارسال کنید
                    </p>
                </div>
            </div>

            <!-- Users API -->
            <div id="users" class="bg-white rounded-lg shadow-md p-8 hover-scale">
                <div class="flex items-center mb-6">
                    <div class="bg-green-100 p-3 rounded-lg ml-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">مدیریت کاربران</h3>
                        <p class="text-gray-600">CRUD عملیات برای کاربران</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- Get Users -->
                    <div>
                        <div class="flex items-center mb-3">
                            <span class="bg-green-500 text-white px-3 py-1 rounded text-sm font-semibold ml-3">GET</span>
                            <code class="text-gray-700">/api/users</code>
                        </div>
                        <p class="text-gray-600 mb-3">دریافت لیست تمام کاربران</p>
                        <div class="code-block p-4 overflow-x-auto">
                                <pre class="text-sm text-gray-300"><code>// Response
{
    "data": [
        {
            "id": 1,
            "name": "علی احمدی",
            "email": "ali@example.com",
            "created_at": "2025-01-15T10:30:00"
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 50
    }
}</code></pre>
                        </div>
                    </div>

                    <!-- Create User -->
                    <div class="border-t pt-6">
                        <div class="flex items-center mb-3">
                            <span class="bg-blue-500 text-white px-3 py-1 rounded text-sm font-semibold ml-3">POST</span>
                            <code class="text-gray-700">/api/users</code>
                        </div>
                        <p class="text-gray-600 mb-3">ایجاد کاربر جدید</p>
                        <div class="code-block p-4 overflow-x-auto">
                                <pre class="text-sm text-gray-300"><code>{
    "name": "محمد رضایی",
    "email": "mohammad@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products API -->
            <div id="products" class="bg-white rounded-lg shadow-md p-8 hover-scale">
                <div class="flex items-center mb-6">
                    <div class="bg-orange-100 p-3 rounded-lg ml-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">مدیریت محصولات</h3>
                        <p class="text-gray-600">مدیریت کامل محصولات</p>
                    </div>
                </div>

                <div>
                    <div class="flex items-center mb-3">
                        <span class="bg-green-500 text-white px-3 py-1 rounded text-sm font-semibold ml-3">GET</span>
                        <code class="text-gray-700">/api/products</code>
                    </div>
                    <div class="code-block p-4 overflow-x-auto">
                            <pre class="text-sm text-gray-300"><code>// با فیلتر و جستجو
GET /api/products?search=لپتاپ&category=electronics&sort=price

// Response
{
    "data": [
        {
            "id": 1,
            "name": "لپتاپ ایسوس",
            "price": 25000000,
            "category": "electronics",
            "stock": 15
        }
    ]
}</code></pre>
                    </div>
                </div>
            </div>

            <!-- Rate Limits -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg shadow-md p-8">
                <h3 class="text-xl font-bold text-gray-800 mb-4">محدودیت‌های درخواست (Rate Limiting)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">60</div>
                        <div class="text-gray-600 text-sm">درخواست در دقیقه</div>
                    </div>
                    <div class="bg-white p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">1000</div>
                        <div class="text-gray-600 text-sm">درخواست در ساعت</div>
                    </div>
                    <div class="bg-white p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2">10000</div>
                        <div class="text-gray-600 text-sm">درخواست در روز</div>
                    </div>
                </div>
            </div>

            <!-- Error Codes -->
            <div id="errors" class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">کدهای خطای رایج</h3>
                <div class="space-y-4">
                    <div class="flex items-start p-4 bg-red-50 rounded-lg">
                        <span class="bg-red-500 text-white px-3 py-1 rounded text-sm font-semibold ml-3">400</span>
                        <div>
                            <div class="font-semibold text-gray-800">Bad Request</div>
                            <div class="text-sm text-gray-600">درخواست نامعتبر - پارامترهای ارسالی اشتباه است</div>
                        </div>
                    </div>
                    <div class="flex items-start p-4 bg-yellow-50 rounded-lg">
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded text-sm font-semibold ml-3">401</span>
                        <div>
                            <div class="font-semibold text-gray-800">Unauthorized</div>
                            <div class="text-sm text-gray-600">عدم احراز هویت - توکن معتبر نیست</div>
                        </div>
                    </div>
                    <div class="flex items-start p-4 bg-orange-50 rounded-lg">
                        <span class="bg-orange-500 text-white px-3 py-1 rounded text-sm font-semibold ml-3">404</span>
                        <div>
                            <div class="font-semibold text-gray-800">Not Found</div>
                            <div class="text-sm text-gray-600">منبع مورد نظر یافت نشد</div>
                        </div>
                    </div>
                    <div class="flex items-start p-4 bg-purple-50 rounded-lg">
                        <span class="bg-purple-500 text-white px-3 py-1 rounded text-sm font-semibold ml-3">429</span>
                        <div>
                            <div class="font-semibold text-gray-800">Too Many Requests</div>
                            <div class="text-sm text-gray-600">تعداد درخواست‌ها بیش از حد مجاز</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-800 text-white py-8 mt-12">
    <div class="container mx-auto px-6 text-center">
        <p class="mb-2">© 2025 Laravel API Platform. تمامی حقوق محفوظ است.</p>
        <p class="text-gray-400 text-sm">ساخته شده با ❤️ با لاراول و Tailwind CSS</p>
    </div>
</footer>
</body>
</html>
