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
])

@php
    $texts = [
        'en' => [
            'label' => $label,
            'drag' => 'Drag & drop or click to select file(s)',
            'remove' => 'Remove',
            'document' => 'Document',
            'sizeError' => 'File exceeds maximum size of ' . round(($maxSize ?? 0) / 1024, 1) . ' MB',
            'dimensionError' => 'File dimensions exceed allowed size of ' . ($maxWidth ?? '-') . 'x' . ($maxHeight ?? '-') . ' px',
        ],
        'fa' => [
            'label' => "بارگذاری $label",
            'drag' => "$label را بکشید یا کلیک کنید برای انتخاب",
            'remove' => 'حذف',
            'document' => "$label انتخاب‌شده",
            'sizeError' => "حجم $label بیشتر از " . round(($maxSize ?? 0) / 1024, 1) . ' مگابایت است',
            'dimensionError' => "ابعاد $label بیشتر از " . ($maxWidth ?? '-') . 'x' . ($maxHeight ?? '-') . ' پیکسل است',
        ],
    ];
    $t = $texts[$lang] ?? $texts['fa'];
@endphp

<div
        x-data="fileDropzone({{ $multiple ? 'true' : 'false' }}, '{{ $existingUrl }}', '{{ $existingType }}')"
        x-on:dragover.prevent
        x-on:drop.prevent="handleDrop($event)"
        class="w-full max-w-xl mx-auto border-2 border-dashed rounded-lg p-6
           border-gray-300 dark:border-gray-600
           bg-white dark:bg-gray-900 transition duration-300 ease-in-out"
>
    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
        {{ $t['label'] }}
    </label>

    <div class="flex flex-col items-center justify-center text-center space-y-2 cursor-pointer"
         @click="$refs.input.click()">
        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v9m0-9l-3 3m3-3l3 3M12 3v9"/>
        </svg>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ $t['drag'] }}
        </p>
    </div>

    <input
            type="file"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            accept="{{ $accept }}"
            x-ref="input"
            @change="previewFiles($event)"
            class="hidden"
            {{ $multiple ? 'multiple' : '' }}
    />

    <template x-for="(file, index) in files" :key="index">
        <div class="relative mt-4">
            <template x-if="file.type === 'image'">
                <img :src="file.url" class="rounded shadow-md max-h-64 mx-auto" />
            </template>
            <template x-if="file.type === 'video'">
                <video :src="file.url" controls class="rounded shadow-md max-h-64 w-full"></video>
            </template>
            <template x-if="file.type === 'document'">
                <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded shadow-md text-center">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        {{ $t['document'] }}: <strong x-text="file.name"></strong>
                    </p>
                </div>
            </template>
            <button @click="removeFile(index)"
                    class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">
                {{ $t['remove'] }}
            </button>
        </div>
    </template>
</div>

<script>
    function fileDropzone(multi = false, existingUrl = null, existingType = null) {
        return {
            files: existingUrl && existingType ? [{
                name: 'فایل موجود',
                url: existingUrl,
                type: existingType,
                raw: null
            }] : [],
            previewFiles(event) {
                const selected = Array.from(event.target.files);
                this.processFiles(selected);
            },
            handleDrop(event) {
                const dropped = Array.from(event.dataTransfer.files);
                this.$refs.input.files = event.dataTransfer.files;
                this.processFiles(dropped);
            },
            processFiles(fileList) {
                if (!fileList.length) return;
                if (!multi) this.files = [];

                fileList.forEach(file => {
                    const maxKB = {{ $maxSize ?? 'null' }};
                    const maxW = {{ $maxWidth ?? 'null' }};
                    const maxH = {{ $maxHeight ?? 'null' }};

                    if (maxKB && file.size / 1024 > maxKB) {
                        alert("{{ $t['sizeError'] }}");
                        return;
                    }

                    const type = file.type;
                    let fileType = 'document';

                    if (type.startsWith('image/')) {
                        fileType = 'image';
                        const img = new Image();
                        img.onload = () => {
                            if ((maxW && img.width > maxW) || (maxH && img.height > maxH)) {
                                alert("{{ $t['dimensionError'] }}");
                                return;
                            }
                            this.files.push({ name: file.name, url: URL.createObjectURL(file), type: fileType, raw: file });
                        };
                        img.src = URL.createObjectURL(file);
                        return;
                    }

                    if (type.startsWith('video/')) {
                        fileType = 'video';
                        const video = document.createElement('video');
                        video.preload = 'metadata';
                        video.onloadedmetadata = () => {
                            if ((maxW && video.videoWidth > maxW) || (maxH && video.videoHeight > maxH)) {
                                alert("{{ $t['dimensionError'] }}");
                                return;
                            }
                            this.files.push({ name: file.name, url: URL.createObjectURL(file), type: fileType, raw: file });
                        };
                        video.src = URL.createObjectURL(file);
                        return;
                    }

                    this.files.push({ name: file.name, url: null, type: fileType, raw: file });
                });
            },
            removeFile(index) {
                this.files.splice(index, 1);
                this.$refs.input.value = '';
            }
        }
    }
</script>
