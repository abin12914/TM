<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
        Version {{ env('APP_VERSION', 1.0) }}
    </div>
    <!-- Default to the left -->
    <strong><a href="{{ env('COMPANY_WEBSITE', '#') }}">{{ env('COMPANY_NAME', 'Free Version') }}</a></strong>.
</footer>