<div class="box-header visible-print-block text-center">
    <h3>{{ $settings->company_name or env('APP_NAME', 'TMS') }}</h3>
    <h4>{{ $settings->company_address }}</h4>
    <h5>{{ $settings->company_phones }}</h5>
</div>
<div class="visible-print-block">
    <h4><u>@yield('title')</u></h4>
</div>