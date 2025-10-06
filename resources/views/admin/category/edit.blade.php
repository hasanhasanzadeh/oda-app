@extends('admin.layouts.master')


@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('categories.index') }}"
               class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.categories') }}
            </a>
        </div>

        <!-- Category Edit Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                    {{ __('message.edit') }}: {{ $category->name }}
                </h2>
            </div>

            <form method="post" action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data"
                  class="px-6 py-4">
                @csrf
                {{ method_field('PATCH') }}
                <input type="hidden" name="id" value="{{ $category->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('message.name') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                                   placeholder="نام دسته را وارد کنید"
                                   class="w-full px-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-500"
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Slug Field -->
                    <div class="space-y-2">
                        <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            {{ __('message.slug') }} <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}"
                                   placeholder="ایجاد خودکار نامک"
                                   class="w-full px-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-500"
                                   required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                        </div>
                        @error('slug')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <div class="m-4">
                            <x-search-select
                                    name="parent_id"
                                    url="{{ route('category.search') }}"
                                    :multiple="false"
                                    label="والد"
                                    placeholder="والد را انتخاب کنید"
                                    :selected="[
                                                        'id' => $category->parent?->id??'',
                                                        'title' => $category->parent?->name ?? 'انتخاب والد',
                                                        'subtitle' => $category->parent?->name,
                                                        'avatar' => $category->parent->photo->address ?? '/images/default-flag.png'
                                                    ]"
                            />
                        </div>
                        <p class="mt-2 text-sm text-red-600 dark:text-gray-50"> در صورت خالی بودن دسته مورد نظر والد می باشد</p>
                        @error('parent_id')
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
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                        >
                            <option value="1" @if($category->status) selected @endif>{{ __('message.active') }}</option>
                            <option value="0"
                                    @if(!$category->status) selected @endif>{{ __('message.unactive') }}</option>
                        </select>
                    </div>
                    <!-- Image Upload -->
                    <div>
                        <x-file-previewer name="image"
                                          label="عکس "
                                          :multiple="false"
                                          lang="fa"
                                          accept="image/*"
                                          :maxSize="config('file-upload.max_file_upload')"
                                          :existing-url="$category->photo->address??''"
                                          :existing-type="$category->photo->type??''"
                        />
                    </div>
                </div>

                <!-- Meta Fields -->
                @include('admin.partials.meta_edit', ['object' => $category])

                <!-- Submit Button -->
                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('categories.show', $category->id) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring focus:ring-gray-300 mr-3 dark:focus:ring-gray-800 transition ease-in-out duration-150">
                        {{ __('message.cancel') }}
                    </a>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        {{ __('message.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
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

            $('form').on('submit', function() {
                $('#submitSpinner').removeClass('hidden');
                $(this).find('button[type="submit"]').prop('disabled', true);
            });

            let autoSaveTimeout;
            $('input, textarea, select').on('input change', function() {
                clearTimeout(autoSaveTimeout);
                autoSaveTimeout = setTimeout(function() {
                    console.log('Auto-saving...');
                }, 5000);
            });
        });
    </script>
@endpush
