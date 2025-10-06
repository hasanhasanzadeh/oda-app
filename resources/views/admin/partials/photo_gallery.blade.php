<button class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white mr-1" type="button" onclick="openGallery()">@lang('dashboard.gallery')</button>
<div class="w-full fixed max-w-[780px] h-[200px] md:h-[400px] overflow-y-auto mx-auto hidden" id="gallery">
    <div class="bg-white rounded shadow-lg w-full  mx-auto dark:bg-gray-800">
        <div class="border-b px-4 py-2 dark:text-stone-100">
            <h3>@lang('dashboard.gallery')</h3>
        </div>
        <div class="p-3">
            <table class="w-full  ">
                <thead>
                <tr>
                    <td colspan="5">
                            <button class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded text-white m-3" type="button">@lang('dashboard.select')</button>
                            <button class="bg-blue-600 hover:bg-red-700 px-3 py-1 rounded text-white m-3" type="button" onclick="closeGallery()" >@lang('dashboard.close')</button>
                    </td>
                </tr>
                <tr class="text-sm font-bold tracking-wide text-center text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800" >
                    <th class="p-1">{{__('message.id')}}</th>
                    <th class="p-1">{{__('message.select')}}</th>
                    <th class="p-1">{{__('message.photo')}}</th>
                    <th class="p-1">{{__('message.created_at')}}</th>
                    <th class="p-1">{{__('message.operation')}}</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800 text-center">
                @foreach($photos as $photo)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="p-2 text-sm">
                            {{$photo->id}}
                        </td>
                        <td class="p-2 text-sm">
                            <input type="radio" checked class="form-radio hover:cursor-pointer" name="photo_id" value="{{$photo->id}}">
                        </td>
                        <td class="p-2 text-sm">
                            <img src="{{$photo->address}}"  height="70" width="70" alt="" class="rounded mx-auto">
                        </td>
                        <td class="p-2 text-sm">
                            @if(config('app.locale')=='fa')
                                {{verta()->instance($photo->created_at)->format('%d %B %Y')}}
                            @else
                                {{ date('d-M-y', strtotime($photo->created_at))}}
                            @endif
                        </td>
                        <td class="p-2 text-sm">
                            <a href="{{route('photo.destroy',$photo->id)}}" class="text-red-600 show_confirm"  onclick="confirmSubmit()" title="{{__('message.delete')}}">
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
