<style type="text/css">
    .layui-input-block textarea{
        padding: 5px;
    }
    .course_detail div{
        float: left;
        line-height: 38px;
    }
    .course_detail .layui-input-block{
        margin-left: 0;
    }
    .margin{
        margin-left: 15px;
    }
    .detail_del{
        margin-left: 10px;
    }
</style>
@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>课程安排</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.classroom.updatePlan',['id'=>$info->id])}}" method="post">
                @include('admin.classroom._formPlan')
            </form>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="/js/formSelects-v4.css" />
@section('script')
    <script src="/js/formSelects-v4.js" type="text/javascript" charset="utf-8"></script>
    @include('admin.classroom._js')
@endsection