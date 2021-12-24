<script src="{{ asset('assets/plugins/jquery/jquery-2.1.3.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/plugins/pace-master/pace.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-blockui/jquery.blockui.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/plugins/switchery/switchery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/uniform/jquery.uniform.min.js') }}"></script>
<script src="{{ asset('assets/plugins/classie/classie.js') }}"></script>
<script src="{{ asset('assets/plugins/waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/plugins/3d-bold-navigation/js/main.js') }}"></script>
<script src="{{ asset('assets/plugins/waypoints/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-counterup/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.min.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.time.min.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.symbol.min.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.resize.min.js') }}"></script>
<script src="{{ asset('assets/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/curvedlines/curvedLines.js') }}"></script>
<script src="{{ asset('assets/plugins/metrojs/MetroJs.min.js') }}"></script>
<script src="{{ asset('assets/plugins/summernote-master/summernote.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}"></script>
<script src="{{ asset('assets/js/modern.js') }}"></script>
<script src="{{ asset('assets/js/pages/form-elements.js') }}"></script>

<script type="text/javascript">
    jQuery(document).ready(function ()
    {
        jQuery('select[name="search"]').on('change',function(){
            var Loader = jQuery(this).val();
            // console.log(countryID);
            if(Loader)
            {
                jQuery.ajax({
                    url : 'users/search/' +Loader,
                    type : "GET",
                    dataType : "html",
                    success: function(data)
                    {
                        console.log(data);
                        $('#tableDatas').html(data);
                    }
                });
            }
        });
    });
</script>