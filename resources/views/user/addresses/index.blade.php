@extends('layouts.app')

@section('title', 'آدرس های من')

@section('content')
    <div class="bg-gray-100 py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-6">
                @include('user.partials.sidebar')

                <div class="flex-1 space-y-6">
                    <!-- Profile Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-6">اطلاعات شخصی</h2>

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                                <i class="fas fa-check-circle ml-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                                <ul class="list-disc pr-6">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2">نام و نام خانوادگی *</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition">
                                </div>

                                <div>
                                    <label class="block font-bold mb-2">ایمیل *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition">
                                </div>

                                <div>
                                    <label class="block font-bold mb-2">شماره تماس</label>
                                    <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition"
                                           placeholder="09123456789">
                                </div>

                                <div>
                                    <label class="block font-bold mb-2">کد ملی</label>
                                    <input type="text" name="national_code" value="{{ old('national_code', $user->national_code) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition"
                                           placeholder="0123456789">
                                </div>
                            </div>

                            <button type="submit"
                                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg font-bold hover:scale-105 transform transition shadow-lg">
                                <i class="fas fa-save ml-2"></i>
                                ذخیره تغییرات
                            </button>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-6">تغییر رمز عبور</h2>

                        <form action="{{ route('user.password.change') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block font-bold mb-2">رمز عبور فعلی *</label>
                                <input type="password" name="current_password" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2">رمز عبور جدید *</label>
                                    <input type="password" name="password" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition">
                                    <p class="text-sm text-gray-600 mt-1">حداقل 8 کاراکتر</p>
                                </div>

                                <div>
                                    <label class="block font-bold mb-2">تکرار رمز عبور جدید *</label>
                                    <input type="password" name="password_confirmation" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition">
                                </div>
                            </div>

                            <button type="submit"
                                    class="bg-green-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-green-700 transition shadow-lg">
                                <i class="fas fa-key ml-2"></i>
                                تغییر رمز عبور
                            </button>
                        </form>
                    </div>

                    <!-- Account Statistics -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold mb-6">آمار حساب کاربری</h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center p-4 bg-blue-50 rounded-lg">
                                <div class="text-3xl font-bold text-blue-600 mb-2">
                                    {{ $user->orders()->count() }}
                                </div>
                                <div class="text-gray-700">سفارش ثبت شده</div>
                            </div>

                            <div class="text-center p-4 bg-purple-50 rounded-lg">
                                <div class="text-3xl font-bold text-purple-600 mb-2">
                                    {{ $user->favorites()->count() }}
                                </div>
                                <div class="text-gray-700">محصول مورد علاقه</div>
                            </div>

                            <div class="text-center p-4 bg-green-50 rounded-lg">
                                <div class="text-3xl font-bold text-green-600 mb-2">
                                    {{ $user->comments()->count() }}
                                </div>
                                <div class="text-gray-700">نظر ثبت شده</div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Account -->
                    <div class="bg-white rounded-lg shadow-md p-6 border-2 border-red-200">
                        <h2 class="text-2xl font-bold text-red-600 mb-4">حذف حساب کاربری</h2>
                        <p class="text-gray-700 mb-4">
                            با حذف حساب کاربری، تمام اطلاعات شما از جمله سفارشات، علاقه‌مندی‌ها و نظرات به صورت دائم حذف خواهد شد.
                        </p>
                        <button onclick="if(confirm('آیا از حذف حساب کاربری خود مطمئن هستید؟ این عمل غیرقابل بازگشت است!')) { document.getElementById('delete-account-form').submit(); }"
                                class="bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 transition">
                            <i class="fas fa-trash ml-2"></i>
                            حذف حساب کاربری
                        </button>
                        <form id="delete-account-form" action="{{ route('user.account.delete') }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
