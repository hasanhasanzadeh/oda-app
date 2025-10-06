@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('contacts.index') }}"
               class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.contacts') }}
            </a>
        </div>

        <!-- Contact Detail Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <!-- Status Banner -->
            <div class="w-full px-6 py-3 {{ $contact->read ? 'bg-green-50 dark:bg-green-800' : 'bg-red-50 dark:bg-red-800' }}">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if($contact->read)
                            <svg class="h-5 w-5 text-green-600 dark:text-green-400" fill="currentColor"
                                 viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        @else
                            <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium {{ $contact->read ? 'text-green-800 dark:text-green-200' : 'text-red-800 dark:text-red-200' }}">
                            {{ $contact->read ? __('message.read_message') : __('message.unread_message') }}
                        </h3>
                        <div class="mt-1 text-sm {{ $contact->read ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">
                            {{ __('message.contact_id') }}: {{ $contact->id }}
                        </div>
                    </div>

                    @if(!$contact->read)
                        <div class="ml-auto">
                            <form action="{{ route('contacts.markAsRead', $contact->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800">
                                    {{ __('message.mark_as_read') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="border-b border-gray-200 dark:border-gray-700">
                <dl>
                    <!-- Sender Information Section -->
                    <div class="bg-gray-50 dark:bg-gray-800 px-6 py-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">
                            <!-- Full Name -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('message.full_name') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-800 dark:text-white">
                                        {{ $contact->full_name }}
                                    </dd>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('message.email') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-800 dark:text-white" dir="ltr">
                                        <a href="mailto:{{ $contact->email }}"
                                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                            {{ $contact->email }}
                                        </a>
                                    </dd>
                                </div>
                            </div>

                            <!-- Mobile -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('message.mobile') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-800 dark:text-white" dir="ltr">
                                        @if($contact->mobile)
                                            <a href="tel:{{ $contact->mobile }}"
                                               class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                {{ $contact->mobile }}
                                            </a>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">-</span>
                                        @endif
                                    </dd>
                                </div>
                            </div>

                            <!-- Date Received -->
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        {{ __('message.created_at') }}
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-800 dark:text-white">
                                        <div class="text-sm text-gray-800 dark:text-white">{{verta($contact->created_at)->format('d F Y')}}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{verta($contact->created_at)->format('h:i A')}}</div>
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="px-6 py-5">
                        <!-- Subject -->
                        <div class="mb-4">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('message.subject') }}
                            </dt>
                            <dd class="mt-1 text-base font-semibold text-gray-800 dark:text-white">
                                {{ $contact->subject }}
                            </dd>
                        </div>

                        <!-- Message -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                                {{ __('message.message') }}
                            </dt>
                            <dd class="mt-1 prose dark:prose-invert max-w-none text-gray-800 dark:text-gray-200 text-sm">
                                {!! $contact->message !!}
                            </dd>
                        </div>
                    </div>

                    <!-- Technical Information -->
                    <div class="bg-gray-50 dark:bg-gray-800 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                            <div>
                                {{ __('message.ip_address') }}: {{ $contact->ip_address }}
                            </div>
                            <div>
                                {{ __('message.contact_id') }}: {{ $contact->id }}
                            </div>
                        </div>
                    </div>
                </dl>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 flex justify-end space-x-3 rtl:space-x-reverse">
                <a href="tel:{{ $contact->mobile }}" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-200 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    {{ __('message.replay') }}
                </a>

                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-200 transition ease-in-out duration-150"
                            onclick="confirmDelete({{$contact->id}})">
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
