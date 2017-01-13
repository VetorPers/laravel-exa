<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
</script>

{{--时间选择器--}}
<script src="{{ asset('/plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js') }}"></script>
{{--绘制图表--}}
<script src="{{ asset('/plugins/morris/raphael-min.js') }}"></script>
<script src="{{ asset('/plugins/morris/morris.min.js') }}"></script>
{{--图片查看器--}}
<script src="{{asset('/plugins/pic-selector/viewer.min.js')}}"></script>
{{--上传图片--}}
<script src="{{asset('/plugins/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
{{--引入vue--}}
<script type="text/javascript" src="{{asset('js/vue.min.js')}}"></script>

@stack('scripts')