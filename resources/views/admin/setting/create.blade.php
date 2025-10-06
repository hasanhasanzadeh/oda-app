@extends('admin.layouts.master')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('settings.index')}}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('message.settings')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs border">
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('settings.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap mx-3 my-2">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="title">
                                {{__('message.title')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="title" name="title" type="text" value="{{old('title')}}"
                                   placeholder="{{__('message.title')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="url">
                                {{__('message.url')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="url" name="url" type="text" value="{{old('url')}}"
                                   placeholder="{{__('message.enterUrl')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="short_text">
                                {{__('message.short_text')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="short_text" name="short_text" type="text" value="{{old('short_text')}}"
                                   placeholder="{{__('message.enterShortText')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="tel">
                                {{__('message.tel')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="tel" name="tel" type="text" value="{{old('tel')}}"
                                   placeholder="{{__('message.tel')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="email">
                                {{__('message.email')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="email" name="email" type="email" value="{{old('email')}}"
                                   placeholder="{{__('message.enterEmail')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="support_text">
                                {{__('message.support_text')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="support_text" name="support_text" type="text" value="{{old('support_text')}}"
                                   placeholder="{{__('message.support_text')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50">{{__('message.logo')}}</label>
                            <div class="block">
                                <input type="file" name="logo" id="logo_id"
                                       class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <img src="" id="logo" height="150" width="150" alt=""
                                     class="rounded-full w-12 h-12 hidden">
                            </div>
                        </div>
                        <div class="w-full px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50">{{__('message.favicon')}}</label>
                            <div class="block">
                                <input type="file" name="favicon" id="favicon_id"
                                       class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <img src="" id="favicon" height="150" width="150" alt=""
                                     class="rounded-full w-12 h-12 hidden">
                            </div>
                        </div>
                        <div class="w-full px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="address">
                                {{__('message.address')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="address" name="address" type="text" value="{{old('address')}}"
                                   placeholder="{{__('message.enterAddress')}}">
                        </div>
                        <div class="w-full px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="copy_right">
                                {{__('message.copy_right')}}
                            </label>
                            <textarea
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    rows="5" id="copy_right" name="copy_right"
                                    placeholder="{{__('message.enterCopyRight')}}">{{old('copy_right')}}</textarea>
                        </div>
                        <div class="w-full px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="description">
                                {{__('message.description')}}
                            </label>
                            <textarea
                                    class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    rows="5" id="description" name="description"
                                    placeholder="{{__('message.enterDescription')}}">{{old('description')}}</textarea>
                        </div>
                        @include('admin.partials.media')
                        @include('admin.partials.meta')
                        <div class="w-full px-3 my-3">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fa fa-save"></i>
                                {{__('message.store')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $("#favicon_id").change(function (e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#favicon').attr('src', e.target.result);
                    $('#favicon').removeClass('hidden');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        $("#logo_id").change(function (e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#logo').attr('src', e.target.result);
                    $('#logo_id').removeClass('hidden');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endsection
