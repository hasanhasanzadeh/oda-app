@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Title -->
        <div class="flex justify-between">
            <h1 class="mb-6 text-2xl font-semibold text-gray-800 dark:text-gray-100">
                {{$title}}
            </h1>

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{route('symbols.index')}}"
                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {{__('message.symbols')}}
                </a>
            </div>
        </div>

        <!-- Details Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <!-- Symbol Photo -->
            <div class="p-4 sm:p-6 flex flex-col items-center border-b border-gray-200 dark:border-gray-700">
                <div class="mb-4">
                    @if($symbol->photo)
                        <img src="{{$symbol->photo->address}}"
                             alt="{{$symbol->title}}"
                             class="h-48 w-48 object-cover rounded-lg shadow-md">
                    @else
                        <div class="h-48 w-48 flex items-center justify-center bg-gray-100 dark:bg-gray-700 rounded-lg shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                    {{$symbol->title}}
                </h2>

                <!-- Status Badge -->
                <div class="mt-2">
                    @if($symbol->status)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                            {{__('message.active')}}
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100">
                            {{__('message.inactive')}}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Details List -->
            <dl class="divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Setting -->
                <div class="px-4 py-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{__('message.setting')}}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                        {{$symbol->setting->title}}
                    </dd>
                </div>

                <!-- Description -->
                <div class="px-4 py-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{__('message.description')}}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                        {{$symbol->description}}
                    </dd>
                </div>

                <!-- URL -->
                <div class="px-4 py-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{__('message.url')}}
                    </dt>
                    <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                        <a href="{{$symbol->link}}"
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition duration-150 ease-in-out"
                           target="_blank"
                           rel="noopener noreferrer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            <span>{{$symbol->title}}</span>
                        </a>
                    </dd>
                </div>

                <!-- ID (if needed) -->
                <div class="px-4 py-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{__('message.id')}}
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                        {{$symbol->id}}
                    </dd>
                </div>
            </dl>

            <!-- Actions Footer -->
            <div class="px-4 py-4 sm:px-6 bg-gray-50 dark:bg-gray-900 flex flex-wrap gap-2 justify-end">
                <a href="{{route('symbols.edit', $symbol->id)}}"
                   class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{__('message.edit')}}
                </a>
                <form action="{{ route('symbols.destroy', $symbol->id) }}" method="POST" class="inline-block"
                      id="delete-form-{{ $symbol->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-200 transition ease-in-out duration-150"
                            onclick="confirmDelete({{$symbol->id}})">
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
