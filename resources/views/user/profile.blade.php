@extends('layouts.app')

@section('title', 'اطلاعات کاربری')

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

                        <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block font-bold mb-2">نام *</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">نام خانوادگی *</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block font-bold mb-2">ایمیل *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition">
                                </div>

                                <div>
                                    <label class="block font-bold mb-2">شماره تماس</label>
                                    <input type="tel" name="mobile" value="{{ old('mobile', $user->mobile) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition"
                                           placeholder="09123456789">
                                </div>

                                <div>
                                    <label class="block font-bold mb-2">کد ملی</label>
                                    <input type="text" name="national_code" value="{{ old('national_code', $user->national_code) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition"
                                           placeholder="0123456789">
                                </div>
                                <div class="space-y-2">
                                    <label for="birthday" class="block text-sm font-semibold text-slate-700  mb-3">تاریخ تولد</label>
                                    <x-persian-datepicker
                                        name="birthday"
                                        id="birthday"
                                        :value="$user->birthday??''"
                                        placeholder="تاریخ تولد را انتخاب کنید"
                                    />
                                </div>
                                <div class="space-y-2">
                                    <label for="gender" class="block text-sm font-semibold text-slate-700  mb-3">
                                        جنسیت <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="gender"
                                                name="gender"
                                                class="w-full px-10 py-4 bg-slate-50  border-2 border-slate-200 rounded-2xl text-slate-900  focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/20 transition-all duration-300 @error('gender') border-red-300 ring-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                                required>
                                            <option value="">انتخاب جنسیت</option>
                                            <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>مرد</option>
                                            <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>زن</option>
                                        </select>
                                        <div class="absolute left-4 top-4 pointer-events-none">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('gender')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <x-file-previewer name="avatar"
                                                  label="عکس پروفایل "
                                                  :multiple="false"
                                                  lang="fa"
                                                  accept="image/*"
                                                  :maxSize="config('file-upload.max_file_upload')"
                                                  :existing-url="$customer->avatar->address??''"
                                                  :existing-type="$customer->avatar->type??''"
                                />
                            </div>

                            <button type="submit"
                                    class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-lg font-bold hover:scale-105 transform transition shadow-lg">
                                <i class="fas fa-save ml-2"></i>
                                ذخیره تغییرات
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
                        <form id="delete-form-{{ $user->id }}" action="{{ route('user.account.delete') }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                    onclick="confirmDelete({{$user->id}})"
                                    class="bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 transition">
                                <i class="fas fa-trash ml-2"></i>
                                حذف حساب کاربری
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('admin.partials.delete')
