<style type="text/css">
    .layui-input-block input,.layui-input-inline input{
        background-color: #eeeeee;
    }
    .layui-input-block textarea{
        background-color: #eeeeee;
        padding: 5px;
    }
    .course_detail div{
        float: left;
        line-height: 38px;
    }
    .course_detail .layui-input-block{
        margin-left: 0;}
    .margin{
        margin-left: 15px;
    }
</style>
@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-left: 0px;">
                    <a  class="layui-btn layui-btn-primary" href="{{route('admin.classroom')}}" style="height: 30px;line-height: 30px;">返 回</a>
                    @can('classroom.editPlan')
                        <a class="layui-btn" href="{{route('admin.classroom.editPlan',['id'=>$info->id])}}" style="height: 30px;line-height: 30px;">编辑</a>
                    @endcan

                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <div class="layui-row layui-col-space15" style="padding: 10px 0px;">
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label">月份</label>
                        <div class="layui-input-inline">
                            <input type="text" name="year" value="{{$info->year}}年"  disabled class="layui-input">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="month" value="{{$info->month}}月"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">教室</label>
                        <div class="layui-input-block">
                            <input type="text" name="parent_name" value="{{$info->classroom->name}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">班级</label>
                        <div class="layui-input-block">
                            <input type="text" name="child_age" value="{{$info->course->identifier}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">老师</label>
                        <div class="layui-input-block">
                            <input type="text" name="mobile" value="{{$info->teacher_info->name}}"  disabled class="layui-input">
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-row layui-col-space15" style="padding: 10px 0px;">
                <div class="layui-col-md1">
                    <label for="" class="layui-form-label">时间</label>
                    <div class="layui-input-block course_detail" style="min-width: 900px;">
                        @for($i=0;$i<count($info['detail']);$i++)
                        <div class="layui-input-block" style="min-width:900px; @if($i>0) margin-top: 15px; @endif">
                            <div class="layui-input-inline">课程编号：</div>
                            <div class="layui-input-inline" style="width: 100px;"><input type="text" value="{{$info['detail'][$i]->course_code}}" disabled class="layui-input"></div>
                            <div class="layui-input-inline margin">课程：</div>
                            <div class="layui-input-inline"><input type="text" value="{{$info['detail'][$i]->course_attribute->name}}" disabled class="layui-input"></div>
                            <div class="layui-input-inline margin">开始时间：</div>
                            <div class="layui-input-inline" style="width: 140px;"><input type="text" value="{{date('Y-m-d H:i',strtotime($info['detail'][$i]->starttime))}}" disabled class="layui-input"></div>
                            <div class="layui-input-inline margin">结束时间：</div>
                            <div class="layui-input-inline" style="width: 140px;"><input type="text" value="{{date('Y-m-d H:i',strtotime($info['detail'][$i]->endtime))}}" disabled class="layui-input"></div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="/js/formSelects-v4.css" />
@section('script')
    <script src="/js/formSelects-v4.js" type="text/javascript" charset="utf-8"></script>
    @include('admin.classroom._js')
@endsection