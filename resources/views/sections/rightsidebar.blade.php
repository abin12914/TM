<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-settings-tab">
            <h3 class="control-sidebar-heading">General Settings</h3>

            <div class="form-group">
                <label class="control-sidebar-subheading">
                    Track Certificates
                    <input type="checkbox" id="rsb_track_certificate" value="1" name="track_certificate" class="pull-right" {{ $settings->track_certificate ? "checked" : "" }}>
                </label>
                <p>
                    Track certificate expiry on calendar
                </p>
            </div><br>
            <!-- /.form-group -->
            <div class="form-group">
                <label class="control-sidebar-subheading">
                    Default Date
                    <div style="width: 50%;" class="pull-right">
                        <input type="text" class="form-control decimal_number_only datepicker_reg" name="default_date" id="rsb_default_date" placeholder="Default date">
                    </div>
                </label>
                <p>
                    Default date for form auto filling
                </p>
            </div>
            <!-- /.form-group -->
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>