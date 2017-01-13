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
                    <div class="panel-heading">Edit Post {{ $post->id }}</div>

                     @if ($errors->any())
                                                <ul class="alert alert-danger">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif

                    <div class="panel-body">
                         {!! Form::model($post, [
                                                    'method' => 'PATCH',
                                                    'url' => ['/posts', $post->id],
                                                    'class' => 'form-horizontal',
                                                    'files' => true
                                                ]) !!}

                                                @include ('admin.posts.form', ['submitButtonText' => 'Update'])

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