<!-- Button trigger modal -->
<button type="button" class="bg-blue-500 text-white rounded-md px-8 py-2 text-base font-medium hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300" id="open-modal">
    @lang('dashboard.photo_select')
</button>
<div class="p-2 m-2">
    <input type="hidden" name="photo_id" @if($subject) value="{{$subject->id}}" @endif id="photo_id">
    <div id="select_photo" class="bg-gray-50 p-2 m-2 rounded h-auto w-full flex">
        @if($subject)
            <img src="{{$subject->address}}" width="150" height="150" class="rounded shadow" alt="">
        @endif
    </div>
</div>
<!-- Modal -->
<div class="w-full">
    <div  class="fixed  w-full  bg-black opacity-25 top-0 left-0 full-height"  id="modal-full"></div>
    <div class="absolute flex overflow-hidden dark:bg-gray-700 dark:text-stone-300 top-20 mx-auto p-2 border shadow-lg rounded-md bg-white modal-di over-h" id="modal-select">
        <div>
            <div class="modal-gallery">
                <div class="p-2 z-40 w-full md:w-1/2">
                    <div class="flex justify-between mt-3 text-center">
                        <div class="flex items-center justify-center h-8 w-8 rounded-lg bg-blue-500">
                            <button type="button" id="close" class="p-3 m-2 close"> <i class="fa fa-close fa-xl text-white"></i></button>
                        </div>
                        <div>
                            <h3 class="font-bold">@lang('dashboard.photo_select')</h3>
                        </div>
                    </div>
                    <hr class="p-2 font-bold">
                    <div>
                        <div class="flex items-center p-3 space-x-2">
                            <button  onclick="selectPhoto()" type="button" class="px-4 py-2 mx-3 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                                @lang('dashboard.select')
                            </button>
                            <button onclick="loadImag()" type="button" class="px-4 py-2 mx-3 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                                @lang('dashboard.upload')
                            </button>
                        </div>
                    </div>
                    <div id="photo_upload" class="dropzone m-2 rounded"></div>
                </div>
                <div class="p-2 z-10 w-full scroll-h">
                    <div class="relative shadow-md sm:rounded-lg">
                        <table class="w-full rounded text-sm text-center text-gray-500 dark:text-gray-400 overflow-y-scroll" >
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-3 py-2">
                                    @lang('dashboard.check')
                                </th>
                                <th scope="col" class="px-3 py-2">
                                    @lang('dashboard.photo')
                                </th>
                                <th scope="col" class="px-3 py-2">
                                    @lang('dashboard.created_at')
                                </th>
                                <th scope="col" class="px-3 py-2">
                                    @lang('dashboard.operation')
                                </th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @foreach($photos as $photo)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="w-2 p-2">
                                        <div class="">
                                            <input id="radio-{{$photo->id}}" name="photo_radio" @if($subject && $subject->id==$photo->id) checked @endif value="{{$photo->id}}" type="radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="radio-{{$photo->id}}" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <td class=" px-2 py-2 ">
                                        <img class="w-20 h-20 rounded" src="{{$photo->address}}" alt="Jese image">
                                    </td>
                                    <td class="px-3 py-2">
                                        {{$photo->created_at}}
                                    </td>
                                    <td class="px-3 py-2">
                                        <a href="{{route('photo.destroy',$photo->id)}}" class="font-medium text-red-600 dark:text-red-500 hover:underline show_confirm"  onclick="confirmSubmit()" title="{{__('message.delete')}}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
