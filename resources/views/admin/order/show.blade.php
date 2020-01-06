<style type="text/css">
    .layui-input-block textarea{
        padding: 10px;
    }
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
            <div class="layui-card-header layuiadmin-card-header-auto">
                <h2>收款信息</h2>
            </div>
            <div class="layui-row layui-col-space15" style="padding: 10px 0px;">
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label">付款人</label>
                        <div class="layui-input-block">
                            <input type="text" name="pay_name" value="{{$info->pay_name}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">付款金额</label>
                        <div class="layui-input-block">
                            <input type="text" name="amount" value="{{$info->amount}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">付款方式</label>
                        <div class="layui-input-block">
                            <input type="text" name="way" value="{{$info->way}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">流水号</label>
                        <div class="layui-input-block">
                            <input type="text" name="flow" value="{{$info->flow}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">创建人</label>
                        <div class="layui-input-block">
                            <input type="text" name="created_info" value="{{$info->created_info->name}}" disabled class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <label for="" class="layui-form-label">收款编号</label>
                        <div class="layui-input-block">
                            <input  type="text" name="identifier" value="{{$info->identifier}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label class="layui-form-label">收款时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="order_at" value="{{$info->order_at}}" disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">收款人(销售)</label>
                        <div class="layui-input-block">
                            <input type="text" name="order_by"  value="{{$info->order_by}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">关联学生</label>
                        <div class="layui-input-block">
                            <input type="text" name="order_by"  value="{{$info->student->name}}"  disabled class="layui-input">
                        </div>
                    </div>
                    <div class="layui-card">
                        <label for="" class="layui-form-label">创建时间</label>
                        <div class="layui-input-block">
                            <input type="text" name="created_at" value="{{$info->created_at}}" disabled class="layui-input">
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <a  class="layui-btn" href="{{route('admin.order')}}" >返 回</a>
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