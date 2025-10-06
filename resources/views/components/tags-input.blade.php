@props([
    'tags' => [],
    'options' => [],
    'label' => null,
    'required' => false,
    'placeholder' => 'Add a tag...',
])

<div
        x-data="tagsInput({
        tags: @js($tags),
        options: @js($options)
    })"
        x-init="init()"
        class="space-y-2"
>
    @if($label)
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)<span class="text-red-500">*</span>@endif
        </label>
    @endif

    <div
            x-show="showOptions && filteredOptions.length > 0"
            x-transition
            class="mb-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg z-10"
            x-cloak
    >
        <div class="p-3 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
            <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">SUGGESTED TAGS</span>
        </div>
        <div class="max-h-48 overflow-y-auto">
            <template x-for="(option, index) in filteredOptions" :key="index">
                <button
                        type="button"
                        @click="selectOption(option)"
                        @mouseenter="highlightedIndex = index"
                        :class="{
                        'bg-blue-500 text-white dark:bg-blue-600': highlightedIndex === index,
                        'hover:bg-gray-50 dark:hover:bg-gray-700': highlightedIndex !== index,
                        'text-gray-900 dark:text-white': highlightedIndex !== index
                    }"
                        class="w-full text-left px-4 py-3 border-b border-gray-100 dark:border-gray-700 last:border-b-0 transition-colors duration-150 flex items-center justify-between"
                >
                    <span x-text="option" class="font-medium"></span>
                    <svg x-show="tags.includes(option)" class="w-4 h-4 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </template>
        </div>
    </div>

    <div
            class="border border-gray-300 dark:border-gray-600 rounded-lg focus-within:border-blue-500 dark:focus-within:border-blue-400 focus-within:ring-2 focus-within:ring-blue-200 dark:focus-within:ring-blue-800 transition-all duration-200 bg-white dark:bg-gray-800 min-h-[50px]"
            @click="$refs.input.focus()"
    >
        <div class="flex flex-wrap items-center gap-2 p-3">
            <!-- Tags Display -->
            <template x-for="(tag, index) in tags" :key="index">
                <div class="inline-flex items-center bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1.5 rounded-full text-sm font-medium border border-blue-200 dark:border-blue-700 shadow-sm">
                    <span x-text="tag"></span>
                    <button
                            type="button"
                            @click="removeTag(index)"
                            class="ml-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 focus:outline-none transition-colors duration-200"
                            aria-label="Remove tag"
                    >
                        ×
                    </button>
                </div>
            </template>

            <input
                    x-ref="input"
                    x-model="inputValue"
                    @keydown="handleKeydown"
                    @input="filterOptions"
                    @focus="showOptions = true"
                    @blur="handleBlur"
                    :placeholder="tags.length === 0 ? '{{ $placeholder }}' : 'Add another tag...'"
                    class="flex-1 min-w-[120px] border-0 focus:ring-0 focus:outline-none py-1 text-sm placeholder-gray-400 dark:placeholder-gray-500 bg-transparent text-gray-900 dark:text-white"
                    autocomplete="off"
                    spellcheck="false"
            >
        </div>

        <template x-for="(tag, index) in tags" :key="'hidden-' + index">
            <input type="hidden" name="{{ $name }}[]" :value="tag" />
        </template>
    </div>

    <script>
        function tagsInput(config) {
            return {
                tags: config.tags || [],
                inputValue: '',
                options: config.options || [],
                filteredOptions: [],
                showOptions: false,
                highlightedIndex: 0,
                blurTimeout: null,

                init() {
                    this.filterOptions();

                    // Watch for tags changes
                    this.$watch('tags', (value) => {
                        this.$dispatch('tags-changed', value);
                    });
                },

                handleKeydown(event) {
                    switch (event.key) {
                        case 'Enter':
                            event.preventDefault();
                            if (this.filteredOptions.length > 0 && this.highlightedIndex >= 0) {
                                this.selectOption(this.filteredOptions[this.highlightedIndex]);
                            } else {
                                this.addTag();
                            }
                            break;

                        case 'Tab':
                            event.preventDefault();
                            if (this.filteredOptions.length > 0 && this.highlightedIndex >= 0) {
                                this.selectOption(this.filteredOptions[this.highlightedIndex]);
                            } else {
                                this.addTag();
                            }
                            break;

                        case ',':
                            event.preventDefault();
                            this.addTag();
                            break;

                        case 'Backspace':
                            if (this.inputValue === '' && this.tags.length > 0) {
                                this.removeTag(this.tags.length - 1);
                            }
                            break;

                        case 'ArrowDown':
                            event.preventDefault();
                            this.highlightNext();
                            break;

                        case 'ArrowUp':
                            event.preventDefault();
                            this.highlightPrev();
                            break;

                        case 'Escape':
                            this.showOptions = false;
                            break;
                    }
                },

                handleBlur() {
                    this.blurTimeout = setTimeout(() => {
                        this.showOptions = false;
                        // Don't add tag on blur to avoid accidental additions
                    }, 150);
                },

                addTag() {
                    const tag = this.inputValue.trim();

                    if (tag && !this.tags.includes(tag)) {
                        this.tags.push(tag);
                        this.inputValue = '';
                        this.showOptions = false;
                        this.filterOptions();
                        this.$dispatch('tag-added', tag);
                    }
                },

                removeTag(index) {
                    const removedTag = this.tags[index];
                    this.tags.splice(index, 1);
                    this.filterOptions();
                    this.$dispatch('tag-removed', removedTag);
                },

                selectOption(option) {
                    if (!this.tags.includes(option)) {
                        this.tags.push(option);
                        this.inputValue = '';
                        this.showOptions = false;
                        this.filterOptions();
                        this.$dispatch('option-selected', option);
                    }
                },

                filterOptions() {
                    const input = this.inputValue.toLowerCase().trim();

                    if (!input) {
                        // Show all options not already in tags
                        this.filteredOptions = this.options.filter(option =>
                            !this.tags.includes(option)
                        );
                    } else {
                        // Filter options by input and exclude already added tags
                        this.filteredOptions = this.options.filter(option =>
                            option.toLowerCase().includes(input) &&
                            !this.tags.includes(option)
                        );
                    }

                    // Reset highlight
                    this.highlightedIndex = 0;
                },

                highlightNext() {
                    if (this.highlightedIndex < this.filteredOptions.length - 1) {
                        this.highlightedIndex++;
                    }
                },

                highlightPrev() {
                    if (this.highlightedIndex > 0) {
                        this.highlightedIndex--;
                    }
                },

                // Public method to add multiple tags at once
                addMultipleTags(newTags) {
                    newTags.forEach(tag => {
                        if (tag && !this.tags.includes(tag)) {
                            this.tags.push(tag);
                        }
                    });
                    this.filterOptions();
                },

                // Public method to clear all tags
                clearAllTags() {
                    this.tags = [];
                    this.filterOptions();
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }

        /* Custom scrollbar for dark mode */
        .dark .max-h-48::-webkit-scrollbar {
            width: 6px;
        }

        .dark .max-h-48::-webkit-scrollbar-track {
            background: #374151;
            border-radius: 3px;
        }

        .dark .max-h-48::-webkit-scrollbar-thumb {
            background: #6b7280;
            border-radius: 3px;
        }

        .dark .max-h-48::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
</div>