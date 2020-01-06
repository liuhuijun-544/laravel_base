<style type="text/css">
    .layui-input-block textarea{
        padding: 10px;
    }
</style>
{{csrf_field()}}


<div class="layui-row layui-col-space15" style="border-bottom: 1px solid #f6f6f6"><h3 class="label-info">基本信息</h3></div>
<div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6">
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>孩子姓名</label>
            <div class="layui-input-block">
                <input type="text" name="name" value="{{$info->name??old('name')}}" lay-verify="required" placeholder="请输入孩子姓名" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">家长姓名</label>
            <div class="layui-input-block">
                <input type="text" name="parent_name" value="{{$info->parent_name??old('parent_name')}}"  placeholder="请输入家长姓名" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">孩子年龄</label>
            <div class="layui-input-block">
                <input type="number" name="age" value="{{$info->age??old('age')}}"  placeholder="请输入孩子年龄" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">电话</label>
            <div class="layui-input-block">
                <input type="text" name="mobile" value="{{$info->mobile??old('mobile')}}"  placeholder="请输入电话" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label">备用联系人1</label>
            <div class="layui-input-block">
                <input type="text" name="contact_one" value="{{$info->contact_one??old('contact_one')}}"  placeholder="请输入备用联系人1" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label">备用联系方式1</label>
            <div class="layui-input-block">
                <input type="text" name="contact_one_phone" value="{{$info->contact_one_phone??old('contact_one_phone')}}"  placeholder="请输入备用联系方式1" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">孩子小区</label>
            <div class="layui-input-block">
                <input type="text" name="child_area" value="{{$info->child_area??old('child_area')}}" placeholder="请输入孩子小区" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">动手能力</label>
            <div class="layui-input-block">
                <input type="text" name="student_diy" value="{{$info->student_diy??old('student_diy')}}" placeholder="请输入动手能力" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">独立性</label>
            <div class="layui-input-block">
                <input type="text" name="student_independence" value="{{$info->student_independence??old('student_independence')}}" placeholder="请输入独立性" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label">学员状态</label>
            <div class="layui-input-block">
                <select name="status">
                    <option value=""></option>
                    @foreach($status as $item)
                        <option value="{{$item}}"  @if($item==$info->status)selected @endif >{{$item}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label">学员编号</label>
            <div class="layui-input-block">
                <input  type="text" name="identifier" value="{{$info->identifier??old('identifier')}}"  placeholder="自动生成" class="layui-input layui-disabled" readonly style="background-color: #eeeeee">
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                <select name="sex">
                    <option value="1"  @if(1==$info->sex)selected @endif >男孩</option>
                    <option value="2"  @if(2==$info->sex)selected @endif >女孩</option>
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">出生日期</label>
            <div class="layui-input-block">
                <input type="text" name="birthday" id="birthday" value="{{$info->birthday??old('birthday')}}" placeholder="请选择出生日期" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>手机</label>
            <div class="layui-input-block">
                <input type="text" name="phone" value="{{$info->phone??old('phone')}}" lay-verify="required|phone"  placeholder="请输入手机号" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">备用联系人2</label>
            <div class="layui-input-block">
                <input type="text" name="contact_two" value="{{$info->contact_two??old('contact_two')}}"  placeholder="请输入备用联系人2" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">备用联系方式2</label>
            <div class="layui-input-block">
                <input type="text" name="contact_two_phone" value="{{$info->contact_two_phone??old('contact_two_phone')}}"  placeholder="请输入备用联系方式2" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">孩子学校</label>
            <div class="layui-input-block">
                <input type="text" name="child_school" value="{{$info->child_school??old('child_school')}}"  placeholder="请输入孩子学校" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">理解能力</label>
            <div class="layui-input-block">
                <input type="text" name="student_expression" value="{{$info->student_expression??old('student_expression')}}"  placeholder="请输入孩子理解能力" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">描述</label>
            <div class="layui-input-block">
                <textarea name="note" style="width:100%;height:90px;resize:none;border-color: #e6e6e6;">{{$info->note??old('note')}}</textarea>
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
                <select name="course_id" lay-filter="course_id">
                    <option value=""></option>
                    @foreach($course as $k=>$v)
                        <option value="{{$k}}"  @if($k==$info->course_id)selected @endif >{{$v}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">主讲老师</label>
            <div class="layui-input-block">
                <input type="text" id="lecturer" value="{{$lecturer}}"  disabled class="layui-input layui-disabled">
            </div>
        </div>
    </div>
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label">进班日期</label>
            <div class="layui-input-block">
                <input type="text" name="enter_class_date" id="enter_class_date" value="{{$info->enter_class_date??old('enter_class_date')}}"  placeholder="请选择进班日期" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">教务老师</label>
            <div class="layui-input-block">
                <input type="text" id="teacher" value="{{$teacher}}" disabled class="layui-input layui-disabled">
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit"   class="layui-btn" lay-submit="formDemo" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.student')}}" >返 回</a>
    </div>
</div>
