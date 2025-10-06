@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('services.index') }}"
               class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.services') }}
            </a>
        </div>

        <!-- Blog Edit Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                    {{ __('message.edit') }}: {{ $service->title }}
                </h2>
            </div>

            <form method="post" action="{{ route('services.update', $service->id) }}" enctype="multipart/form-data"
                  class="px-6 py-4">
                @csrf
                {{ method_field('PATCH') }}
                <input type="hidden" name="id" value="{{ $service->id }}">

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
                                value="{{ $service->title }}"
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
                            <option value="1" {{ $service->status == 1 ? 'selected' : '' }}>{{ __('message.active') }}</option>
                            <option value="0" {{ $service->status == 0 ? 'selected' : '' }}>{{ __('message.inactive') }}</option>
                        </select>
                    </div>
                </div>

                <div class="w-full mt-6 space-y-6 gap-2">
                    <x-file-previewer name="image"
                                      label=" عکس"
                                      :multiple="false"
                                      lang="fa"
                                      accept="image/*"
                                      :maxSize="config('file-upload.max_file_upload')"
                                      :existing-url="$service->photo->address??''"
                                      :existing-type="$service->photo->type??''"

                    />
                </div>

                <!-- Text Content -->
                <div class="mt-6 space-y-6">
                    <!-- Description -->
                    <div>
                        <label for="description"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('message.description') }}
                        </label>
                        <textarea
                                id="description"
                                name="description"
                                rows="4"
                                placeholder="{{ __('message.description') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                        >{!! $service->description !!}</textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('services.show', $service->id) }}"
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
