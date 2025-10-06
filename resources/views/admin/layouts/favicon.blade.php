@php
    $setting = App\Models\Setting::with(['logo','favicon'])->first();
@endphp
    <link rel="icon" href="{{$setting->favicon->address??asset('/images/favicon.ico')}}" type="image/png">
    <link rel="icon" href="{{$setting->favicon->address??asset('/images/favicon.ico')}}" type="image/ico">
    <link rel="icon" href="{{$setting->favicon->address??asset('/images/favicon.ico')}}" type="image/jpeg">
