@extends('admin.layouts.master')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('profile.show')}}"
           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('message.profile')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs border">
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('profile.update')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$user->id}}" name="id">
                    <div class="flex flex-wrap mx-3 my-2">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="first_name">
                                {{__('message.first_name')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="first_name" name="first_name" type="text" value="{{$user->first_name}}"
                                   placeholder="{{__('message.first_name')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="last_name">
                                {{__('message.last_name')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="last_name" name="last_name" type="text" value="{{$user->last_name}}"
                                   placeholder="{{__('message.last_name')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="password">
                                {{__('message.password')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                   id="password" name="password" type="text" value=""
                                   placeholder="{{__('message.password')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="gender">
                                {{__('message.gender')}}
                            </label>
                            <select class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-8 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                    id="gender" name="gender">
                                <option value="" @if($user->gender==null) selected @endif > جنسیت را انتخاب کنید
                                </option>
                                <option value="male"
                                        @if($user->gender=='male') selected @endif > @lang('message.male')</option>
                                <option value="female"
                                        @if($user->gender=='female') selected @endif > @lang('message.female')</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                    for="national_code">
                                {{__('message.national_code')}}
                            </label>
                            <input type="text" dir="ltr" name="national_code"
                                   placeholder="{{__('message.national_code')}}"
                                   value="{{$user->national_code}}" id="national_code"
                                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="mobile">
                                {{__('message.mobile')}}
                            </label>
                            <input type="tel" dir="ltr" name="mobile" placeholder="{{__('message.mobile')}}"
                                   value="{{$user->mobile}}" id="mobile"
                                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                   for="email">
                                {{__('message.email')}}
                            </label>
                            <input type="email" name="email" placeholder="{{__('message.email')}}"
                                   value="{{$user->email}}" id="email"
                                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input text-left">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label
                                    class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50"
                                    for="address">
                                {{__('message.address')}}
                            </label>
                            <input type="text" name="address" placeholder="{{__('message.address')}}"
                                   value="{{$user->address}}" id="address"
                                   class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 form-input">
                        </div>
                        <div class="flex justify-between items-center gap-2">
                            <x-file-previewer name="avatar"
                                              label="تغییر پروفایل"
                                              :multiple="false"
                                              lang="fa"
                                              accept="image/*"
                                              :maxSize="config('file-upload.max_file_upload')"
                                              :existing-url="$user->avatar->address??''"
                                              :existing-type="$user->avatar->type??''"
                            />
                        </div>
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
        $("#full_name").keyup(function () {
            let username = $('#full_name').val();
            $.ajax({
                type: 'POST',
                url: "{{route('make.slug')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'title': username
                },
                success: function (res) {
                    $("#username").val(res);
                }, error: function () {
                    console.log('error for username')
                }
            });

        });
        $("#image").change(function (e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#image-select').attr('src', e.target.result);
                    $('#image-select').removeClass('hidden');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>

@endsection
