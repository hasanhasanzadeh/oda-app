@extends('admin.layouts.master')

@section('content')
    <div class="min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="backdrop-blur-sm bg-white/70 dark:bg-gray-800/70 rounded-2xl shadow-xl border border-white/20 dark:border-gray-700/50 p-6 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                                {{ $title ?? __('message.edit_blog') }}
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1">@lang('message.blog_edit')</p>
                        </div>
                    </div>
                    <div class="flex space-x-3 mt-6 lg:mt-0">
                        <a href="{{ route('blogs.show', $blog->id) }}"
                           class="group relative inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ __('message.view') }}
                        </a>
                        <a href="{{ route('blogs.index') }}"
                           class="group relative inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800">
                            <svg class="w-5 h-5 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            {{ __('message.blogs') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="backdrop-blur-sm bg-white/80 dark:bg-gray-800/80 rounded-3xl shadow-2xl border border-white/30 dark:border-gray-700/50 overflow-hidden">
                <!-- Form Header -->
                <div class="border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-orange-50 to-red-50 dark:from-gray-800 dark:to-gray-700 px-8 py-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                            {{ __('message.edit') }}
                        </h2>
                    </div>
                </div>
                <form method="post" action="{{ route('blogs.update', $blog->id) }}" enctype="multipart/form-data" class="p-8 space-y-8">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" value="{{$blog->id}}" name="id">
                    <!-- Basic Information Section -->
                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-6 h-6 bg-gradient-to-r from-green-500 to-blue-500 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">@lang('message.basic_information')</h3>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ __('message.title') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="title" name="title" value="{{ old('title', $blog->title) }}"
                                           placeholder="عنوان بلاگ را وارد کنید"
                                           class="w-full px-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm placeholder-gray-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-500"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </div>
                                </div>
                                @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <label for="slug" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ __('message.slug') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="slug" name="slug" value="{{ old('slug', $blog->slug) }}"
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
                                <label for="birthday" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">تاریخ انتشار</label>
                                <x-persian-datepicker
                                        name="publish_date"
                                        id="publish_date"
                                        :value="$blog->publish_date"
                                        placeholder="تاریخ انتشار را انتخاب کنید"
                                />
                                @error('publish_date')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ __('message.status') }}
                                </label>
                                <div class="relative">
                                    <select id="status" name="status"
                                            class="w-full px-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-500 appearance-none">
                                        <option value="1" {{ old('status', $blog->status) == '1' ? 'selected' : '' }}>{{ __('message.active') }}</option>
                                        <option value="0" {{ old('status', $blog->status) == '0' ? 'selected' : '' }}>{{ __('message.inactive') }}</option>
                                    </select>
                                </div>
                                @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between justify-items-center">
                        <x-file-previewer name="image"
                                          label="عکس "
                                          :multiple="false"
                                          lang="fa"
                                          accept="image/*"
                                          :maxSize="config('file-upload.max_file_upload')"
                                          :existing-url="$blog->photo->address??''"
                                          :existing-type="$blog->photo->type??''"
                        />
                        <x-file-previewer name="video"
                                          label="ویدیو "
                                          :multiple="false"
                                          lang="fa"
                                          accept="video/*"
                                          :maxSize="config('file-upload.max_video_upload')"
                                          :existing-url="$blog->video->address??''"
                                          :existing-type="$blog->video->type??''"
                        />
                    </div>

                    <div class="space-y-6">
                        @php
                            $tags = \App\Models\Tag::all();
                            $blogTags = $blog->tags->pluck('name')->toArray();
                        @endphp
                        <x-tags-input
                                name="tags"
                                :tags="$blogTags"
                                :options="$tags->toArray()"
                                label="اضافه کردن تگ"
                                x-on:tags-changed="selectedTags = $event.detail"
                        />
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-6 h-6 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">@lang('message.description')</h3>
                        </div>
                        <div>
                            <x-ckeditor-admin
                                    name="description"
                                    label="{{ __('message.description') }}"
                                    height="500px"
                                    language="fa"
                                    :rtl="true"
                                    :value="old('description', $blog->description)"
                                    :required="true"
                                    :image-upload="true"
                                    :file-upload="true"
                                    :autosave="true"
                                    placeholder="توضیحات مقاله خود را وارد کنید"
                            />
                        </div>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-6 h-6 bg-gradient-to-r from-pink-500 to-red-500 rounded-full flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">@lang('message.meta')</h3>
                        </div>
                        @include('admin.partials.meta_edit', ['object' => $blog])
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex space-x-4">
                            <button
                                    type="submit"
                                    class="px-8 py-3 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white rounded-xl transition-all duration-300 flex items-center space-x-3 space-x-reverse hover:scale-105 shadow-lg"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                <span>به‌روزرسانی محتوا</span>
                                <div class="w-6 h-6 border-2 border-white border-t-transparent rounded-full animate-spin hidden" id="submitSpinner"></div>
                            </button>

                            @if($blog->status == 0)
                                <button
                                        type="submit"
                                        name="publish_now"
                                        value="1"
                                        class="px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-xl transition-all duration-300 flex items-center space-x-3 space-x-reverse hover:scale-105 shadow-lg"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>انتشار فوری</span>
                                </button>
                            @endif
                        </div>

                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            آخرین بروزرسانی: {{ $blog->updated_at->diffForHumans() }}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $("#title").keyup(function () {
                let title = $(this).val();
                if (title.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('make.slug') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'title': title
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
