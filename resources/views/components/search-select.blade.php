@props([
    'name' => 'items',
    'url' => '',
    'multiple' => false,
    'placeholder' => 'جستجو...',
    'selected' => [],
    'label' => null,
])

<div x-data="advancedSearchSelect({
        url: @js($url),
        name: @js($name),
        multiple: @js($multiple),
        placeholder: @js($placeholder),
        selected: @js($selected),
    })"
     x-init="init()"
     class="relative w-full max-w-xl">

    <!-- Label -->
    @if($label)
        <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">
            {{ $label }}
        </label>
    @endif

    <!-- Selected items (tags for multi-select) -->
    <div class="flex flex-wrap gap-2 mb-2" x-show="multiple && selectedItems.length">
        <template x-for="(item, idx) in selectedItems" :key="item.id">
            <span class="flex items-center gap-2 rounded-lg bg-indigo-100 px-2 py-1 text-sm text-indigo-700 dark:bg-indigo-700 dark:text-white">
                <img :src="item.avatar" alt="" class="h-5 w-5 rounded-full object-cover">
                <span x-text="`${item.id} - ${item.title}`"></span>
                <button @click="remove(idx)" class="ml-1 text-xs hover:text-red-600">✕</button>
            </span>
        </template>
    </div>

    <!-- Search input -->
    <div class="relative">
        <input type="text"
               x-model="query"
               @input.debounce="onInput"
               @keydown.arrow-down.prevent="focusNext()"
               @keydown.arrow-up.prevent="focusPrev()"
               @keydown.enter.prevent="selectFocused()"
               @keydown.escape="close()"
               :placeholder="placeholder"
               class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-2 text-sm placeholder-gray-400 shadow-sm outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent transition dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-500 dark:text-gray-100"
        >

        <!-- Hidden inputs -->
        <template x-if="multiple">
            <template x-for="item in selectedItems" :key="item.id">
                <input type="hidden" :name="name + '[]'" :value="item.id">
            </template>
        </template>
        <template x-if="!multiple && selectedItems.length">
            <input type="hidden" :name="name" :value="selectedItems[0].id">
        </template>

        <!-- Results dropdown -->
        <div x-show="open" x-cloak
             class="absolute z-10 mt-2 max-h-72 w-full overflow-auto rounded-lg border border-gray-200 bg-white shadow-lg ring-1 ring-black ring-opacity-5 dark:bg-gray-800 dark:border-gray-700">

            <!-- Loading -->
            <template x-if="loading">
                <div class="p-3 text-center text-sm text-gray-500 dark:text-gray-300">در حال جستجو...</div>
            </template>

            <!-- Empty -->
            <template x-if="!loading && results.length === 0">
                <div class="p-3 text-sm text-gray-600 dark:text-gray-300">نتیجه‌ای یافت نشد.</div>
            </template>

            <!-- Results -->
            <template x-for="(item, idx) in results" :key="item.id">
                <div @click="choose(item)" @mousemove="setFocus(idx)"
                     class="flex cursor-pointer items-center gap-3 px-4 py-2 text-sm hover:bg-indigo-50 dark:hover:bg-gray-700"
                     :class="{ 'bg-indigo-50 dark:bg-gray-700': focusedIndex === idx }">
                    <img :src="item.avatar" alt="" class="h-8 w-8 rounded-full object-cover">
                    <div class="flex flex-col">
                        <span class="font-medium text-gray-900 dark:text-gray-100"
                              x-text="`${item.id} - ${item.title}`"></span>
                        <span class="text-xs text-gray-500 dark:text-gray-400" x-text="item.subtitle"></span>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

@push('script')
    <script>
        function advancedSearchSelect(config) {
            return {
                query: '',
                results: [],
                selectedItems: [],
                loading: false,
                open: false,
                focusedIndex: -1,
                name: config.name,
                multiple: config.multiple,
                placeholder: config.placeholder ?? 'جستجو...',

                init() {
                    if (Array.isArray(config.selected)) {
                        this.selectedItems = config.selected;
                    } else if (config.selected && typeof config.selected === 'object') {
                        this.selectedItems = [config.selected];
                        this.query = config.selected.title;
                    }
                },

                async onInput() {
                    const q = this.query.trim();
                    if (q.length < 1) {
                        this.results = [];
                        this.open = false;
                        return;
                    }
                    this.loading = true;
                    this.open = true;
                    this.focusedIndex = -1;

                    try {
                        const url = new URL(config.url, window.location.origin);
                        url.searchParams.set('q', q);
                        const res = await fetch(url);
                        const data = await res.json();
                        this.results = Array.isArray(data) ? data : [];
                    } catch (e) {
                        console.error(e);
                        this.results = [];
                    } finally {
                        this.loading = false;
                    }
                },

                choose(item) {
                    if (this.multiple) {
                        if (!this.selectedItems.find(i => i.id === item.id)) {
                            this.selectedItems.push(item);
                        }
                        this.query = '';
                        this.results = [];
                    } else {
                        this.selectedItems = [item];
                        this.query = `${item.id} - ${item.title}`;
                        this.open = false;
                    }
                },

                remove(idx) {
                    this.selectedItems.splice(idx, 1);
                },

                setFocus(i) { this.focusedIndex = i; },
                focusNext() { if (this.results.length) this.focusedIndex = (this.focusedIndex + 1) % this.results.length; },
                focusPrev() { if (this.results.length) this.focusedIndex = (this.focusedIndex - 1 + this.results.length) % this.results.length; },
                selectFocused() { if (this.focusedIndex >= 0) this.choose(this.results[this.focusedIndex]); },
                close() { this.open = false; this.focusedIndex = -1; },
            }
        }
    </script>
@endpush
