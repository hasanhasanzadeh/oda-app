@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('permissions.index') }}"
               class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.permissions') }}
            </a>
        </div>

        <!-- Permission Detail Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                    {{ $permission->display_name }}
                    <span class="ml-2 px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded-full dark:bg-green-900 dark:text-green-200">
                    {{ $permission->name }}
                </span>
                </h2>
            </div>

            <div class="px-6 py-4">
                <dl>
                    <!-- Name -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.name') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            <code class="px-2 py-1 font-mono bg-gray-100 rounded dark:bg-gray-700">{{ $permission->name }}</code>
                        </dd>
                    </div>

                    <!-- Display Name -->
                    <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('message.display_name') }}
                        </dt>
                        <dd class="mt-1 md:mt-0 md:col-span-3 text-sm text-gray-900 dark:text-gray-200">
                            {{ $permission->display_name }}
                        </dd>
                    </div>

                    <!-- Roles with this Permission (if available) -->
                    @if(isset($permission->roles) && count($permission->roles) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-4 py-3 border-b border-gray-100 dark:border-gray-700">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('message.assigned_roles') }}
                            </dt>
                            <dd class="mt-2 md:mt-0 md:col-span-3">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($permission->roles as $role)
                                        <a href="{{ route('roles.show', $role->id) }}"
                                           class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-indigo-100 text-indigo-800 hover:bg-indigo-200 dark:bg-indigo-900 dark:text-indigo-200 dark:hover:bg-indigo-800">
                                            {{ $role->name }}
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
                            <div class="text-sm text-gray-900 dark:text-white">{{verta($permission->created_at)->format('d F Y')}}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{verta($permission->created_at)->format('h:i A')}}</div>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 flex justify-end space-x-3 rtl:space-x-reverse">
                <a href="{{ route('permissions.edit', $permission->id) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-200 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    {{ __('message.edit') }}
                </a>

                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="inline-block"
                      id="delete-form-{{ $permission->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-800 focus:ring focus:ring-red-200 transition ease-in-out duration-150"
                            onclick="confirmDelete({{$permission->id}})">
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
