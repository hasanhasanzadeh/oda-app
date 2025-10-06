@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('contents.index') }}" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.contents') }}
            </a>
        </div>

        <!-- Blog Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                    {{ __('message.create') }}
                </h2>
            </div>

            <form method="post" action="{{ route('contents.store') }}" enctype="multipart/form-data" class="px-6 py-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('message.title') }} *
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title') }}"
                            placeholder="{{ __('message.title') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                            required
                        >
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('message.status') }}
                        </label>
                        <select
                            id="status"
                            name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                        >
                            <option value="1" selected>{{ __('message.active') }}</option>
                            <option value="0">{{ __('message.inactive') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('message.type') }}
                        </label>
                        <select
                            id="type"
                            name="type"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                        >
                            <option value="contact-us" >{{ __('message.contact-us') }}</option>
                            <option value="about-us" >{{ __('message.about-us') }}</option>
                            <option value="rules" >{{ __('message.rules') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Media Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <x-file-previewer name="image"
                                      label="عکس "
                                      :multiple="false"
                                      lang="fa"
                                      accept="image/*"
                                      :maxSize="config('file-upload.max_file_upload')"
                    />
                </div>

                <!-- Text Content -->
                <div class="mt-6 space-y-6">
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
                                placeholder="توضیحات  را وارد کنید"
                        />
                </div>

                <!-- Meta Fields -->
                @include('admin.partials.meta')

                <!-- Submit Button -->
                <div class="mt-6 flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        {{ __('message.store') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
