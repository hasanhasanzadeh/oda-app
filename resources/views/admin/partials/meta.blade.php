<div class="w-full px-3 my-3">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50" for="meta_title">
        {{__('message.meta_title')}}
    </label>
    <input class="w-full px-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-500 appearance-none" id="meta_title" name="meta_title" type="text" value="{{old('meta_title')}}" placeholder="{{__('message.meta_title')}}">
</div>

<div class="w-full px-3 my-3">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50" for="meta_keywords">
        {{__('message.meta_keywords')}}
    </label>
    <textarea  name="meta_keywords" placeholder="{{__('message.meta_keywords')}}"  id="meta_keywords" rows="2" class="w-full px-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-500 appearance-none" >{{old('meta_keywords')}}</textarea>
</div>
<div class="w-full px-3 my-3">
    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 dark:text-gray-50" for="meta_description">
        {{__('message.meta_description')}}
    </label>
    <textarea  name="meta_description" placeholder="{{__('message.meta_description')}}"  id="meta_description" rows="2" class="w-full px-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl shadow-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 hover:border-gray-300 dark:hover:border-gray-500 appearance-none" >{{old('meta_description')}}</textarea>
</div>
