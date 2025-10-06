@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('customers.index') }}"
               class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.customers') }}
            </a>
        </div>

        <!-- User Profile Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md mb-6">
            <div class="p-6 flex flex-col sm:flex-row items-center sm:items-start gap-4">
                <div class="flex-shrink-0">
                    @if($customer->avatar)
                        <img src="{{ $customer->avatar->address }}" alt="{{ $customer->first_name }}"
                             class="h-24 w-24 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-sm">
                    @else
                        <div class="h-24 w-24 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center border-4 border-white dark:border-gray-700 shadow-sm">
                            <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col items-center sm:items-start">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                        {{ $customer->fullNameWithGender }}
                    </h2>

                    <div class="mt-1 text-sm text-gray-500 dark:text-gray-400 flex flex-col sm:flex-row sm:gap-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span dir="ltr">{{ $customer->mobile }}</span>
                        </div>

                        <div class="flex items-center mt-1 sm:mt-0">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span dir="ltr">{{ $customer->email }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Roles Management Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('message.roles') }}
                    </h2>
                </div>

                <!-- Current Roles -->
                <div class="px-6 py-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">
                        {{ __('message.current_roles') }}
                    </h3>

                    @if($customer->roles && $customer->roles->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($customer->roles as $customer_role)
                                <form method="POST"
                                      action="{{ route('users.roles.remove', [$customer->id, $customer_role->id]) }}"
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('{{ __('message.confirm_remove_role') }}')"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full text-sm font-medium hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors">
                                        {{ $customer_role->name }}
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('message.no_roles_assigned') }}
                        </p>
                    @endif
                </div>

                <!-- Assign New Role -->
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4">
                    <form method="POST" action="{{ route('users.roles', $customer->id) }}">
                        @csrf
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('message.assign_new_role') }}
                            </label>
                            <div class="flex" dir="ltr">
                                <select
                                        id="role"
                                        name="role"
                                        class="flex-grow rounded-l-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                >
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                                    {{ __('message.assign') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Permissions Management Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                        {{ __('message.permissions') }}
                    </h2>
                </div>

                <!-- Current Permissions -->
                <div class="px-6 py-4">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">
                        {{ __('message.current_permissions') }}
                    </h3>

                    @if($customer->permissions && $customer->permissions->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($customer->permissions as $customer_permission)
                                <form method="POST"
                                      action="{{ route('users.permissions.revoke', [$customer->id, $customer_permission->id]) }}"
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('{{ __('message.confirm_revoke_permission') }}')"
                                            class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full text-sm font-medium hover:bg-green-200 dark:hover:bg-green-800 transition-colors">
                                        {{ $customer_permission->name }}
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ __('message.no_permissions_assigned') }}
                        </p>
                    @endif
                </div>

                <!-- Assign New Permission -->
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4">
                    <form method="POST" action="{{ route('users.permissions', $customer->id) }}">
                        @csrf
                        <div>
                            <label for="permission"
                                   class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('message.assign_new_permission') }}
                            </label>
                            <div class="flex" dir="ltr">
                                <select
                                        id="permission"
                                        name="permission"
                                        class="flex-grow rounded-l-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                >
                                    @foreach($permissions as $permission)
                                        <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-r-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-800 focus:ring focus:ring-green-300 dark:focus:ring-green-800 transition ease-in-out duration-150">
                                    {{ __('message.assign') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6 flex justify-end space-x-3 rtl:space-x-reverse">
            <a href="{{ route('customers.edit', $customer->id) }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-200 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                {{ __('message.edit') }}
            </a>

            <a href="{{ route('customers.show', $customer->id) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring focus:ring-gray-200 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                {{ __('message.view_details') }}
            </a>
        </div>
    </div>
@endsection
