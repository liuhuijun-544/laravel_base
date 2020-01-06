@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加信息</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.customer.save')}}" method="post">
                @include('admin.customer._form')
            </form> 
        </div>
    </div>
@endsection

    <link rel="stylesheet" href="/js/formSelects-v4.css" />
@section('script')
<script src="/js/formSelects-v4.js" type="text/javascript" charset="utf-8"></script>
    @include('admin.customer._js')
@endsection
 