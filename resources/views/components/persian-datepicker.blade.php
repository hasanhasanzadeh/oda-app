{{-- resources/views/components/persian-datepicker.blade.php --}}
@props([
    'name',
    'value' => null,
    'id' => null,
    'placeholder' => 'انتخاب تاریخ',
    'required' => false,
    'disabled' => false,
])

@php
    use Carbon\Carbon;
    use Morilog\Jalali\Jalalian;

    $uniqueId = $id ?? 'datepicker_' . uniqid();

    // پردازش value - handle کردن تمام حالات ممکن
    $gregorianValue = '';
    $persianValue = '';

    try {
        if ($value) {
            // تبدیل به Carbon
            if ($value instanceof Carbon) {
                $carbonDate = $value;
            } elseif ($value instanceof \DateTime) {
                $carbonDate = Carbon::instance($value);
            } elseif (is_string($value) && trim($value) !== '') {
                $carbonDate = Carbon::parse($value);
            } else {
                $carbonDate = null;
            }

            // اگر Carbon داریم، تبدیل کن
            if ($carbonDate) {
                $gregorianValue = $carbonDate->format('Y-m-d');
                $persianValue = Jalalian::fromCarbon($carbonDate)->format('Y/m/d');
            }
        }
    } catch (\Exception $e) {
        // در صورت خطا، مقادیر خالی بمونن
        \Log::warning("DatePicker Warning for {$name}: " . $e->getMessage());
    }
@endphp

<div class="datepicker-wrapper-{{ $uniqueId }}">
    {{-- Input نمایشی شمسی --}}
    <input
        type="text"
        id="{{ $uniqueId }}_display"
        value="{{ $persianValue }}"
        placeholder="{{ $placeholder }}"
        readonly
        {{ $disabled ? 'disabled' : '' }}
        class="datepicker-input form-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white cursor-pointer"
    />

    {{-- Hidden input برای ارسال میلادی به سرور --}}
    <input
        type="hidden"
        name="{{ $name }}"
        id="{{ $uniqueId }}_hidden"
        value="{{ $gregorianValue }}"
        {{ $required ? 'required' : '' }}
    />

    {{-- Info Debug --}}
    @if(config('app.debug'))
        <div class="mt-1 text-xs text-gray-500">
            <span class="font-mono">G: {{ $gregorianValue ?: 'empty' }}</span> |
            <span class="font-mono">P: {{ $persianValue ?: 'empty' }}</span>
        </div>
    @endif
</div>

@once
    @push('style')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
        <style>
            .datepicker-wrapper {
                position: relative;
            }
            .pwt-btn-today {
                background: #3b82f6 !important;
            }
            .pwt-btn-today:hover {
                background: #2563eb !important;
            }
            .datepicker-input {
                background-color: white !important;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/persian-date@latest/dist/persian-date.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
    @endpush
@endonce

@push('script')
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                var $display = $('#{{ $uniqueId }}_display');
                var $hidden = $('#{{ $uniqueId }}_hidden');
                var persianVal = '{{ $persianValue }}';

                if ($display.length && typeof $display.persianDatepicker === 'function') {
                    $display.persianDatepicker({
                        observer: true,
                        format: 'YYYY/MM/DD',
                        initialValue: persianVal ? true : false,
                        initialValueType: 'persian',
                        autoClose: true,
                        viewMode: 'day',
                        calendar: {
                            persian: {
                                locale: 'fa'
                            }
                        },
                        toolbox: {
                            calendarSwitch: {
                                enabled: false
                            },
                            todayButton: {
                                enabled: true,
                                text: {
                                    fa: 'امروز'
                                }
                            },
                            submitButton: {
                                enabled: true,
                                text: {
                                    fa: 'تایید'
                                }
                            }
                        },
                        onSelect: function(unix) {
                            var date = new Date(unix);
                            var y = date.getFullYear();
                            var m = String(date.getMonth() + 1).padStart(2, '0');
                            var d = String(date.getDate()).padStart(2, '0');
                            $hidden.val(y + '-' + m + '-' + d);
                        }
                    });

                    // مهم: اگر value داریم، دستی set می‌کنیم
                    if (persianVal) {
                        setTimeout(function() {
                            $display.val(persianVal);
                        }, 50);
                    }
                }
            }, 100);
        });
    </script>
@endpush
