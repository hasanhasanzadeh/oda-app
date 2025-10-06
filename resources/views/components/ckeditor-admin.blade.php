@props([
    'name' => 'content',
    'label' => 'Content',
    'value' => '',
    'height' => '400px',
    'required' => false,
    'language' => 'fa',
    'rtl' => false,
    'imageUpload' => true,
    'fileUpload' => false,
    'mediaEmbed' => true,
    'codeBlocks' => false,
    'plugins' => [],
    'config' => [],
    'autosave' => false,
    'sourceEditing' => false,
    'placeholder' => 'Text Enter',
])
@php
    $rtlLanguages = ['ar', 'fa', 'he', 'ur', 'ps', 'sd', 'ku', 'ckb', 'dv'];
    $isRtl = $rtl || in_array($language, $rtlLanguages);

    // Auto-detect RTL from content if not explicitly set
    if (!$rtl && $value) {
        $rtlPattern = '/[\x{0590}-\x{05FF}\x{0600}-\x{06FF}\x{0750}-\x{077F}\x{FB50}-\x{FDFF}\x{FE70}-\x{FEFF}]/u';
        if (preg_match($rtlPattern, $value)) {
            $isRtl = true;
        }
    }
@endphp
<div class="space-y-2">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            class="hidden"
            @if($required) required @endif
            {{ $isRtl ? 'dir="rtl"' : 'dir="ltr"' }}
            {{ $isRtl ? 'lang="' . $language . '"' : '' }}
            placeholder="{{$placeholder}}"
        >{{ old($name, $value) }}</textarea>

        <div
            id="{{ $name }}-editor"
            style="min-height: {{ $height }};"
            class="border border-gray-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 {{ $isRtl ? 'rtl-editor' : '' }}"
            data-language="{{ $language }}"
            data-rtl="{{ $isRtl ? 'true' : 'false' }}"
        ></div>
    </div>

    @error($name)
        <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror
</div>

@once
    @push('style')
        <style>
            .ck.ck-editor {
                border-radius: 0.75rem;
                border: 1px solid #d1d5db;
                overflow: hidden;
            }

            .dark .ck.ck-editor {
                border-color: #4b5563;
            }

            .ck.ck-toolbar {
                border: none !important;
                border-radius: 0.75rem 0.75rem 0 0 !important;
                background: #f9fafb;
                padding: 12px !important;
            }

            .dark .ck.ck-toolbar {
                background: #374151 !important;
            }

            .ck.ck-editor__editable {
                border: none !important;
                border-radius: 0 0 0.75rem 0.75rem !important;
                min-height: 300px !important;
                padding: 20px !important;
                font-family: system-ui, -apple-system, sans-serif;
                line-height: 1.6;
            }

            .dark .ck.ck-editor__editable {
                background: #1f2937 !important;
                color: #f9fafb !important;
            }

            .ck.ck-button {
                border-radius: 6px !important;
            }

            .dark .ck.ck-button {
                color: #f9fafb !important;
            }

            .dark .ck.ck-button:hover {
                background-color: #4b5563 !important;
            }

            /* RTL Support */
            .rtl-editor .ck.ck-editor__editable {
                direction: rtl !important;
                text-align: right !important;
            }

            .rtl-editor .ck.ck-content p,
            .rtl-editor .ck.ck-content h1,
            .rtl-editor .ck.ck-content h2,
            .rtl-editor .ck.ck-content h3,
            .rtl-editor .ck.ck-content h4,
            .rtl-editor .ck.ck-content h5,
            .rtl-editor .ck.ck-content h6,
            .rtl-editor .ck.ck-content li,
            .rtl-editor .ck.ck-content blockquote {
                direction: rtl !important;
                text-align: right !important;
            }

            /* Persian/Arabic font support */
            [data-language="fa"] .ck.ck-editor__editable,
            [data-language="ar"] .ck.ck-editor__editable {
                font-family: 'Tahoma', 'Arial', sans-serif !important;
                line-height: 1.8 !important;
            }
        </style>
    @endpush
@endonce

@once
    @push('script')
        <!-- CKEditor 5 CDN -->
        <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    @endpush
