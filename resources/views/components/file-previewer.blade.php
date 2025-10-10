@props([
    'label' => 'بارگذاری فایل',
    'name' => 'files',
    'accept' => 'image/*,video/*,.pdf,.doc,.docx',
    'multiple' => false,
    'lang' => 'fa',
    'maxSize' => null,
    'maxWidth' => null,
    'maxHeight' => null,
    'existingUrl' => null,
    'existingType' => null,
    'existingFiles' => [],
])

@php
    use Illuminate\Support\Str;

    // Text translations
    $texts = [
        'fa' => [
            'label' => "بارگذاری $label",
            'drag' => "$label را بکشید یا کلیک کنید برای انتخاب",
            'remove' => 'حذف',
            'document' => "$label انتخاب‌شده",
            'sizeError' => "حجم فایل بیشتر از " . round(($maxSize ?? 0) / 1024, 1) . " مگابایت است",
            'dimensionError' => "ابعاد فایل بیش از حد مجاز است",
        ],
        'en' => [
            'label' => $label,
            'drag' => 'Drag & drop or click to select file(s)',
            'remove' => 'Remove',
            'document' => 'Selected document',
            'sizeError' => 'File exceeds maximum size',
            'dimensionError' => 'File dimensions exceed allowed size',
        ],
    ];
    $t = $texts[$lang] ?? $texts['fa'];

    // Normalize existing files (object or array safe)
    $initialFiles = collect($existingFiles)->map(function ($item) {
        $address = is_array($item) ? ($item['address'] ?? null) : ($item->address ?? null);
        $type = is_array($item) ? ($item['type'] ?? 'image') : ($item->type ?? 'image');
        $name = is_array($item) ? ($item['name'] ?? basename($address ?? '')) : ($item->name ?? basename($address ?? ''));
        $url = $address;
        return [
            'name' => $name,
            'url' => $url,
            'type' => $type,
            'existing' => true,
            'path' => $address,
        ];
    })->values()->toArray();

    // If single existing file
    if ($existingUrl && !$multiple && empty($initialFiles)) {
        $initialFiles[] = [
            'name' => basename($existingUrl),
            'url' =>$existingUrl ,
            'type' => $existingType ?? 'image',
            'existing' => true,
            'path' => $existingUrl,
        ];
    }
@endphp

<div
    x-data="fileDropzone({
        multiple: {{ $multiple ? 'true' : 'false' }},
        initialFiles: @js($initialFiles),
        name: '{{ $name }}',
        maxSize: {{ $maxSize ?? 'null' }},
        maxWidth: {{ $maxWidth ?? 'null' }},
        maxHeight: {{ $maxHeight ?? 'null' }},
        texts: @js($t)
    })"
    x-on:dragover.prevent
    x-on:drop.prevent="handleDrop($event)"
    class="w-full max-w-xl mx-auto border-2 border-dashed rounded-lg p-6 border-gray-300 bg-white dark:bg-gray-900"
>
    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
        {{ $t['label'] }}
    </label>

    <div class="flex flex-col items-center justify-center text-center space-y-2 cursor-pointer" @click="$refs.input.click()">
        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v9m0-9l-3 3m3-3l3 3M12 3v9"/>
        </svg>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $t['drag'] }}</p>
    </div>

    <input
        type="file"
        name="{{ $multiple ? $name . '[]' : $name }}"
        accept="{{ $accept }}"
        x-ref="input"
        @change="previewFiles($event)"
        class="hidden"
        {{ $multiple ? 'multiple' : '' }}
    />

    <!-- Hidden inputs for existing files (so form submits them if unchanged) -->
    <template x-for="(file, index) in files" :key="index">
        <template x-if="file.existing">
            <input type="hidden" :name="`${name}_existing[]`" :value="file.path">
        </template>
    </template>

    <!-- Preview -->
    <template x-for="(file, index) in files" :key="'preview-' + index">
        <div class="relative mt-4">
            <template x-if="file.type === 'image'">
                <img :src="file.url" class="rounded shadow-md max-h-64 mx-auto" />
            </template>

            <template x-if="file.type === 'video'">
                <video :src="file.url" controls class="rounded shadow-md max-h-64 w-full"></video>
            </template>

            <template x-if="file.type === 'document'">
                <div class="p-4 bg-gray-100 rounded shadow-md text-center">
                    <p class="text-sm text-gray-800">{{ $t['document'] }}: <strong x-text="file.name"></strong></p>
                </div>
            </template>

            <button
                type="button"
                @click="removeFile(index)"
                class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">
                {{ $t['remove'] }}
            </button>
        </div>
    </template>
</div>

<script>
    function fileDropzone(config) {
        return {
            files: config.initialFiles || [],
            multiple: config.multiple,
            name: config.name,
            maxSize: config.maxSize,
            maxWidth: config.maxWidth,
            maxHeight: config.maxHeight,
            texts: config.texts,

            previewFiles(event) {
                const selected = Array.from(event.target.files);
                this.processFiles(selected);
            },

            handleDrop(event) {
                const dropped = Array.from(event.dataTransfer.files);
                this.processFiles(dropped);
            },

            processFiles(fileList) {
                if (!fileList.length) return;
                if (!this.multiple) this.files = this.files.filter(f => f.existing);

                fileList.forEach(file => {
                    if (this.maxSize && file.size / 1024 > this.maxSize) {
                        alert(this.texts.sizeError);
                        return;
                    }

                    const type = file.type.startsWith('image/') ? 'image'
                        : file.type.startsWith('video/') ? 'video'
                            : 'document';

                    if (type === 'image') {
                        const img = new Image();
                        img.onload = () => {
                            if ((this.maxWidth && img.width > this.maxWidth) || (this.maxHeight && img.height > this.maxHeight)) {
                                alert(this.texts.dimensionError);
                                return;
                            }
                            this.files.push({ name: file.name, url: URL.createObjectURL(file), type, raw: file });
                        };
                        img.src = URL.createObjectURL(file);
                    } else {
                        this.files.push({ name: file.name, url: URL.createObjectURL(file), type, raw: file });
                    }
                });
            },

            removeFile(index) {
                this.files.splice(index, 1);
                this.$refs.input.value = '';
            }
        };
    }
</script>
