@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 py-6 mx-auto w-full">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4 sm:mb-0">
                {{ $title }}
            </h1>
            <a href="{{ route('settings.index') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-medium rounded-lg transition-colors duration-200 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.settings') }}
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                <form class="w-full" method="post" action="{{ route('settings.update', $panel->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PATCH') }}
                    <input type="hidden" name="id" value="{{ $panel->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title Field -->
                        <div class="space-y-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('message.title') }}
                            </label>
                            <input id="title" name="title" type="text" value="{{ $panel->title }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-600 shadow-sm transition-colors duration-200"
                                   placeholder="{{ __('message.title') }}">
                        </div>
                        <!-- URL Field -->
                        <div class="space-y-2">
                            <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('message.url') }}
                            </label>
                            <input id="url" name="url" type="text" value="{{ $panel->url }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-600 shadow-sm transition-colors duration-200"
                                   placeholder="{{ __('message.url') }}">
                        </div>

                        <!-- Short Text Field -->
                        <div class="space-y-2">
                            <label for="short_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('message.short_text') }}
                            </label>
                            <input id="short_text" name="short_text" type="text" value="{{ $panel->short_text }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-600 shadow-sm transition-colors duration-200"
                                   placeholder="{{ __('message.short_text') }}">
                        </div>

                        <!-- Telephone Field -->
                        <div class="space-y-2">
                            <label for="tel" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('message.tel') }}
                            </label>
                            <input id="tel" name="tel" type="text" value="{{ $panel->tel }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-600 shadow-sm transition-colors duration-200"
                                   placeholder="{{ __('message.tel') }}">
                        </div>

                        <!-- Phone Field -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('message.phone') }}
                            </label>
                            <input id="phone" name="phone" type="text" value="{{ $panel->phone }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-600 shadow-sm transition-colors duration-200"
                                   placeholder="{{ __('message.phone') }}">
                        </div>

                        <!-- Email Field -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('message.email') }}
                            </label>
                            <input id="email" name="email" type="email" value="{{ $panel->email }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-600 shadow-sm transition-colors duration-200"
                                   placeholder="{{ __('message.email') }}">
                        </div>

                        <!-- Support Text Field -->
                        <div class="space-y-2">
                            <label for="support_text"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('message.support_text') }}
                            </label>
                            <input id="support_text" name="support_text" type="text" value="{{ $panel->support_text }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-600 shadow-sm transition-colors duration-200"
                                   placeholder="{{ __('message.support_text') }}">
                        </div>
                        <div class="flex justify-between items-center gap-2">
                            <x-file-previewer name="favicon"
                                              label="تغییر ایکون"
                                              :multiple="false"
                                              lang="fa"
                                              accept="image/*"
                                              :maxSize="config('file-upload.max_file_upload')"
                                              :existing-url="$panel->favicon_id?$panel->favicon->address:''"
                                              :existing-type="$panel->favicon_id?$panel->favicon->type:''"
                            />
                            <x-file-previewer name="logo"
                                              label="تغییر لوگو"
                                              :multiple="false"
                                              lang="fa"
                                              accept="image/*"
                                              :maxSize="config('file-upload.max_file_upload')"
                                              :existing-url="$panel->logo_id?$panel->logo->address:''"
                                              :existing-type="$panel->logo_id?$panel->logo->type:''"
                            />
                        </div>
                    </div>

                    <!-- Full Width Fields -->
                    <div class="mt-6 space-y-6">
                        <!-- Address Field -->
                        <div class="space-y-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('message.address') }}
                            </label>
                            <input id="address" name="address" type="text" value="{{ $panel->address }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-600 shadow-sm transition-colors duration-200"
                                   placeholder="{{ __('message.address') }}">
                        </div>

                        <!-- Copyright Field -->
                        <div class="space-y-2">
                            <label for="copy_right" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('message.copy_right') }}
                            </label>
                            <textarea id="copy_right" name="copy_right" rows="3"
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-600 shadow-sm transition-colors duration-200"
                                      placeholder="{{ __('message.copy_right') }}">{{ $panel->copy_right }}</textarea>
                        </div>

                        <!-- Description Field -->
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('message.description') }}
                            </label>
                            <textarea id="description" name="description" rows="3"
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-600 shadow-sm transition-colors duration-200"
                                      placeholder="{{ __('message.description') }}">{{ $panel->description }}</textarea>
                        </div>

                        <!-- Include Partials -->
                        @include('admin.partials.media_edit', ['object' => $panel ?? null])
                        @include('admin.partials.meta_edit', ['object' => $panel])

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-medium rounded-lg transition-colors duration-200 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                {{ __('message.store') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Image preview functionality
        document.addEventListener('DOMContentLoaded', function () {
            // Logo preview
            document.getElementById('logo_id').addEventListener('change', function (e) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const logoImg = document.getElementById('logo');
                        logoImg.src = e.target.result;
                        logoImg.classList.remove('hidden');
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Favicon preview
            document.getElementById('favicon_id').addEventListener('change', function (e) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const faviconImg = document.getElementById('favicon');
                        faviconImg.src = e.target.result;
                        faviconImg.classList.remove('hidden');
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>

@endsection
