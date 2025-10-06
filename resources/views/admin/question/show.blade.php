@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ $title }}
            </h1>
            <a href="{{ route('questions.index') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 rtl:ml-2 rtl:mr-0" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                {{ __('message.questions') }}
            </a>
        </div>

        <!-- Qaq Detail Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8 border border-gray-200 dark:border-gray-700">
            <!-- Qaq Header -->
            <div class="px-6 pt-6 pb-4">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <!-- Qaq Title and Metadata -->
                    <div class="space-y-3">
                        <div class="flex flex-wrap items-center gap-2 rtl:space-x-reverse">
                            <!-- Status Badge -->
                            <span class="{{ $question->status == 1
                                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100'
                                : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-100' }}
                                inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                <span class="w-2 h-2 mr-1 rtl:ml-1 rtl:mr-0 rounded-full {{ $question->status == 1 ? 'bg-green-600 dark:bg-green-400' : 'bg-red-600 dark:bg-red-400' }}"></span>
                                {{ $question->status == 1 ? __('message.active') : __('message.inactive') }}
                            </span>

                            <!-- ID Badge -->
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                ID: {{ $question->id }}
                            </span>
                        </div>

                        <!-- Qaq Title -->
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">
                            {{ $question->title }}
                        </h2>
                    </div>

                    <!-- Date (Desktop) -->
                    <div class="hidden sm:block text-right rtl:text-left flex-shrink-0">
                        @if(config('app.locale')=='fa')
                            <time datetime="{{ $question->created_at }}"
                                  class="text-sm text-gray-500 dark:text-gray-400">
                                {{ verta()->instance($question->created_at)->format('%d %B %Y') }}
                            </time>
                        @else
                            <time datetime="{{ $question->created_at }}"
                                  class="text-sm text-gray-500 dark:text-gray-400">
                                {{ date('d F Y', strtotime($question->created_at)) }}
                            </time>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Qaq Content -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-3">
                    {{ __('message.description') }}
                </h3>
                <div class="prose prose-sm sm:prose max-w-none dark:prose-invert text-gray-700 dark:text-gray-300">
                    {!! $question->description !!}
                </div>
            </div>

            <!-- Date (Mobile) -->
            <div class="sm:hidden px-6 py-3 border-t border-gray-200 dark:border-gray-700 flex justify-center">
                @if(config('app.locale')=='fa')
                    <div class="text-center">
                        <time datetime="{{ $question->created_at }}"
                              class="block text-sm font-medium text-gray-900 dark:text-white">
                            {{ verta($question->created_at)->format('d F Y') }}
                        </time>
                        <time datetime="{{ $question->created_at }}"
                              class="block text-xs text-gray-500 dark:text-gray-400">
                            {{ verta($question->created_at)->format('h:i A') }}
                        </time>
                    </div>
                @else
                    <div class="text-center">
                        <time datetime="{{ $question->created_at }}"
                              class="block text-sm font-medium text-gray-900 dark:text-white">
                            {{ date('d F Y', strtotime($question->created_at)) }}
                        </time>
                        <time datetime="{{ $question->created_at }}"
                              class="block text-xs text-gray-500 dark:text-gray-400">
                            {{ date('h:i A', strtotime($question->created_at)) }}
                        </time>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 flex flex-wrap justify-end gap-3 rtl:space-x-reverse">
                <!-- Edit Button -->
                <a href="{{ route('questions.edit', $question->id) }}"
                   class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('message.edit') }}
                </a>

                <!-- Delete Button -->
                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" class="inline-block"
                      id="delete-form-{{ $question->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 transition duration-150 ease-in-out shadow-sm"
                            onclick="confirmDelete({{ $question->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 rtl:ml-2 rtl:mr-0" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ __('message.delete') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@include('admin.partials.delete')
