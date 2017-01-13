@extends('vendor.adminlte.layouts.app')

@section('htmlheader_title')
    商品分类
@endsection

@section('nav_1st')
    类型
@endsection

@section('nav_2nd')
    列表
@endsection

@section('main-content')
    <div class="container spark-screen">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">商品分类</div>

                    <div class="panel-body">
                        <a href="{{ url('/posts/create') }}" class="btn btn-primary btn-xs" title="Add New Post"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a>

                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th><th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                             @foreach($posts as $item)
                                 <tr>
                                 <td>{{ $item->id }}</td>
                                                                    
                                                                    <td>
                                                                        <a href="{{ url('/posts/' . $item->id) }}" class="btn btn-success btn-xs" title="View Post"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"/></a>
                                                                        <a href="{{ url('/posts/' . $item->id . '/edit') }}" class="btn btn-primary btn-xs" title="Edit Post"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
                                                                        {!! Form::open([
                                                                            'method'=>'DELETE',
                                                                            'url' => ['/posts', $item->id],
                                                                            'style' => 'display:inline'
                                                                        ]) !!}
                                                                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Post" />', array(
                                                                                    'type' => 'submit',
                                                                                    'class' => 'btn btn-danger btn-xs',
                                                                                    'title' => 'Delete Post',
                                                                                    'onclick'=>'return confirm("Confirm delete?")'
                                                                            )) !!}
                                                                        {!! Form::close() !!}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                            </tbody>
                        </table>
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