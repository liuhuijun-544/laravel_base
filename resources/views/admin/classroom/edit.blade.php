@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑信息</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.classroom.update',['id'=>$info->id])}}" method="post">
                @include('admin.classroom._form')
            </form> 
        </div>
    </div>   
@endsection

<link rel="stylesheet" href="/js/formSelects-v4.css" />
@section('script')
  <script src="/js/formSelects-v4.js" type="text/javascript" charset="utf-8"></script>
    @include('admin.classroom._js')
@endsection
 