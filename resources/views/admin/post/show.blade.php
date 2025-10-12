@extends('admin.layouts.master')

@section('content')
    <div class="min-h-screen">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Breadcrumb Navigation -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            @lang('message.dashboard')
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="{{ route('blogs.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white transition-colors duration-200">@lang('message.blogs')</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ Str::limit($blog->title, 30) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                {{ $title }}
                            </h1>
                        </div>
                        <div class="flex items-center gap-3 space-x-3 mt-4 lg:mt-0 mx-3">
                            <a href="{{ route('blogs.index') }}"
                               class="inline-flex gap-3 items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                @lang('message.list')
                            </a>
                            <div class="flex gap-3 items-center space-x-2">
                                <a href="{{ route('blogs.edit', $blog->id) }}"
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    @lang('message.edit')
                                </a>
                                <button type="button"
                                        onclick="confirmDelete({{ $blog->id }})"
                                        class="inline-flex gap-3 items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    @lang('message.delete')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="xl:col-span-2 space-y-8">

                    <!-- Featured Image/Video Section -->
                    @if($blog->photo || $blog->video_id)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $blog->video_id ? __('message.featured_video') : __('message.featured_image') }}
                                </h3>
                            </div>
                            <div class="p-6">
                                @if($blog->video_id)
                                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                        <video src="{{ $blog->video->address }}"
                                               controls
                                               class="w-full h-full object-cover">
                                        </video>
                                    </div>
                                @elseif($blog->photo)
                                    <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-700">
                                        <img src="{{ $blog->photo->address }}"
                                             alt="{{ $blog->title }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{__('message.content')}}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $blog->status == 1 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full {{ $blog->status == 1 ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                {{ $blog->status == 1 ? __('message.active') : __('message.inactive') }}
                            </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="mb-6">
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                    {{ $blog->title }}
                                </h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400 font-mono bg-gray-50 dark:bg-gray-700 px-3 py-1 rounded">
                                    {{ $blog->slug }}
                                </p>
                            </div>

                            <div class="prose prose-lg dark:prose-invert max-w-none">
                                {!! $blog->description !!}
                            </div>
                        </div>
                    </div>

                    @if($blog->tags->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">@lang('message.tags')</h3>
                            </div>
                            <div class="p-6">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($blog->tags as $tag)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $tag->name }}
                                </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">@lang('message.information')</h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('message.id')</span>
                                <span class="text-sm font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                #{{ $blog->id }}
                            </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('message.status')</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $blog->status == 1 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $blog->status == 1 ? 'Published' : 'Draft' }}
                            </span>
                            </div>

                            <div class="flex justify-between items-start">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('message.created')</span>
                                <div class="text-right">
                                    @if(config('app.locale') == 'fa')
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ verta()->instance($blog->created_at)->format('%d %B %Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ verta()->instance($blog->created_at)->format('%H:%M') }}
                                        </div>
                                    @else
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $blog->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $blog->created_at->format('g:i A') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="flex justify-between items-start">
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('message.updated')</span>
                                <div class="text-right">
                                    @if(config('app.locale') == 'fa')
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ verta()->instance($blog->updated_at)->format('%d %B %Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ verta()->instance($blog->updated_at)->format('%H:%M') }}
                                        </div>
                                    @else
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $blog->updated_at->format('M d, Y') }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $blog->updated_at->format('g:i A') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Media Information -->
                    @if($blog->photo || $blog->video_id)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">@lang('message.media')</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                @if($blog->photo)
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">@lang('message.featured_image')</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ basename($blog->photo->address) }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if($blog->video_id)
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">Video</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ basename($blog->video->address) }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">@lang('message.quick_action')</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('blogs.edit', $blog->id) }}"
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                @lang('message.edit')
                            </a>
                            <button type="button"
                                    onclick="confirmDelete({{ $blog->id }})"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-700 dark:text-red-400 text-sm font-medium rounded-lg transition-colors duration-200 border border-red-200 dark:border-red-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                @lang('message.delete')
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="hidden" id="delete-form-{{ $blog->id }}">
        @csrf
        @method('DELETE')
    </form>

@endsection


@include('admin.partials.delete')
