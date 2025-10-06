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

        <!-- Blog Detail Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <!-- Blog Header with Featured Image -->
            <div class="relative">
                @if($service->photo != null)
                    <div class="w-full overflow-hidden bg-gray-300 dark:bg-gray-700">
                        <img
                                src="{{ $service->photo->address }}"
                                alt="{{ $service->title }}"
                                class="w-full object-cover mx-auto max-h-[50vh] sm:max-h-[60vh]"
                        >
                    </div>
                @endif

                <div class="p-6 {{ $service->photo ? 'bg-gradient-to-t from-black/60 to-transparent absolute bottom-0 left-0 right-0 text-white' : 'bg-gray-50 dark:bg-gray-750 border-b border-gray-200 dark:border-gray-700' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                            <span class="{{ $service->status == 1 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }} text-xs font-semibold px-2.5 py-0.5 rounded">
                                {{ $service->status == 1 ? __('message.active') : __('message.inactive') }}
                            </span>
                                <span class="text-xs {{ $service->photo ? 'text-gray-200' : 'text-gray-500 dark:text-gray-400' }}">
                                ID: {{ $service->id }}
                            </span>
                            </div>
                            <h2 class="text-xl font-bold {{ $service->photo ? 'text-white' : 'text-gray-800 dark:text-gray-200' }}">
                                {{ $service->title }}
                            </h2>
                        </div>
                        <div class="hidden md:block">
                            @if(config('app.locale')=='fa')
                                <span class="text-sm {{ $service->photo ? 'text-gray-200' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ verta()->instance($service->created_at)->format('%d %B %Y') }}
                            </span>
                            @else
                                <span class="text-sm {{ $service->photo ? 'text-gray-200' : 'text-gray-500 dark:text-gray-400' }}">
                                {{ date('d F Y', strtotime($service->created_at)) }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                    {{ __('message.description') }}
                </h3>
                <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                    {!! $service->description !!}
                </div>
            </div>

            <!-- Mobile Date (visible on small screens) -->
            <div class="md:hidden px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-center">
                <div class="text-sm text-gray-900 dark:text-white">{{verta($service->created_at)->format('d F Y')}}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{verta($service->created_at)->format('h:i A')}}</div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end space-x-3 rtl:space-x-reverse">
                <a href="{{ route('services.edit', $service->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-200 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('message.edit') }}
                </a>

                <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline-block"
                      id="delete-form-{{ $service->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-200 transition ease-in-out duration-150"
                            onclick="confirmDelete({{$service->id}})">
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
