@foreach($categories as $subCategory)
    <tr class="text-gray-700 dark:text-gray-400">
        <td class="px-4 py-3 text-sm">
            {{++$row}}
        </td>
        <td class="px-4 py-3 text-xs">
            <span class="px-2">
            {{str_repeat('--',$level)}}
            </span>
            <span>
            {{$subCategory->name}}
            </span>
        </td>
        <td class="px-4 py-3 text-sm">
            @if(config('app.locale')=='fa')
                {{verta()->instance($subCategory->created_at)->format('%d %B %Y')}}
            @else
                {{ date('d-M-y', strtotime($subCategory->created_at))}}
            @endif
        </td>
        <td class="px-4 py-3 text-xl flex justify-center">
            <a href="{{route('categories.show',$subCategory->id)}}" class="text-blue-500 mx-auto"
               title="{{__('message.show')}}">
                <i class="fa fa-eye"></i>
            </a>
            <a href="{{route('categories.edit',$subCategory->id)}}" class="text-yellow-900 mx-auto"
               title="{{__('message.edit')}}">
                <i class="fa fa-edit"></i>
            </a>

            <form action="{{route('categories.destroy',$subCategory->id)}}" method="POST" class="mx-auto">
                @csrf
                {{method_field('DELETE')}}
                <button class="text-red-600 show_confirm" name="delete" onclick="confirmSubmit()" type="submit"
                        title="{{__('message.delete')}}">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        </td>
    </tr>
    @if(count($subCategory->children)>0)
        @include('admin.partials.category_child',['categories'=>$subCategory->children,'level'=>$level+1])
    @endif
@endforeach
