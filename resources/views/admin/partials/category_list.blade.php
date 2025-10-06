@foreach($categories as $subCategory)
    <option value="{{$subCategory->id}}"
            @if($subCategory->id==$category->parent_id) selected @endif> {{str_repeat('--',$level)}}
        <span> </span>{{$subCategory->name}}</option>
    @if(count($subCategory->children)>0)
        @include('admin.partials.category_list',['categories'=>$subCategory->children,'level'=>$level+1])
    @endif
@endforeach
