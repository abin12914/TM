<!-- Main Footer -->
<footer class="main-footer no-print">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        Version {{ env('APP_VERSION', 1.0) }}
    </div>
    <!-- Default to the left -->
    <strong><a href="{{ $settings->company_website or "#" }}">{{ $settings->company_name or "Free Version" }}</a></strong>.
</footer>