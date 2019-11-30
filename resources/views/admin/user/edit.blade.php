@extends('admin.base')

@section('content')
    <div class="layui-elem-quote">更新用户</div>
    <form class="layui-form" action="{{route('admin.user.update',['id'=>$user->id])}}" method="post">
        @include('admin.user._form')
    </form>
@endsection


