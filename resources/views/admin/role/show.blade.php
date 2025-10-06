@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('roles.index') }}"
               class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.roles') }}
            </a>
        </div>

        <!-- Role Detail Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                    {{ $role->display_name }}
                    |
                    <span class="mx-2 px-2.5 py-0.5 text-xs font-medium bg-gray-100 text-gray-800 rounded-full dark:bg-gray-700 dark:text-gray-300">
                    {{ $role->name }}
                </span>
                </h2>
            </div>

            <div class="px-6 py-4">
                <dl>
                    <!-- ID/Name -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.title') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            {{ $role->name }}
                        </dd>
                    </div>

                    <!-- Display Name -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.display_name') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            {{ $role->display_name }}
                        </dd>
                    </div>

                    <!-- Permissions -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.permissions') }}
                        </dt>
                        <dd class="mt-2 md:mt-0 md:col-span-3">
                            <div class="flex flex-wrap gap-2">
                                @if ($role->permissions && count($role->permissions) > 0)
                                    @foreach ($role->permissions as $role_permission)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $role_permission->name }}
                                    </span>
                                    @endforeach
                                @else
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('message.no_permissions') }}</span>
                                @endif
                            </div>
                        </dd>
                    </div>

                    <!-- Created At -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.created_at') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            <div class="text-sm text-gray-900 dark:text-white">{{verta($role->created_at)->format('d F Y')}}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{verta($role->created_at)->format('h:i A')}}</div>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end space-x-3 rtl:space-x-reverse">
                <a href="{{ route('roles.edit', $role->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 active:bg-purple-800 focus:outline-none focus:border-purple-800 focus:ring focus:ring-purple-200 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    {{ __('message.manage_permissions') }}
                </a>
                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline-block"
                      id="delete-form-{{ $role->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-200 transition ease-in-out duration-150"
                            onclick="confirmDelete({{$role->id}})">
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
