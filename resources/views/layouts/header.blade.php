<div x-show="showToast"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform -translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-300"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform -translate-y-2"
     class="fixed top-4 right-4 z-50 toast-notification"
     :class="{
                'bg-green-500': toastType === 'success',
                'bg-red-500': toastType === 'error',
                'bg-blue-500': toastType === 'info',
                'bg-yellow-500': toastType === 'warning'
             }">
    <div class="flex items-center justify-between px-4 py-3 text-white rounded-lg shadow-md">
        <div class="flex items-center">
            <i class="mr-2 text-xl"
               :class="{
                        'fas fa-check-circle': toastType === 'success',
                        'fas fa-exclamation-circle': toastType === 'error',
                        'fas fa-info-circle': toastType === 'info',
                        'fas fa-exclamation-triangle': toastType === 'warning'
                       }"></i>
            <p x-text="toastMessage"></p>
        </div>
        <button @click="showToast = false" class="mr-2 text-white">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
