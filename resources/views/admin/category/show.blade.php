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

        <!-- Category Detail Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <!-- Category Header with Image -->
            <div class="relative">
                <div class="p-6 sm:px-6 sm:py-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center">
                        <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-4 p-2 m-2">
                            @if($category->photo != null)
                                <img
                                        src="{{ $category->photo->address }}"
                                        alt="{{ $category->name }}"
                                        class="h-24 w-24 object-cover rounded-lg shadow-md border border-gray-200 dark:border-gray-600"
                                >
                            @else
                                <div class="h-24 w-24 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md border border-gray-200 dark:border-gray-600">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                               نام دسته : {{ $category->name }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                نامک :{{ $category->slug }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                ترتیب : {{ $category->order }}
                            </p>
                            <div class="mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                 شناسه : {{ $category->id }}
                            </span>

                                @if(isset($category->parent))
                                    <a href="{{ route('categories.show', $category->parent->id) }}"
                                       class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 ml-2">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        {{ $category->parent->name }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Details -->
            <div class="px-6 py-4">
                <dl>
                    <!-- ID -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.id') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            {{ $category->id }}
                        </dd>
                    </div>

                    <!-- Name -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.name') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            {{ $category->name }}
                        </dd>
                    </div>

                    <!-- Slug -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.slug') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            <code class="px-2 py-1 font-mono bg-gray-100 rounded dark:bg-gray-700">
                                {{ $category->slug }}
                            </code>
                        </dd>
                    </div>

                    @if(isset($category->parent))
                        <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('message.parent') }}
                            </dt>
                            <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                                <a href="{{ route('categories.show', $category->parent->id) }}"
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    {{ $category->parent->name }}
                                </a>
                            </dd>
                        </div>
                    @endif
                    @if(isset($category->order))
                        <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                ترتیب
                            </dt>
                            <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                                {{$category->order}}
                            </dd>
                        </div>
                    @endif
                    @if(isset($category->description))
                        <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('message.description') }}
                            </dt>
                            <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                                {{$category->description}}
                            </dd>
                        </div>
                    @endif
                    @if(isset($category->children) && count($category->children) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('message.children') }}
                            </dt>
                            <dd class="mt-1 md:mt-0 md:col-span-3">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($category->children as $child)
                                        <a href="{{ route('categories.show', $child->id) }}"
                                           class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-indigo-100 text-indigo-800 hover:bg-indigo-200 dark:bg-indigo-900 dark:text-indigo-200 dark:hover:bg-indigo-800">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </dd>
                        </div>
                    @endif

                    <!-- Created At -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.created_at') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            @if(config('app.locale')=='fa')
                                {{ verta()->instance($category->created_at)->format('%d %B %Y') }}
                            @else
                                {{ date('d-M-Y', strtotime($category->created_at)) }}
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex flex-wrap justify-end gap-3">
                <a href="{{ route('categories.edit', $category->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-200 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('message.edit') }}
                </a>

                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline-block"
                      id="delete-form-{{ $category->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-200 transition ease-in-out duration-150"
                            onclick="confirmDelete({{$category->id}})">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        {{ __('message.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@include('admin.partials.delete')
