<div class="flex flex-wrap -mx-2">
    <!-- Telegram -->
    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="telegram">
            {{__('message.telegram')}}
        </label>
        <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500"
               id="telegram"
               name="telegram"
               type="url"
               value="{{$object->socialMedia->telegram??old('telegram')}}"
               placeholder="{{__('message.telegram')}}">
    </div>

    <!-- Instagram -->
    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="instagram">
            {{__('message.instagram')}}
        </label>
        <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500"
               id="instagram"
               name="instagram"
               type="url"
               value="{{$object->socialMedia->instagram??old('instagram')}}"
               placeholder="{{__('message.instagram')}}">
    </div>

    <!-- WhatsApp -->
    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="whatsapp">
            {{__('message.whatsapp')}}
        </label>
        <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500"
               id="whatsapp"
               name="whatsapp"
               type="url"
               value="{{$object->socialMedia->whatsapp??old('whatsapp')}}"
               placeholder="{{__('message.whatsapp')}}">
    </div>

    <!-- YouTube -->
    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="youtube">
            {{__('message.youtube')}}
        </label>
        <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500"
               id="youtube"
               name="youtube"
               type="url"
               value="{{$object->socialMedia->youtube??old('youtube')}}"
               placeholder="{{__('message.youtube')}}">
    </div>

    <!-- Facebook -->
    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="facebook">
            {{__('message.facebook')}}
        </label>
        <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500"
               id="facebook"
               name="facebook"
               type="url"
               value="{{$object->socialMedia->facebook??old('facebook')}}"
               placeholder="{{__('message.facebook')}}">
    </div>

    <!-- X (Twitter) -->
    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="twitter">
            {{__('message.x_link')}}
        </label>
        <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500"
               id="twitter"
               name="x_link"
               type="url"
               value="{{$object->socialMedia->x_link??old('x_link')}}"
               placeholder="{{__('message.x_link')}}">
    </div>

    <!-- Dribbble -->
    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="dribble">
            {{__('message.dribble')}}
        </label>
        <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500"
               id="dribble"
               name="dribble"
               type="url"
               value="{{$object->socialMedia->dribble??old('dribble')}}"
               placeholder="{{__('message.dribble')}}">
    </div>

    <!-- GitHub -->
    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="github">
            {{__('message.github')}}
        </label>
        <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500"
               id="github"
               name="github"
               type="url"
               value="{{$object->socialMedia->github??old('github')}}"
               placeholder="{{__('message.github')}}">
    </div>

    <!-- LinkedIn - Fixed ID -->
    <div class="w-full sm:w-1/2 lg:w-1/3 px-2 mb-4">
        <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-200 text-xs font-bold mb-2" for="linkedin">
            {{__('message.linkedin')}}
        </label>
        <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white dark:focus:bg-gray-800 focus:border-blue-500"
               id="linkedin"
               name="linkedin"
               type="url"
               value="{{$object->socialMedia->linkedin??old('linkedin')}}"
               placeholder="{{__('message.linkedin')}}">
    </div>
</div>
