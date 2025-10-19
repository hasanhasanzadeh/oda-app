@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('products.index') }}"
               class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.products') }}
            </a>
        </div>

        <!-- Product Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                    {{ __('message.create') }}
                </h2>
            </div>

            <form method="post" action="{{ route('products.store') }}" class="px-6 py-4" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('message.name') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                   placeholder="نام محصول را وارد کنید"
                                   class="w-full px-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-500"
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="name_en" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('message.name_en') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="name_en" name="name_en" value="{{ old('name_en') }}"
                                   placeholder="نام لاتین محصول را وارد کنید"
                                   class="w-full px-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-500"
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('message.slug') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                                   placeholder="ایجاد خودکار نامک"
                                   class="w-full px-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-500"
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="original_price">
                                {{__('message.original_price')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <span class="original_price font-bold mb-2 dark:text-gray-50"></span>
                        </div>
                        <input
                            type="text"
                            id="original_price"
                            name="original_price"
                            value="{{ old('original_price') }}"
                            placeholder="{{ __('message.original_price') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                            required
                        >
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="buy_price">
                                {{__('message.buy_price')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <span class="buy_price font-bold mb-2 dark:text-gray-50"></span>
                        </div>
                        <input
                                type="text"
                                id="buy_price"
                                name="buy_price"
                                value="{{ old('buy_price') }}"
                                placeholder="{{ __('message.buy_price') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                                required
                        >
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="discount">
                                {{__('message.discount')}}
                                <span class="font-bold text-red-600 px-2">*</span>
                            </label>
                            <span class="discount font-bold mb-2 dark:text-gray-50"></span>
                        </div>
                        <input
                            type="text"
                            id="discount"
                            name="discount"
                            value="{{ old('discount') }}"
                            placeholder="{{ __('message.discount') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                            required
                        >
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="price">
                                {{__('message.price')}}
                                <span class="font-bold mb-2 dark:text-red-500">*</span>
                            </label>
                            <span class="price font-bold mb-2 dark:text-gray-50"></span>
                        </div>
                        <input
                                type="text"
                                id="price"
                                name="price"
                                value="{{ old('price') }}"
                                placeholder="{{ __('message.price') }}"
                                min="0"
                                step="10000"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                                required
                        >
                    </div>
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('message.quantity') }}
                            <span class="font-bold mb-2 dark:text-red-500">*</span>
                        </label>
                        <input
                                type="text"
                                id="quantity"
                                name="quantity"
                                value="{{ old('quantity') }}"
                                placeholder="{{ __('message.quantity') }}"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                                required
                        >
                    </div>
                    <div>
                        <x-search-select
                                name="category_id"
                                :value="old('category_id')"
                                url="{{ route('category.search') }}"
                                :multiple="false"
                                label="دسته بندی"
                                placeholder="دسته را انتخاب کنید"
                        />
                        @error('category_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('message.status') }}
                        </label>
                        <select
                                id="status"
                                name="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                        >
                            <option value="active" selected>{{ __('message.active') }}</option>
                            <option value="inactive">{{ __('message.inactive') }}</option>
                            <option value="soon">{{ __('message.soon') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="is_featured" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('message.featured') }}
                        </label>
                        <select
                                id="is_featured"
                                name="is_featured"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                        >
                            <option value="1" selected>{{ __('message.featured') }}</option>
                            <option value="0">{{ __('message.not_featured') }}</option>
                        </select>
                    </div>
                    <div>
                     <x-file-previewer name="image"
                                      label="عکس "
                                      :multiple="false"
                                      lang="fa"
                                      accept="image/*"
                                      :maxSize="config('file-upload.max_file_upload')"
                    />
                     </div>
                    <div>
                        <x-file-previewer name="gallery"
                                          label="گالری عکس "
                                          :multiple="true"
                                          lang="fa"
                                          accept="image/*"
                                          :maxSize="config('file-upload.max_file_upload')"
                        />
                    </div>
                    <div class="md:col-span-2">
                        <x-ckeditor-admin
                                    name="description"
                                    label="{{ __('message.description') }}"
                                    height="500px"
                                    language="fa"
                                    :rtl="true"
                                    :value="old('description')"
                                    :required="true"
                                    :image-upload="true"
                                    :file-upload="true"
                                    :autosave="true"
                                    placeholder="توضیحات محصول را وارد کنید خود را وارد کنید"
                            />
                    </div>
                </div>
                @include('admin.partials.meta')
                <!-- Submit Button -->
                <div class="mt-6 flex items-center justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        {{ __('message.store') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{url('/js/numtopersian.min.js')}}"></script>
    <script>
        $('body').on('keyup', '#price', function() {
            let price=Num2persian($(this).val())+" {{__('message.toman')}} ";
            $('.price').html(price);
        });
        $('body').on('keyup', '#buy_price', function() {
            let buy_price=Num2persian($(this).val())+" {{__('message.toman')}} ";
            $('.buy_price').html(buy_price);
        });
        $('body').on('keyup', '#original_price', function() {
            let original_price=Num2persian($(this).val())+" {{__('message.toman')}} ";
            $('.original_price').html(original_price);
        });
        $('body').on('keyup', '#discount', function() {
            let discount=$(this).val();
            let original=$('#original_price').val();
            let result=$('#price').val(original-(original*discount/100));
            let price_1=Num2persian($('#price').val())+" {{__('message.toman')}} ";
            console.log(result+'  '+price_1);
            $('.price').html(price_1);
        });

        $(document).ready(function () {
            $("#name").keyup(function () {
                let name = $(this).val();
                if (name.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('make.slug') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'title': name
                        },
                        success: function (res) {
                            $("#slug").val(res);
                        },
                        error: function () {
                            console.error('Error generating slug');
                        }
                    });
                }
            });
        });
    </script>
@endpush
