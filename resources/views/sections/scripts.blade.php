<!-- jQuery 3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/js/dist/adminlte.min.js"></script>
<!-- Select2 -->
<script src="/bower_components/select2/dist/select2.min.js"></script>
<!-- bootstrap-datepicker -->
<script src="/bower_components/bootstrap-datepicker/dist/bootstrap-datepicker.min.js"></script>
<!-- date-range-picker -->
<!-- sweet alert -->
<script src="/js/plugins/sweet_alert/sweetalert2.all.min.js"></script>
{{-- <script src="/js/plugins/sweet_alert/sweetalert.js"></script> --}}
{{-- Custom JS --}}
<script src="/js/main.js?rndstr={{ rand(1000,9999) }}"></script>
{{-- default date for form auto filling --}}
<script type="text/javascript">
    var defaultDate = '{{ !empty($settings->default_date) ? Carbon\Carbon::parse($settings->default_date)->format('d-m-Y') : "" }}';
</script>