@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
    年份管理
@endsection

@section('nav_1st')
    年份
@endsection

@section('nav_2nd')
    新增
@endsection


@section('main-content')
    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">年份管理</div>
                    <div class="panel-body">
                        <form action="">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">开始时间</label>
                                <div class="col-sm-10">
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type='text' name="act_start" class="form-control"
                                               value=""
                                               style="color: #000" id="act_start"/>
                                                <span class="input-group-addon"><span
                                                            class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>

                            <div class="box box-success" style="border:none">
                                <div class="box-header with-border">
                                    <h3 class="box-title">项目销量对比图</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                    class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                                    class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body chart-responsive">
                                    <div class="chart" id="myfirstchart"
                                         style="height: 300px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
                                    </div>
                                </div>
                                <!-- /.box-body -->
                                <div style="text-align: center;margin-top: -10px">
                                    <img src="{{asset('/img/colo3.png')}}" alt="">
                                    <span id="color_gtype1" style="font-size: 10px;"></span>&nbsp;
                                    <img src="{{asset('/img/colo4.png')}}" alt="">
                                    <span id="color_gtype2" style="font-size: 10px;"></span>
                                </div>
                            </div>

                            <ul id="dowebok" style="list-style: none">
                                <li class="dowebok-li-item"
                                    style="display: inline-block;width: auto;border: 3px solid #3c8dbc"><img
                                            class="dowebok-img-item" data-original="{{asset('img/avatar.png')}}"
                                            src="{{asset('img/avatar.png')}}" alt="" style="width: 50px;height: 50px;">
                                </li>
                                <li class="dowebok-li-item"
                                    style="display: inline-block;width: auto;border: 3px solid #3c8dbc"><img
                                            class="dowebok-img-item" data-original="{{asset('img/avatar2.png')}}"
                                            src="{{asset('img/avatar2.png')}}" alt="" style="width: 50px;height: 50px;">
                                </li>
                            </ul>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">图片</label>
                                <div class="col-sm-10" style="padding: 0 190px;">
                                    <div id="queue"></div>
                                    <div id="imgBox">
                                        <input type="hidden" id="act_img" class="act_img" name="act_img">
                                        <img class="img" src="{{asset('/img/default_logo.png')}}" height="130"
                                             border="0"/>
                                    </div>
                                    <input id="file_upload" name="file_upload" type="file" multiple="true">
                                </div>

                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $(function () {
        $('#datetimepicker2').datetimepicker({
            locale: 'en_gb'
        });

        $("#file_upload").uploadify({
            'buttonText': '图片上传',
            'swf': '{{asset('/plugins/uploadify/uploadify.swf')}}',
            'uploader': '{{url('upload')}}',
//            'queueSizeLimit ': 4,
            'fileSizeLimit': '2MB',
            'multi ': false,
            'onUploadSuccess': function (file, data, response) {
                $imgsrc = $('.img')[0].src;
                console.log(data);
                $flag = $imgsrc.indexOf('uploads');
                if ($flag !== -1) {
                    $imgNode = '<img class="img" src="/public/'+data+'" height="130" border="0"/>';
                    $('#imgBox').append($imgNode);
                } else {
                    $('.img').attr('src', '/'+data);
                    $('#act_img').val(data);
                }
            }
        });

    });

    var viewer = new Viewer(document.getElementById('dowebok'), {
        url: 'data-original'
    });

</script>
<script>
    new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'myfirstchart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.
        data: [
            {year: '2008', value: 20},
            {year: '2009', value: 10},
            {year: '2010', value: 5},
            {year: '2011', value: 5},
            {year: '2012', value: 20}
        ],
        // The name of the data record attribute that contains x-values.
        xkey: 'year',
        // A list of names of data record attributes that contain y-values.
        ykeys: ['value'],
        // Labels for the ykeys -- will be displayed when you hover over the
        // chart.
        labels: ['Value']
    });
</script>

@endpush
