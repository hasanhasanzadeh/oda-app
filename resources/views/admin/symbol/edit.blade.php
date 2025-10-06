@extends('admin.layouts.master')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Page Title -->
        <div class="flex justify-between">
            <h1 class="mb-6 text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{$title}}
            </h1>

            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{route('symbols.index')}}"
                   class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {{__('message.symbols')}}
                </a>
            </div>
        </div>

        <!-- Edit Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-4 sm:p-6">
                <form class="w-full" method="post" action="{{route('symbols.update', $symbol->id)}}"
                      enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$symbol->id}}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="title">
                                {{__('message.title')}}
                            </label>
                            <input class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out shadow-sm"
                                   id="title"
                                   name="title"
                                   type="text"
                                   value="{{$symbol->title}}"
                                   placeholder="{{__('message.title')}}">
                        </div>

                        <!-- URL Field -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="link">
                                {{__('message.url')}}
                            </label>
                            <input class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out shadow-sm"
                                   id="link"
                                   name="link"
                                   type="text"
                                   value="{{$symbol->link}}"
                                   placeholder="{{__('message.link')}}">
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="setting_id">
                                {{__('message.settings')}}
                            </label>
                            <select name="setting_id"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out shadow-sm"
                                    id="setting_id">
                                @foreach(\App\Models\Setting::all() as $setting)
                                    <option value="{{$setting->id}}"
                                            @if($symbol->setting_id==$setting->id) selected @endif>
                                        {{$setting->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Dropdown -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="status">
                                {{__('message.status')}}
                            </label>
                            <select name="status"
                                    id="status"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out shadow-sm">
                                <option value="1"
                                        @if($symbol->status==1) selected @endif>{{__('message.active')}}</option>
                                <option value="0"
                                        @if($symbol->status==0) selected @endif>{{__('message.inactive')}}</option>
                            </select>
                        </div>

                        <!-- Image Upload -->
                        <div class="flex justify-between items-center gap-2">
                            <x-file-previewer name="image"
                                              label="تغییر عکس"
                                              :multiple="false"
                                              lang="fa"
                                              accept="image/*"
                                              :maxSize="config('file-upload.max_file_upload')"
                                              :existing-url="$symbol->photo->address??''"
                                              :existing-type="$symbol->photo->type??''"
                            />
                        </div>

                        <!-- Description Textarea -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300" for="description">
                                {{__('message.description')}}
                            </label>
                            <textarea
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition duration-150 ease-in-out shadow-sm"
                                    rows="5"
                                    id="description"
                                    name="description"
                                    placeholder="{{__('message.description')}}">{{$symbol->description}}</textarea>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-wrap gap-4">
                        <button type="submit"
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            {{__('message.store')}}
                        </button>

                        <a href="{{route('symbols.show', $symbol->id)}}"
                           class="inline-flex items-center px-4 py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-lg transition duration-150 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            {{__('message.cancel')}}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