@endonce

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Add delay to ensure CKEditor script is fully loaded
            setTimeout(function() {
                const editorElement = document.querySelector('#{{ $name }}-editor');
                const textareaElement = document.querySelector('#{{ $name }}');

                console.log('Attempting to initialize CKEditor for {{ $name }}');
                console.log('Editor element:', editorElement);
                console.log('Textarea element:', textareaElement);
                console.log('ClassicEditor available:', typeof ClassicEditor !== 'undefined');

                if (!editorElement || !textareaElement) {
                    console.error('CKEditor elements not found for {{ $name }}');
                    return;
                }

                if (typeof ClassicEditor === 'undefined') {
                    console.error('ClassicEditor is not loaded');
                    // Fallback: show textarea
                    textareaElement.classList.remove('hidden');
                    textareaElement.classList.add('w-full', 'p-3', 'border', 'border-gray-300', 'dark:border-gray-600', 'rounded-xl', 'bg-white', 'dark:bg-gray-700', 'text-gray-900', 'dark:text-white');
                    textareaElement.style.minHeight = '{{ $height }}';
                    editorElement.innerHTML = '<div class="p-4 text-red-600 bg-red-50 border border-red-200 rounded">CKEditor failed to load. Please refresh the page.</div>';
                    return;
                }

                ClassicEditor
                    .create(editorElement, {
                        toolbar: {
                            items: [
                                'heading', '|', 'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|', 'bold', 'italic', 'underline', 'strikethrough', 'subscript', 'superscript', '|', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', 'alignment', '|', 'insertTable', 'blockQuote', 'horizontalLine', '|',
                                @if($imageUpload) 'uploadImage', @endif
                                @if($mediaEmbed) 'mediaEmbed', @endif
                                @if($codeBlocks) 'codeBlock', @endif
                                '|', 'undo', 'redo'
                                @if($sourceEditing), '|', 'sourceEditing' @endif
                            ].filter(item => item !== null)
                        },
                        language: '{{ $language }}',
                        @if($isRtl)
                        contentsLangDirection: 'rtl',
                        @endif
                        fontSize: {
                            options: [
                                9, 11, 13, 'default', 17, 19, 21, 24, 28, 32
                            ]
                        },
                        @if($imageUpload)
                        image: {
                            toolbar: [
                                'imageTextAlternative',
                                'imageStyle:inline',
                                'imageStyle:block',
                                'imageStyle:side'
                            ]
                        },
                        @endif
                        table: {
                            contentToolbar: [
                                'tableColumn',
                                'tableRow',
                                'mergeTableCells'
                            ]
                        },
                        @if($imageUpload)
                        ckfinder: {
                            uploadUrl: '{{ route("ckeditor.upload") }}?_token={{ csrf_token() }}'
                        },
                        @endif
                        placeholder: '{{ $placeholder }}'
                    })
                    .then(editor => {
                        console.log('CKEditor successfully initialized for {{ $name }}');

                        // Set initial data
                        if (textareaElement.value) {
                            editor.setData(textareaElement.value);
                        }

                        // Sync data to textarea on changes
                        editor.model.document.on('change:data', () => {
                            textareaElement.value = editor.getData();

                            // Trigger input event for form validation
                            const event = new Event('input', { bubbles: true });
                            textareaElement.dispatchEvent(event);
                        });

                        // Handle form submission
                        const form = textareaElement.closest('form');
                        if (form) {
                            form.addEventListener('submit', () => {
                                textareaElement.value = editor.getData();
                            });
                        }

                        // Store editor reference globally for debugging
                        window['editor_{{ $name }}'] = editor;
                    })
                    .catch(error => {
                        console.error('CKEditor initialization failed for {{ $name }}:', error);

                        // Fallback: show textarea
                        textareaElement.classList.remove('hidden');
                        textareaElement.classList.add('w-full', 'p-3', 'border', 'border-gray-300', 'dark:border-gray-600', 'rounded-xl', 'bg-white', 'dark:bg-gray-700', 'text-gray-900', 'dark:text-white');
                        textareaElement.style.minHeight = '{{ $height }}';
                        editorElement.innerHTML = '<div class="p-4 text-red-600 bg-red-50 border border-red-200 rounded-xl">CKEditor failed to load: ' + error.message + '</div>';
                    });
            }, 500); // 500ms delay
        });
    </script>
@endpush