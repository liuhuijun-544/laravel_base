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
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-form-item">
                <div class="layui-input-block" style="margin-left: 0px;">
                    <a  class="layui-btn layui-btn-primary" href="{{route('admin.customer')}}" style="height: 30px;line-height: 30px;">返 回</a>
                    @can('customer.edit')
                        <a class="layui-btn" href="{{route('admin.customer.edit',['id'=>$info->id])}}" style="height: 30px;line-height: 30px;">编辑</a>
                    @endcan
                    @if($info->type==0)
                        <button type="button" id="turn_on" data-id="{{$info->id}}" data-status="1" class="layui-btn layui-btn-normal" style="height: 30px;line-height: 30px;">转为约访信息</button>
                    @elseif($info->type==1)
                        <button type="button" id="turn_on" data-id="{{$info->id}}" data-status="2" class="layui-btn layui-btn-normal" style="height: 30px;line-height: 30px;">转为到访信息</button>
                    @elseif($info->type==2&&$info->is_turn!=1)
                        <button type="button" id="turn_student" data-id="{{$info->id}}" data-status="3" class="layui-btn layui-btn-normal" style="height: 30px;line-height: 30px;">转为学员</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <div class="layui-row layui-col-space15" style="border-bottom: 1px solid #f6f6f6"><h3 class="label-info">基本信息</h3></div>
            <div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6">
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label"><span style="color: red;">*</span>孩子姓名</label>
                        <div class="layui-input-block">
                            <input type="text" name="child_name" value="{{$info->child_name}}" lay-verify="required" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">家长姓名</label>
                        <div class="layui-input-block">
                            <input type="text" name="parent_name" value="{{$info->parent_name}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label"><span style="color: red;">*</span>孩子年龄</label>
                        <div class="layui-input-block">
                            <input type="number" name="child_age" value="{{$info->child_age}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">电话</label>
                        <div class="layui-input-block">
                            <input type="text" name="mobile" value="{{$info->mobile}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label class="layui-form-label"><span style="color: red;">*</span>信息渠道</label>
                        <div class="layui-input-block">
                            <input type="text" name="channel" value="{{$info->channel}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label class="layui-form-label">渠道详情</label>
                        <div class="layui-input-block">
                            <input type="text" name="channel_detail" value="{{$info->channel_detail}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">孩子小区</label>
                        <div class="layui-input-block">
                            <input type="text" name="child_area" value="{{$info->child_area}}"  class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">资源描述</label>
                        <div class="layui-input-block">
                            <textarea name="describe_source" disabled style="width:100%;height:90px;resize:none">{{$info->describe_source}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label">信息编号</label>
                        <div class="layui-input-block">
                            <input  type="text" name="identifier" value="{{$info->identifier}}"  class="layui-input" disabled >
                        </div>
                    </div>
                    <div class="layui-card">
                        <label class="layui-form-label">性别</label>
                        <div class="layui-input-block">
                            <input  type="text" name="child_sex" value="{{$info->child_sex==1?'男':'女'}}"  class="layui-input" disabled >
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label"><span style="color: red;">*</span>出生日期</label>
                        <div class="layui-input-block">
                            <input type="text" name="child_birthday" value="{{$info->child_birthday}}" disabled lay-verify="required"  class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label"><span style="color: red;">*</span>手机</label>
                        <div class="layui-input-block">
                            <input type="text" name="phone" value="{{$info->phone}}" lay-verify="required|phone" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">详情说明</label>
                        <div class="layui-input-block">
                            <input type="text" name="explain" value="{{$info->explain}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">孩子学校</label>
                        <div class="layui-input-block">
                            <input type="text" name="child_school" value="{{$info->child_school}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">信息状态</label>
                        <div class="layui-input-block">
                            <input type="hidden" name="type" value="0" class="layui-input" >
                            <input type="text" value="潜在信息" class="layui-input" disabled style="background-color: #eeeeee;">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">销售描述</label>
                        <div class="layui-input-block">
                            <textarea name="describe_sales" disabled style="width:100%;height:90px;resize:none">{{$info->describe_sales}}</textarea>
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
                                <input type="text" name="collect_at" value="{{$info->collect_at}}"  disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-card">
                            <label for="" class="layui-form-label">收集地点</label>
                            <div class="layui-input-block">
                                <input type="text" name="collect_area" value="{{$info->collect_area}}" disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-card">
                            <label class="layui-form-label"><span style="color: red;">*</span>潜在信息状态</label>
                            <div class="layui-input-block">
                                <input type="text" name="status_hidden" value="{{$status_array[$info->status_hidden]}}" disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-card">
                            <label class="layui-form-label"><span style="color: red;">*</span>下次回访日期</label>
                            <div class="layui-input-block">
                                <input type="text" name="visit_at" value="{{$info->visit_at}}" lay-filter="required" disabled class="layui-input">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <div class="layui-card">
                            <label for="" class="layui-form-label">兼职编号</label>
                            <div class="layui-input-block">
                                <input  type="text" name="part_number" value="{{$info->part_number}}"  disabled class="layui-input" >
                            </div>
                        </div>
                        <div class="layui-card">
                            <label for="" class="layui-form-label">状态说明</label>
                            <div class="layui-input-block">
                                <input type="text" name="status_describe"  value="{{$info->status_describe}}" disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-card">
                            <label for="" class="layui-form-label">客户类型</label>
                            <div class="layui-input-block">
                                <input type="text" name="customer_type"  value="{{$info->customer_type}}" disabled class="layui-input">
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($info->type==1)
                <div class="layui-row layui-col-space15" style="margin-top:10px;border-bottom: 1px solid #f6f6f6"><h3 class="label-info">约访信息</h3></div>
                <div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6">
                    <div class="layui-col-md6">
                        <div class="layui-card">
                            <label for="" class="layui-form-label">约访-信息状态</label>
                            <div class="layui-input-block">
                                <input type="text" name="collect_at" value="{{$status_appointment[$info->status_appointment]}}"  disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-card">
                            <label for="" class="layui-form-label">下次回访时间</label>
                            <div class="layui-input-block">
                                <input type="text" name="collect_area" value="{{$info->visit_at}}" disabled class="layui-input">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <div class="layui-card">
                            <label for="" class="layui-form-label">约访描述</label>
                            <div class="layui-input-block">
                                <input  type="text" name="appointment_describe" value="{{$info->appointment_describe}}"  disabled class="layui-input" >
                            </div>
                        </div>
                        <div class="layui-card">
                            <label for="" class="layui-form-label">报名意向度</label>
                            <div class="layui-input-block">
                                <input type="text" name="appointment_sign"  value="{{$info->appointment_sign}}" disabled class="layui-input">
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
                                <input type="text" name="arrive_at" value="{{date('Y-m-d H:i',strtotime($info->arrive_at))}}"  disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-card">
                            <label for="" class="layui-form-label">是否签约</label>
                            <div class="layui-input-block">
                                <input type="text" name="is_sign" value="{{$info->is_sign==1?'是':'否'}}" disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-card">
                            <label class="layui-form-label">到访人</label>
                            <div class="layui-input-block">
                                <input type="text" name="arrive_person" value="{{$info->arrive_person}}" disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-card">
                            <label class="layui-form-label">到访描述</label>
                            <div class="layui-input-block">
                                <input type="text" name="arrive_describe" value="{{$info->arrive_describe}}" lay-filter="required" disabled class="layui-input">
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-md6">
                        <div class="layui-card">
                            <label for="" class="layui-form-label">预计决策人</label>
                            <div class="layui-input-block">
                                <input  type="text" name="arrive_decision" value="{{$info->arrive_decision}}"  disabled class="layui-input" >
                            </div>
                        </div>
                        <div class="layui-card">
                            <label for="" class="layui-form-label">未报名拒绝点</label>
                            <div class="layui-input-block">
                                <input type="text" name="refuse_reason"  value="{{$info->refuse_reason}}" disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-card">
                            <label for="" class="layui-form-label">下次跟进计划</label>
                            <div class="layui-input-block">
                                <input type="text" name="arrive_plan"  value="{{$info->arrive_plan}}" disabled class="layui-input">
                            </div>
                        </div>
                        <div class="layui-card">
                            <label for="" class="layui-form-label">下次回访日期</label>
                            <div class="layui-input-block">
                                <input type="text" name="visit_at"  value="{{$info->visit_at}}" disabled class="layui-input">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6"><h3 class="label-info">系统信息</h3></div>
            <div class="layui-row layui-col-space15" style="padding: 10px 0px;">
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label">负责人</label>
                        <div class="layui-input-block">
                            <input type="text" name="responer"  value="{{$info->responer_One->name}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">创建时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="created_at"  value="{{$info->created_at}}" disabled class="layui-input">
                        </div>
                    </div>
                    @if($info->type==2)
                        <div class="layui-card">
                            <label for="" class="layui-form-label">已转化为学员</label>
                            <div class="layui-input-block">
                                <input type="text" name="created_at"  value="{{$info->is_turn==1?'是':'否'}}" disabled @if($info->is_turn==0) style="color:red" @endif class="layui-input">
                            </div>
                        </div>
                    @endif

                </div>
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label">创建人</label>
                        <div class="layui-input-block">
                            <input type="text" name="responer"  value="{{$info->create_One->name}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">更新时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="created_at"  value="{{$info->updated_at}}" disabled class="layui-input">
                        </div>
                    </div>
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