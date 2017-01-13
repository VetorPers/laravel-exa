@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
    商品分类
@endsection

@section('nav_1st')
    类型
@endsection

@section('nav_2nd')
    新增
@endsection

@section('main-content')
 <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Post</div>

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>失败!</strong> 输入不符合要求<br><br>
                            {!! implode('<br>', $errors->all()) !!}
                        </div>
                    @endif

                    <div class="panel-body">
                       {!! Form::open(['url' => '/posts', 'class' => 'form-horizontal', 'files' => true]) !!}

                                               @include ('admin.posts.form')

                                               {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('#goodadmin').addClass('active');
</script>
@endpush