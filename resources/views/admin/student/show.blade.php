<style type="text/css">
    .layui-input-block input{
        background-color: #eeeeee;
    }
    .layui-input-block textarea{
        background-color: #eeeeee;
        padding: 5px;
    }
</style>
@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <div class="layui-row layui-col-space15" style="border-bottom: 1px solid #f6f6f6"><h3 class="label-info">基本信息</h3></div>
            <div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6">
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label">孩子姓名</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" value="{{$info->name}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">家长姓名</label>
                        <div class="layui-input-block">
                            <input type="text" name="parent_name" value="{{$info->parent_name}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">孩子年龄</label>
                        <div class="layui-input-block">
                            <input type="number" name="age" value="{{$info->age}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">电话</label>
                        <div class="layui-input-block">
                            <input type="text" name="mobile" value="{{$info->mobile}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label class="layui-form-label">备用联系人1</label>
                        <div class="layui-input-block">
                            <input type="text" name="contact_one" value="{{$info->contact_one}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label class="layui-form-label">备用联系方式1</label>
                        <div class="layui-input-block">
                            <input type="text" name="contact_one_phone" value="{{$info->contact_one_phone}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">孩子小区</label>
                        <div class="layui-input-block">
                            <input type="text" name="child_area" value="{{$info->child_area}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">动手能力</label>
                        <div class="layui-input-block">
                            <input type="text" name="student_diy" value="{{$info->student_diy}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">独立性</label>
                        <div class="layui-input-block">
                            <input type="text" name="student_independence" value="{{$info->student_independence}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label class="layui-form-label">学员状态</label>
                        <div class="layui-input-block">
                            <input type="text" name="status" value="{{$info->status}}" disabled class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label">学员编号</label>
                        <div class="layui-input-block">
                            <input  type="text" name="identifier" value="{{$info->identifier}}"  class="layui-input" disabled>
                        </div>
                    </div>
                    <div class="layui-card">
                        <label class="layui-form-label">性别</label>
                        <div class="layui-input-block">
                            <input  type="text" name="sex" value="{{$info->sex==1?'男':'女'}}"  class="layui-input" disabled>
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">出生日期</label>
                        <div class="layui-input-block">
                            <input type="text" name="birthday" value="{{$info->birthday}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">手机</label>
                        <div class="layui-input-block">
                            <input type="text" name="phone" value="{{$info->phone}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">备用联系人2</label>
                        <div class="layui-input-block">
                            <input type="text" name="contact_two" value="{{$info->contact_two}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">备用联系方式2</label>
                        <div class="layui-input-block">
                            <input type="text" name="contact_two_phone" value="{{$info->contact_two_phone}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">孩子学校</label>
                        <div class="layui-input-block">
                            <input type="text" name="child_school" value="{{$info->child_school}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">理解能力</label>
                        <div class="layui-input-block">
                            <input type="text" name="student_expression" value="{{$info->student_expression}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">描述</label>
                        <div class="layui-input-block">
                            <textarea name="note" disabled style="width:100%;height:90px;resize:none;border-color: #e6e6e6;">{{$info->note}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6"><h3 class="label-info">班级信息</h3></div>
            <div class="layui-row layui-col-space15" style="padding: 10px 0px;">
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label">班级</label>
                        <div class="layui-input-block">
                            <input type="text" name="course_id" value="{{$info->course->identifier}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">主讲老师</label>
                        <div class="layui-input-block">
                            <input type="text" value="{{$info->course->teacher_1->name}}"  disabled class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label">进班日期</label>
                        <div class="layui-input-block">
                            <input type="text" name="enter_class_date"  value="{{$info->enter_class_date}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">教务老师</label>
                        <div class="layui-input-block">
                            <input type="text" id="teacher" value="{{$info->course->teacher_2->name}}" disabled class="layui-input">
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <a  class="layui-btn" href="{{route('admin.student')}}" >返 回</a>
                    @can('student.edit')
                        <a class="layui-btn" href="{{route('admin.student.edit',['id'=>$info->id])}}">编辑</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

<link rel="stylesheet" href="/js/formSelects-v4.css" />
@section('script')
    <script src="/js/formSelects-v4.js" type="text/javascript" charset="utf-8"></script>
    @include('admin.customer._js')
@endsection
