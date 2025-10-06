@extends('admin.layouts.master')

@section('content')
    <div class="min-h-screen transition-colors">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 relative">
                <a href="#">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-gray-500 dark:text-gray-400 text-sm">-</h2>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">-</p>
                        </div>
                        <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600 dark:text-blue-300"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 relative">
                <a href="{{route('contacts.index')}}">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-gray-500 dark:text-gray-400 text-sm">پیام‌ها</h2>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $contactsCount }}</p>
                        </div>
                        <div class="bg-green-100 dark:bg-green-900 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600 dark:text-green-300"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 relative">
                <a href="{{route('customers.index')}}">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-gray-500 dark:text-gray-400 text-sm">کاربران</h2>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $usersCount }}</p>
                        </div>
                        <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600 dark:text-purple-300"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 relative">
                <a href="{{route('payments.index')}}">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-gray-500 dark:text-gray-400 text-sm">پرداخت‌ها</h2>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $paymentsCount }}</p>
                        </div>
                        <div class="bg-yellow-100 dark:bg-yellow-900 p-3 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600 dark:text-yellow-300"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6">
            @if(!$payments->isEmpty())
                <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">آخرین پرداخت ها</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 text-right">
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.row')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.full_name')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.id')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.transaction_id')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.reference_id')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.status')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.created_at')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.operation')}}</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            @foreach($payments as $index=>$payment)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 hover:cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="mr-2 font-medium text-gray-900 dark:text-white">{{ $index }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">
                                        <a href="{{route('customers.show',$payment->user_id)}}"
                                           title="نمایش اطلاعات کاربر">
                                            <div class="flex items-center">
                                                <img src="{{$payment->user->avatar->address??asset('images/user/avatar-profile.png')}}"
                                                     class="w-10 h-10 ml-3 rounded-full" alt="">
                                                <div>
                                                    <div class="text-md font-medium text-gray-900 dark:text-white">{{$payment->user->fullName}}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400"
                                                         dir="ltr">{{$payment->user->mobile}}</div>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap  text-gray-900 dark:text-white">
                                        @if($payment->paymentable)
                                            <a href="{{ route('advertisements.show',$payment->paymentable_id) ?? '#' }}"
                                               class="text-xs text-indigo-600 hover:text-indigo-500">
                                                نمایش آگهی
                                            </a>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white" dir="ltr">
                                        {{$payment->transaction_id}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white" dir="ltr">
                                        {{$payment->reference_id??'-'}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="{{ $payment->statusBadgeClasses() }}">{{ $payment->status_label }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{verta($payment->created_at)->format('d F Y')}}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{verta($payment->created_at)->format('h:i A')}}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="flex items-center space-x-3 space-x-reverse">
                                            <a href="{{route('payments.show',$payment->id)}}"
                                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                               title="{{__('message.show')}}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
        <div class="grid grid-cols-1 gap-6 mb-6">
            @if(!$contacts->isEmpty())
                <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100"> ارتباطات </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 text-right">
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.row')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.full_name')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.subject')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.mobile')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.read')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.created_at')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.operation')}}</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            @foreach($contacts as $index=>$contact)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 hover:cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="mr-2 font-medium text-gray-900 dark:text-white">{{ $index }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white">
                                        {{$contact->full_name}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap  text-gray-900 dark:text-white">
                                        {{$contact->subject}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-white" dir="ltr">
                                        {{$contact->mobile}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($contact->read)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:bg-opacity-20 dark:text-blue-400">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-blue-500 rounded-full"></span>
                                <span class="px-2">{{__('message.read')}}</span>
                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:bg-opacity-20 dark:text-yellow-400">
                                <span class="w-1.5 h-1.5 mr-1.5 bg-yellow-500 rounded-full"></span>
                                <span class="px-2">{{__('message.unread')}}</span>
                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{verta($contact->created_at)->format('d F Y')}}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{verta($contact->created_at)->format('h:i A')}}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="flex items-center space-x-3 space-x-reverse">
                                            <a href="{{route('contacts.show',$contact->id)}}"
                                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                               title="{{__('message.show')}}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <div>
                                                <form action="{{route('contacts.destroy',$contact->id)}}" method="post"
                                                      id="delete-form-{{ $contact->id }}">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                    <button type="button" name="delete"
                                                            onclick="confirmDelete({{ $contact->id }})"
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                            title="{{__('message.delete')}}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if(!$customers->isEmpty())
                <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100"> کاربران </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                            <tr class="bg-gray-50 dark:bg-gray-900 text-right">
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.row')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.customer')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.created_at')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.is_active')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.role_type')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.mobile_verified_at')}}</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase dark:text-gray-400">{{__('message.operation')}}</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                            @foreach($customers as $index=>$customer)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 hover:cursor-pointer">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="mr-2 font-medium text-gray-900 dark:text-white">{{ $index }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="{{$customer->avatar->address??asset('images/user/avatar-profile.png')}}"
                                                 class="w-10 h-10 ml-3 rounded-full" alt="">
                                            <div>
                                                <div class="text-md font-medium text-gray-900 dark:text-white">{{$customer->fullName}}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400"
                                                     dir="ltr">{{$customer->mobile}}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">{{verta($customer->created_at)->format('d F Y')}}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{verta($customer->created_at)->format('h:i A')}}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($customer->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:bg-opacity-20 dark:text-blue-400">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-blue-500 rounded-full"></span>
                                        <span class="px-2">{{__('message.active')}}</span>
                                    </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-red-800 dark:bg-red-900 dark:bg-opacity-20 dark:text-red-400">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                        <span class="px-2">{{__('message.unactive')}}</span>
                                    </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($customer->role_type=='admin')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:bg-opacity-20 dark:text-blue-400">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-blue-500 rounded-full"></span>
                                        <span class="px-2">{{__('message.admin')}}</span>
                                    </span>
                                        @elseif($customer->role_type=='jobseeker')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:bg-opacity-20 dark:text-yellow-400">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-yellow-500 rounded-full"></span>
                                        <span class="px-2">{{__('message.jobseeker')}}</span>
                                    </span>
                                        @elseif($customer->role_type=='employer')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:bg-opacity-20 dark:text-yellow-400">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-yellow-500 rounded-full"></span>
                                        <span class="px-2">{{__('message.employer')}}</span>
                                    </span>
                                        @endif

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($customer->mobile_verified_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:bg-opacity-20 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                                        <span class="px-2">موبایل تایید شده</span>
                                    </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:bg-opacity-20 dark:text-red-400">
                                        <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                        <span class="px-2">موبایل تایید نشده</span>
                                    </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">

                                        <div class="flex items-center space-x-3 space-x-reverse">
                                            <a href="{{route('customers.show',$customer->id)}}"
                                               class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                               title="{{__('message.show')}}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.show', $customer->id) }}"
                                               class="text-indigo-400 hidden sm:block px-2"
                                               title="{{__('message.permissions')}}">
                                                <i class="fa-solid fa-user-check"></i>
                                            </a>
                                            <a href="{{route('customers.edit',$customer->id)}}"
                                               class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                               title="{{__('message.edit')}}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div>
                                                <form action="{{route('customers.destroy',$customer->id)}}"
                                                      method="post" id="delete-form-{{ $customer->id }}">
                                                    @csrf
                                                    {{method_field('DELETE')}}
                                                    <button type="button" name="delete"
                                                            onclick="confirmDelete({{ $customer->id }})"
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                            title="{{__('message.delete')}}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
