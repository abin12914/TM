<!DOCTYPE html>
<html>
    <!-- sections/head.main.blade -->
    @include('sections.head')

    {{-- additional stylesheet includes --}}
    @section('stylesheets')
    @show

    <body class="hold-transition login-page">
        <!-- Content Wrapper. Contains page content -->
        @section('content')
        @show

        <!-- REQUIRED JS SCRIPTS -->
        @include('sections.scripts')
        
        {{-- additional js scripts includes --}}
        @section('scripts')
        @show
    </body>
</html>
