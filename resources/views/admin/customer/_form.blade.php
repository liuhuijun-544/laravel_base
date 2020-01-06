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
                <input type="text" name="child_name" value="{{$info->child_name??old('child_name')}}" lay-verify="required" placeholder="请输入孩子姓名" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">家长姓名</label>
            <div class="layui-input-block">
                <input type="text" name="parent_name" value="{{$info->parent_name??old('parent_name')}}"  placeholder="请输入家长姓名" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>孩子年龄</label>
            <div class="layui-input-block">
                <input type="number" name="child_age" value="{{$info->child_age??old('child_age')}}" lay-verify="required" placeholder="请输入孩子年龄" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">电话</label>
            <div class="layui-input-block">
                <input type="text" name="mobile" value="{{$info->mobile??old('mobile')}}"  placeholder="请输入电话" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label"><span style="color: red;">*</span>信息渠道</label>
            <div class="layui-input-block">
                <select name="channel" lay-filter="channel"  lay-verify="required" lay-search>
                    <option value="">请选择</option>
                    @foreach($channel as $value)
                        <option value="{{ $value }}"  @if($value==$info->channel)selected @endif >{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label">渠道详情</label>
            <div class="layui-input-block">
                <select name="channel_detail" lay-search>
                    @if($info->channel_detail)
                        <option value="{{ $info->channel_detail }}">{{ $info->channel_detail }}</option>
                    @elseif($info->channel && $detail_channel)
                        @foreach($detail_channel as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">孩子小区</label>
            <div class="layui-input-block">
                <input type="text" name="child_area" value="{{$info->child_area??old('child_area')}}" placeholder="请输入孩子小区" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">资源描述</label>
            <div class="layui-input-block">
                <textarea name="describe_source" style="width:100%;height:90px;resize:none;border-color: #e6e6e6;">{{$info->describe_source??old('describe_source')}}</textarea>
            </div>
        </div>
    </div>
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label">信息编号</label>
            <div class="layui-input-block">
                <input  type="text" name="identifier" value="{{$info->identifier??old('identifier')}}"  placeholder="自动生成" class="layui-input layui-disabled" readonly style="background-color: #eeeeee">
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                <select name="child_sex">
                    <option value="1"  @if(1==$info->child_sex)selected @endif >男孩</option>
                    <option value="2"  @if(2==$info->child_sex)selected @endif >女孩</option>
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>出生日期</label>
            <div class="layui-input-block">
                <input type="text" name="child_birthday" id="child_birthday" value="{{$info->child_birthday??old('child_birthday')}}" lay-verify="required" placeholder="请选择出生日期" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>手机</label>
            <div class="layui-input-block">
                <input type="text" name="phone" value="{{$info->phone??old('phone')}}" lay-verify="required|phone"  placeholder="请输入手机号" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">详情说明</label>
            <div class="layui-input-block">
                <input type="text" name="explain" value="{{$info->explain??old('explain')}}"  placeholder="请输入详情说明" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">孩子学校</label>
            <div class="layui-input-block">
                <input type="text" name="child_school" value="{{$info->child_school??old('child_school')}}"  placeholder="请输入孩子学校" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">信息状态</label>
            <div class="layui-input-block">
                <input type="hidden" name="type" value="0" class="layui-input" >
                <input type="text" value="潜在信息" class="layui-input layui-disabled" readonly style="background-color: #eeeeee;">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">销售描述</label>
            <div class="layui-input-block">
                <textarea name="describe_sales" style="width:100%;height:90px;resize:none;border-color: #e6e6e6;">{{$info->describe_sales??old('describe_sales')}}</textarea>
            </div>
        </div>
    </div>
</div>
@if($info->type==0)
    <div class="layui-row layui-col-space15" style="margin-top:10px;border-bottom: 1px solid #f6f6f6"><h3 class="label-info">潜在信息</h3></div>
    <div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6">
        <div class="layui-col-md6">
            <div class="layui-card">
                <label for="" class="layui-form-label">收集日期</label>
                <div class="layui-input-block">
                    <input type="text" name="collect_at" value="{{$info->collect_at??old('collect_at')}}" id="collect_at" placeholder="请选择日期" class="layui-input">
                </div>
            </div>
            <div class="layui-card">
                <label for="" class="layui-form-label">收集地点</label>
                <div class="layui-input-block">
                    <input type="text" name="collect_area" value="{{$info->collect_area??old('collect_area')}}" placeholder="请输入地址" class="layui-input">
                </div>
            </div>
            <div class="layui-card">
                <label class="layui-form-label"><span style="color: red;">*</span>潜在信息状态</label>
                <div class="layui-input-block">
                    <select name="status_hidden" lay-verify="required" lay-search>
                        <option value="">请选择</option>
                        @foreach($status_array as $k => $value)
                            <option value="{{ $k }}"  @if($k==$info->status_hidden)selected @endif >{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-card">
                <label class="layui-form-label"><span style="color: red;">*</span>下次回访日期</label>
                <div class="layui-input-block">
                    <input type="text" name="visit_at" value="{{$info->visit_at??old('visit_at')}}" lay-verify="required" id="visit_at" placeholder="请选择日期" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="layui-card">
                <label for="" class="layui-form-label">兼职编号</label>
                <div class="layui-input-block">
                    <input  type="text" name="part_number" value="{{$info->part_number??old('part_number')}}"  placeholder="请输入兼职编号" class="layui-input" >
                </div>
            </div>
            <div class="layui-card">
                <label for="" class="layui-form-label">状态说明</label>
                <div class="layui-input-block">
                    <input type="text" name="status_describe"  value="{{$info->status_describe??old('status_describe')}}" placeholder="请输入说明" class="layui-input">
                </div>
            </div>
            <div class="layui-card">
                <label for="" class="layui-form-label">客户类型</label>
                <div class="layui-input-block">
                    <select name="customer_type"  lay-search>
                        <option value="">请选择</option>
                        @foreach($customer_type as $value)
                            <option value="{{ $value }}"  @if($value==$info->customer_type)selected @endif >{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
@elseif($info->type==1)
    <div class="layui-row layui-col-space15" style="margin-top:10px;border-bottom: 1px solid #f6f6f6"><h3 class="label-info">约访信息</h3></div>
    <div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6">
        <div class="layui-col-md6">
            <div class="layui-card">
                <label for="" class="layui-form-label"><span style="color: red;">*</span>约访-信息状态</label>
                <div class="layui-input-block">
                    <select name="status_appointment" lay-verify="required" lay-search>
                        <option value=""></option>
                        @foreach($status_appointment as $k=>$v)
                            <option value="{{ $k }}"  @if($k==$info->status_appointment)selected @endif >{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="layui-card">
                <label for="" class="layui-form-label"><span style="color: red;">*</span>下次回访时间</label>
                <div class="layui-input-block">
                    <input type="text" id="visit_at_2" name="visit_at" placeholder="请选择回访时间" value="{{$info->visit_at??old('visit_at')}}"  class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="layui-card">
                <label for="" class="layui-form-label">约访描述</label>
                <div class="layui-input-block">
                    <input  type="text" name="appointment_describe" placeholder="请输入约访描述" value="{{$info->appointment_describe??old('appointment_describe')}}"  class="layui-input" >
                </div>
            </div>
            <div class="layui-card">
                <label for="" class="layui-form-label">报名意向度</label>
                <div class="layui-input-block">
                    <input type="number" name="appointment_sign" placeholder="请输入数字" value="{{$info->appointment_sign??old('appointment_sign')}}"  class="layui-input">
                </div>
            </div>
        </div>
    </div>
@elseif($info->type==2)
    <div class="layui-row layui-col-space15" style="margin-top:10px;border-bottom: 1px solid #f6f6f6"><h3 class="label-info">到访信息</h3></div>
    <div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6">
        <div class="layui-col-md6">
            <div class="layui-card">
                <label for="" class="layui-form-label"><span style="color: red;">*</span>到访时间</label>
                <div class="layui-input-block">
                    <input type="text" name="arrive_at" id="arrive_at" value="{{$info->arrive_at?date('Y-m-d H:i',strtotime($info->arrive_at)):old('arrive_at')}}" lay-verify="required" class="layui-input">
                </div>
            </div>
            <div class="layui-card">
                <label for="" class="layui-form-label"><span style="color: red;">*</span>是否签约</label>
                <div class="layui-input-block">
                    <select name="is_sign" lay-verify="required">
                        <option value="0"  @if(0==$info->is_sign)selected @endif >未签约</option>
                        <option value="1"  @if(1==$info->is_sign)selected @endif >已签约</option>
                    </select>
                </div>
            </div>
            <div class="layui-card">
                <label class="layui-form-label">到访人</label>
                <div class="layui-input-block">
                    <input type="text" name="arrive_person" value="{{$info->arrive_person??old('arrive_person')}}" class="layui-input">
                </div>
            </div>
            <div class="layui-card">
                <label class="layui-form-label">到访描述</label>
                <div class="layui-input-block">
                    <input type="text" name="arrive_describe" value="{{$info->arrive_describe??old('arrive_describe')}}" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="layui-card">
                <label for="" class="layui-form-label">预计决策人</label>
                <div class="layui-input-block">
                    <input  type="text" name="arrive_decision" value="{{$info->arrive_decision??old('arrive_decision')}}" class="layui-input" >
                </div>
            </div>
            <div class="layui-card">
                <label for="" class="layui-form-label">未报名拒绝点</label>
                <div class="layui-input-block">
                    <input type="text" name="refuse_reason"  value="{{$info->refuse_reason??old('refuse_reason')}}" class="layui-input">
                </div>
            </div>
            <div class="layui-card">
                <label for="" class="layui-form-label">下次跟进计划</label>
                <div class="layui-input-block">
                    <input type="text" name="arrive_plan"  value="{{$info->arrive_plan??old('arrive_plan')}}" class="layui-input">
                </div>
            </div>
            <div class="layui-card">
                <label for="" class="layui-form-label">下次回访日期</label>
                <div class="layui-input-block">
                    <input type="text" id="visit_at" name="visit_at"  value="{{$info->visit_at}}" class="layui-input">
                </div>
            </div>
        </div>
    </div>
@endif
<div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6"><h3 class="label-info">系统信息</h3></div>
<div class="layui-row layui-col-space15" style="padding: 10px 0px;">
    <div class="layui-card">
        <label for="" class="layui-form-label">负责人</label>
        <div class="layui-input-block">
            <select name="responer" lay-search>
            <option value="">请选择</option>
            @foreach($users as $k => $v)
                <option value="{{ $k }}"  @if($k==$info->responer)selected @endif >{{ $v }}</option>
            @endforeach
            </select>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit"   class="layui-btn" lay-submit="formDemo" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.customer')}}" >返 回</a>
    </div>
</div>
