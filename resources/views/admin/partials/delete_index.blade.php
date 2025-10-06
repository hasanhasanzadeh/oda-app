@push('script')
    <script>
        function confirmClearParameters() {
            Swal.fire({
                title: 'پاک کردن فیلترها',
                text: 'آیا مطمئن هستید که می‌خواهید تمام فیلترها را پاک کنید؟',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'بله، پاک شود',
                cancelButtonText: 'انصراف'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Clear parameters and redirect
                    window.location.href = window.location.href.split('?')[0];
                }
            });
        }
        function confirmDelete(id) {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این عملیات قابل بازگشت نیست!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله، حذف شود!',
                cancelButtonText: 'انصراف'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
        function confirmDeleteAll(){
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این عملیات قابل بازگشت نیست!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله همه، حذف شوند!',
                cancelButtonText: 'انصراف'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-all').submit();
                }
            });
        }
    </script>
@endpush
