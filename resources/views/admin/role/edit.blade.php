@extends('admin.layouts.master')

@section('content')
    <div class="bg-white my-6 border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <div class="flex items-start justify-between p-6 border-b lg:flex-row lg:items-center dark:border-gray-700">
            <div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">ویرایش نقش</h2>
            </div>
            <div>
                <a href="{{route('roles.index')}}"
                   class="flex items-center px-3 py-2 text-sm text-blue-600 bg-blue-100 rounded-lg dark:bg-blue-700 dark:text-blue-300">
                    <i class="ml-2 fas fa-list"></i>
                    <span>
                        نقش ها
                    </span>
                </a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <div class="w-full">
                <div class="space-y-8 divide-y divide-gray-200 mt-10 gap-3">
                    <form method="POST" action="{{ route('roles.update', $role->id) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" value="{{$role->id}}">
                        <div class="grid grid-cols-1 md:grid-cols-2">
                            <div class="m-4 ">
                                <label class="block text-sm font-medium mb-1 dark:text-gray-200"
                                       for="name"> {{__('message.name')}}</label>
                                <input type="text" id="name" name="name" value="{{$role->name}}"
                                       class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:placeholder-gray-400 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                                       placeholder="{{__('message.name')}}"/>
                            </div>
                            <div class="m-4">
                                <label class="block text-sm font-medium mb-1 dark:text-gray-200"
                                       for="display_name">{{__('message.display_name')}}</label>
                                <input type="text" id="display_name" name="display_name" value="{{$role->display_name}}"
                                       class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200 dark:placeholder-gray-400 dark:focus:ring-blue-400 dark:focus:border-blue-400"
                                       placeholder="{{__('message.display_name')}}">
                            </div>
                            <div class="m-4 p-4">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">@lang('message.store')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 border-t">
            <div class="w-full mt-6 p-2 bg-gray-100 dark:bg-gray-800 dark:text-gray-500">
                <h2 class="text-xl font-semibold">{{__('message.role').' '.__('message.permission')}}</h2>
                <div class="w-full mt-4 p-2 flex flex-wrap text-justify text-medium justify-content-center">
                    @if ($role->permissions)
                        @foreach ($role->permissions as $role_permission)
                            <div class="px-2 m-2 text-justify">
                                <form class=" py-2 text-white rounded-md" method="POST"
                                      action="{{ route('roles.permissions.revoke', [$role->id, $role_permission->id]) }}"
                                      onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class=" bg-blue-500 hover:bg-blue-700 mx-auto text-white font-bold py-2 px-4 rounded">{{ $role_permission->name }}</button>
                                </form>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="w-full px-3 my-3">
                    <form method="POST" action="{{ route('roles.permissions', $role->id) }}">
                        @csrf
                        <div class="w-full my-3">
                            <label for="permission-select"
                                   class="block text-sm font-medium dark:text-gray-50 text-gray-700 mb-1">
                                {{__('message.permission')}}
                            </label>

                            <!-- Custom Multi-Select Container -->
                            <div class="relative w-full" x-data="multiSelect()" x-init="init()">
                                <!-- Selected Display Button -->
                                <button
                                        type="button"
                                        @click="open = !open"
                                        class="flex justify-between items-center w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                                >
                                    <span x-text="selectedCount + ' {{__('message.items_selected')}}'"></span>
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                         :class="{'transform rotate-180': open}" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <!-- Dropdown Container -->
                                <div
                                        x-show="open"
                                        @click.away="open = false"
                                        class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 max-h-60 overflow-y-auto"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                >
                                    <!-- Search Box -->
                                    <div class="sticky top-0 p-2 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                                        <input
                                                type="text"
                                                x-model="search"
                                                placeholder="{{__('message.search')}}"
                                                class="w-full px-3 py-1.5 text-gray-700 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
                                        >
                                    </div>

                                    <!-- Options List -->
                                    <div class="p-2">
                                        <template x-for="permission in filteredOptions" :key="permission.value">
                                            <div class="flex items-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                                                <input
                                                        type="checkbox"
                                                        :id="'permission-' + permission.value"
                                                        :value="permission.value"
                                                        x-model="selected"
                                                        class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-400 dark:bg-gray-900"
                                                        @change="updateSelection()"
                                                >
                                                <label :for="'permission-' + permission.value"
                                                       class="mr-2 text-sm text-gray-700 dark:text-gray-200 cursor-pointer"
                                                       x-text="permission.text"></label>
                                            </div>
                                        </template>

                                        <!-- Empty Results Message -->
                                        <div x-show="filteredOptions.length === 0"
                                             class="p-2 text-center text-gray-500 dark:text-gray-400">
                                            {{__('message.no_results')}}
                                        </div>
                                    </div>

                                    <!-- Actions Buttons -->
                                    <div class="p-2 border-t border-gray-200 dark:border-gray-700 flex justify-between">
                                        <button
                                                type="button"
                                                @click="selectAll()"
                                                class="px-3 py-1 text-xs text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-offset-gray-800"
                                        >
                                            {{__('message.select_all')}}
                                        </button>
                                        <button
                                                type="button"
                                                @click="deselectAll()"
                                                class="px-3 py-1 text-xs text-white bg-gray-600 rounded hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-offset-gray-800"
                                        >
                                            {{__('message.deselect_all')}}
                                        </button>
                                    </div>
                                </div>

                                <!-- Hidden Original Select (for form submission) -->
                                <select id="permission" name="permission[]" multiple class="hidden">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}"
                                                :selected="selected.includes('{{ $permission->name }}')"
                                                @if(in_array($permission->name, $role->permissions->pluck('name')->toArray(), true)) selected @endif>
                                            {{ $permission->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Selected Tags Display (Optional) -->
                            <div class="mt-2 flex flex-wrap gap-2">
                                <template x-data="{ selectedItems: [] }"
                                          x-init="selectedItems = Array.from(document.querySelectorAll('option[selected]')).map(el => el.value)">
                                    <template x-for="item in selectedItems" :key="item">
                                        <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                            <span x-text="item"></span>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </div>

                        <div class="w-full px-3 my-3">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                @lang('message.assign')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function multiSelect() {
            return {
                open: false,
                search: '',
                selected: [],
                options: [],
                selectedCount: 0,

                init() {
                    // Initialize options from the select element
                    const selectEl = document.getElementById('permission');
                    this.options = Array.from(selectEl.options).map(option => ({
                        value: option.value,
                        text: option.text,
                        selected: option.selected
                    }));

                    // Initialize selected values
                    this.selected = this.options
                        .filter(option => option.selected)
                        .map(option => option.value);

                    this.selectedCount = this.selected.length;

                    // Sync with the hidden select
                    this.updateHiddenSelect();
                },

                get filteredOptions() {
                    return this.options.filter(option =>
                        option.text.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                updateSelection() {
                    this.selectedCount = this.selected.length;
                    this.updateHiddenSelect();
                },

                updateHiddenSelect() {
                    const selectEl = document.getElementById('permission');
                    Array.from(selectEl.options).forEach(option => {
                        option.selected = this.selected.includes(option.value);
                    });
                },

                selectAll() {
                    this.selected = this.filteredOptions.map(option => option.value);
                    this.updateSelection();
                },

                deselectAll() {
                    this.selected = this.selected.filter(
                        value => !this.filteredOptions.some(option => option.value === value)
                    );
                    this.updateSelection();
                }
            };
        }
    </script>
@endsection
