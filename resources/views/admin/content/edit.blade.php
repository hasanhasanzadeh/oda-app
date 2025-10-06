@extends('admin.layouts.master')

@section('content')
    <div class="container px-4 sm:px-6 mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between my-6">
            <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                {{ $title }}
            </h1>
            <a href="{{ route('contents.index') }}" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                {{ __('message.contents') }}
            </a>
        </div>

        <!-- Blog Edit Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h2 class="text-lg font-medium text-gray-700 dark:text-gray-200">
                    {{ __('message.edit') }}: {{ $content->title }}
                </h2>
            </div>

            <form method="post" action="{{ route('contents.update', $content->id) }}" enctype="multipart/form-data" class="px-6 py-4">
                @csrf
                {{ method_field('PATCH') }}
                <input type="hidden" name="id" value="{{ $content->id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title Field -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('message.title') }} *
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ $content->title }}"
                            placeholder="{{ __('message.title') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                            required
                        >
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('message.status') }}
                        </label>
                        <select
                            id="status"
                            name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                        >
                            <option value="1" {{ $content->status == 1 ? 'selected' : '' }}>{{ __('message.active') }}</option>
                            <option value="0" {{ $content->status == 0 ? 'selected' : '' }}>{{ __('message.inactive') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('message.type') }}
                        </label>
                        <select
                            id="type"
                            name="type"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:focus:border-blue-500"
                        >
                            <option value="contact-us" {{ $content->type == 'contact-us' ? 'selected' : '' }}>{{ __('message.contact-us') }}</option>
                            <option value="about-us" {{ $content->type == 'about-us' ? 'selected' : '' }}>{{ __('message.about-us') }}</option>
                            <option value="rules" {{ $content->type == 'rules' ? 'selected' : '' }}>{{ __('message.rules') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Media Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <x-file-previewer name="image"
                                      label="عکس "
                                      :multiple="false"
                                      lang="fa"
                                      accept="image/*"
                                      :maxSize="config('file-upload.max_file_upload')"
                                      :existing-url="$content->photo->address??''"
                                      :existing-type="$content->photo->type??''"
                    />
                </div>

                <!-- Text Content -->
                <div class="mt-6 space-y-6">
                    <x-ckeditor-admin
                            name="description"
                            label="{{ __('message.description') }}"
                            height="500px"
                            language="fa"
                            :rtl="true"
                            :value="old('description', $content->description)"
                            :required="true"
                            :image-upload="true"
                            :file-upload="true"
                            :autosave="true"
                            placeholder="توضیحات  را وارد کنید"
                    />
                </div>

                <!-- Meta Fields -->
                @include('admin.partials.meta_edit', ['object' => $content])

                <!-- Action Buttons -->
                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('contents.show', $content->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-800 focus:outline-none focus:border-gray-800 focus:ring focus:ring-gray-300 mr-3 dark:focus:ring-gray-800 transition ease-in-out duration-150">
                        {{ __('message.cancel') }}
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        {{ __('message.update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ url('/plugin/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize CKEditor for body
            CKEDITOR.replace('description', {
                customConfig: 'config.js',
                toolbar: 'simple',
                language: '{{ Config::get('app.locale') }}',
                removePlugins: 'cloudservices, easyimage',
                filebrowserImageUploadUrl: "{{ url('/') }}" + '/panel/upload-image?type=Images',
                filebrowserUploadMethod: 'form',
                filebrowserUploadUrl: "{{ url('/') }}" + '/panel/upload-image?type=Images',
                filebrowserImage2BrowseUrl: "{{ url('/') }}" + '/panel/upload-image?type=Images',
                filebrowserImageBrowseUrl: "{{ url('/') }}" + '/panel/upload-image?type=Images',
                filebrowserBrowseUrl: "{{ url('/') }}" + '/panel/upload-image?type=Files',
            });

            // Auto-generate slug from title
            $("#title").keyup(function() {
                let title = $(this).val();
                if (title.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('make.slug') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'title': title
                        },
                        success: function(res) {
                            $("#slug").val(res);
                        },
                        error: function() {
                            console.error('Error generating slug');
                        }
                    });
                }
            });

            // Image preview functionality
            $("#image").change(function(e) {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-select').attr('src', e.target.result);
                        $('#image-select').removeClass('hidden');
                        $('#image-placeholder').addClass('hidden');
                        $('#remove-image').removeClass('hidden');
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Remove image
            $("#remove-image").click(function() {
                if(confirm("{{ __('message.confirm_remove_image') }}")) {
                    $('#image').val('');
                    $('#image-select').addClass('hidden').attr('src', '');
                    $('#image-placeholder').removeClass('hidden');
                    $(this).addClass('hidden');

                    // Add a hidden field to indicate image removal
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'remove_image',
                        value: '1'
                    }).appendTo('form');
                }
            });
        });
    </script>
@endsection
