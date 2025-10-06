@extends('admin.layouts.master')

@section('content')
    <div class="mx-auto w-full px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ route('payments.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            ← بازگشت به پرداختی ها
        </a>

        <div class="mt-4 grid grid-cols-1 gap-6 lg:grid-cols-3">
            {{-- Summary Card --}}
            <div
                    class="lg:col-span-2 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                       dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            پرداخت شماره #{{ $payment->id }}
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            شماره مرجع:
                            <span class="font-mono">{{ $payment->reference_id }}</span>
                        </p>
                    </div>
                    <span class="{{ $payment->statusBadgeClasses() }}">{{ ucfirst($payment->statusLabel) }}</span>
                </div>

                <dl class="mt-6 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">شماره تراکنش</dt>
                        <dd class="font-mono text-gray-900 dark:text-gray-100">{{ $payment->transaction_id }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">هزینه پرداختی</dt>
                        <dd class="text-gray-900 dark:text-gray-100 font-semibold">
                            تومان {{ number_format($payment->amount,0) }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">کاربر</dt>
                        <dd class="text-gray-900 dark:text-gray-100">
                            <a href="{{route('customers.show',$payment->user_id)}}" class="flex items-center">
                                <img src="{{$payment->user->avatar->address ?? asset('images/user/avatar-profile.png')}}"
                                     class="w-10 h-10 ml-3 rounded-full" alt="">
                                @if($payment->user)
                                    <div>
                                        <div>{{ $payment->user->full_name ?? '—' }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $payment->user->mobile }}
                                        </div>
                                    </div>
                                @endif
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">پرداخت برای آگهی شماره</dt>
                        <dd class="text-gray-900 dark:text-gray-100">
                            <a href="{{route('advertisements.show',$payment->paymentable_id)}}" title="نمایش آگهی"
                               class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                {{ class_basename($payment->paymentable_type) }} #{{ $payment->paymentable_id }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500 dark:text-gray-400">زمان انجام تراکنش</dt>
                        <dd>
                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                {{ verta($payment->created_at)->format('d F Y') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ verta($payment->created_at)->format('h:i A') }}
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Transaction Result --}}
            <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm
                       dark:border-gray-700 dark:bg-gray-800">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">اطلاعات پرداخت</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    اطلاعات قابل نمایش برای پرداخت.
                </p>

                <div class="mt-4 overflow-hidden rounded-xl border bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                    <pre class="overflow-x-auto p-4 text-xs leading-relaxed text-gray-800 dark:text-gray-200">
                            {{ json_encode($payment->transaction_result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}
                    </pre>
                </div>
            </div>
        </div>
    </div>
@endsection
