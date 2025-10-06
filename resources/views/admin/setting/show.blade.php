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

        <!-- Main Content -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Responsive Content Sections -->
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Brand Section -->
                <section class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('message.brand_identity') }}</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Favicon -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="w-full sm:w-1/3 font-medium text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                {{ __('message.favicon') }}
                            </div>
                            <div class="w-full sm:w-2/3 flex justify-center sm:justify-start">
                                @if($panel->favicon_id)
                                    <img src="{{ $panel->favicon->address }}"
                                         class="h-16 w-16 rounded-lg object-cover border border-gray-300 dark:border-gray-600"
                                         alt="Favicon">
                                @else
                                    <img src="{{ url('/images/no-image.png') }}"
                                         class="h-16 w-16 rounded-lg object-cover border border-gray-300 dark:border-gray-600"
                                         alt="No Favicon">
                                @endif
                            </div>
                        </div>

                        <!-- Logo -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="w-full sm:w-1/3 font-medium text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                {{ __('message.logo') }}
                            </div>
                            <div class="w-full sm:w-2/3 flex justify-center sm:justify-start">
                                @if($panel->logo_id)
                                    <img src="{{ $panel->logo->address }}"
                                         class="h-16 w-16 rounded-lg object-cover border border-gray-300 dark:border-gray-600"
                                         alt="Logo">
                                @else
                                    <img src="{{ url('/images/no-image.png') }}"
                                         class="h-16 w-16 rounded-lg object-cover border border-gray-300 dark:border-gray-600"
                                         alt="No Logo">
                                @endif
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Basic Information Section -->
                <section class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('message.basic_information') }}</h2>

                    <div class="space-y-4">
                        <!-- Title -->
                        <div class="flex flex-col sm:flex-row p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="w-full sm:w-1/3 font-medium text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                {{ __('message.title') }}
                            </div>
                            <div class="w-full sm:w-2/3 text-gray-800 dark:text-gray-200">
                                {{ $panel->title }}
                            </div>
                        </div>
                        <!-- Short Text -->
                        <div class="flex flex-col sm:flex-row p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="w-full sm:w-1/3 font-medium text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                {{ __('message.short_text') }}
                            </div>
                            <div class="w-full sm:w-2/3 text-gray-800 dark:text-gray-200">
                                {{ $panel->short_text }}
                            </div>
                        </div>

                        <!-- Support Text -->
                        <div class="flex flex-col sm:flex-row p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="w-full sm:w-1/3 font-medium text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                {{ __('message.support_text') }}
                            </div>
                            <div class="w-full sm:w-2/3 text-gray-800 dark:text-gray-200">
                                {{ $panel->support_text }}
                            </div>
                        </div>

                        <!-- Copyright -->
                        <div class="flex flex-col sm:flex-row p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="w-full sm:w-1/3 font-medium text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                {{ __('message.copy_right') }}
                            </div>
                            <div class="w-full sm:w-2/3 text-gray-800 dark:text-gray-200">
                                {{ $panel->copy_right }}
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Content Section -->
                <section class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('message.content') }}</h2>

                    <div class="space-y-6">

                        <!-- Description -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <h3 class="font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('message.description') }}
                            </h3>
                            <div class="prose prose-sm max-w-none dark:prose-invert text-gray-800 dark:text-gray-200">
                                {!! $panel->description !!}
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contact Information Section -->
                <section class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('message.contact_information') }}</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Address -->
                        <div class="flex flex-col p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('message.address') }}
                            </div>
                            <div class="text-gray-800 dark:text-gray-200">
                                {{ $panel->address }}
                            </div>
                        </div>

                        <!-- Tel -->
                        <div class="flex flex-col p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('message.tel') }}
                            </div>
                            <div class="text-gray-800 dark:text-gray-200">
                                {{ $panel->tel }}
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex flex-col p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('message.phone') }}
                            </div>
                            <div class="text-gray-800 dark:text-gray-200">
                                {{ $panel->phone }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex flex-col p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('message.email') }}
                            </div>
                            <div class="text-gray-800 dark:text-gray-200">
                                {{ $panel->email }}
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Social Media Section -->
                <section class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('message.social_media') }}</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Telegram -->
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9.78 18.65L10.06 14.42L17.74 7.5C18.08 7.19 17.67 7.04 17.22 7.31L7.74 13.3L3.64 12C2.76 11.75 2.75 11.14 3.84 10.7L19.81 4.54C20.54 4.21 21.24 4.72 20.96 5.84L18.24 18.65C18.05 19.56 17.5 19.78 16.74 19.36L12.6 16.3L10.61 18.23C10.38 18.46 10.19 18.65 9.78 18.65Z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('message.telegram') }}</div>
                                <div class="text-gray-800 dark:text-gray-200">{{ $panel->socialMedia->telegram ?? '-' }}</div>
                            </div>
                        </div>

                        <!-- Instagram -->
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('message.instagram') }}</div>
                                <div class="text-gray-800 dark:text-gray-200">{{ $panel->socialMedia->instagram ?? '-' }}</div>
                            </div>
                        </div>

                        <!-- Youtube -->
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('message.youtube') }}</div>
                                <div class="text-gray-800 dark:text-gray-200">{{ $panel->socialMedia->youtube ?? '-' }}</div>
                            </div>
                        </div>

                        <!-- Facebook -->
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('message.facebook') }}</div>
                                <div class="text-gray-800 dark:text-gray-200">{{ $panel->socialMedia->facebook ?? '-' }}</div>
                            </div>
                        </div>

                        <!-- X (Twitter) -->
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-gray-800 dark:text-gray-200" fill="currentColor"
                                     viewBox="0 0 24 24">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('message.x_link') }}</div>
                                <div class="text-gray-800 dark:text-gray-200">{{ $panel->socialMedia->x_link ?? '-' }}</div>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('message.whatsapp') }}</div>
                                <div class="text-gray-800 dark:text-gray-200">{{ $panel->socialMedia->whatsapp ?? '-' }}</div>
                            </div>
                        </div>

                        <!-- LinkedIn -->
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('message.linkedin') }}</div>
                                <div class="text-gray-800 dark:text-gray-200">{{ $panel->socialMedia->linkedin ?? '-' }}</div>
                            </div>
                        </div>

                        <!-- GitHub -->
                        <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="flex-shrink-0 mr-3">
                                <svg class="w-5 h-5 text-gray-900 dark:text-gray-100" fill="currentColor"
                                     viewBox="0 0 24 24">
                                    <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('message.github') }}</div>
                                <div class="text-gray-800 dark:text-gray-200">{{ $panel->socialMedia->github ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Meta Information Section -->
                <section class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('message.meta_information') }}</h2>

                    <div class="space-y-4">
                        <!-- Meta Title -->
                        <div class="flex flex-col sm:flex-row p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="w-full sm:w-1/3 font-medium text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                {{ __('message.meta_title') }}
                            </div>
                            <div class="w-full sm:w-2/3 text-gray-800 dark:text-gray-200">
                                {{ $panel->meta->meta_title ?? '-' }}
                            </div>
                        </div>

                        <!-- Meta Keywords -->
                        <div class="flex flex-col sm:flex-row p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="w-full sm:w-1/3 font-medium text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                {{ __('message.meta_keywords') }}
                            </div>
                            <div class="w-full sm:w-2/3 text-gray-800 dark:text-gray-200">
                                {{ $panel->meta->meta_keywords ?? '-' }}
                            </div>
                        </div>

                        <!-- Meta Description -->
                        <div class="flex flex-col sm:flex-row p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150">
                            <div class="w-full sm:w-1/3 font-medium text-gray-700 dark:text-gray-300 mb-2 sm:mb-0">
                                {{ __('message.meta_description') }}
                            </div>
                            <div class="w-full sm:w-2/3 text-gray-800 dark:text-gray-200">
                                {{ $panel->meta->meta_description ?? '-' }}
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Actions Section -->
                <section class="p-6 flex justify-end">
                    <a href="{{ route('settings.edit', $panel->id) }}"
                       class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-medium rounded-lg transition-colors duration-200 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        {{ __('message.edit') }}
                    </a>
                </section>
            </div>
        </div>
    </div>
@endsection
