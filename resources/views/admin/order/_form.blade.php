<style type="text/css">
    .layui-input-block textarea{
        padding: 10px;
    }
</style>
{{csrf_field()}}


<div class="layui-row layui-col-space15" style="padding: 10px 0px;border-bottom: 1px solid #f6f6f6">
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>付款人</label>
            <div class="layui-input-block">
                <input type="text" name="pay_name" value="{{$info->pay_name??old('pay_name')}}" lay-verify="required" placeholder="请输入付款人" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>付款金额</label>
            <div class="layui-input-block">
                <input type="text" name="amount" value="{{$info->amount??old('amount')}}" lay-verify="required" placeholder="请输入付款金额" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label"><span style="color: red;">*</span>付款方式</label>
            <div class="layui-input-block">
                <select name="way"  lay-verify="required" lay-search>
                    <option value="">请选择</option>
                    <option value="微信"  @if($info->way=='微信')selected @endif >微信</option>
                    <option value="支付宝"  @if($info->way=='支付宝')selected @endif >支付宝</option>
                    <option value="现金"  @if($info->way=='现金')selected @endif >现金</option>
                    <option value="网银"  @if($info->way=='网银')selected @endif >网银</option>
                    <option value="pos机"  @if($info->way=='pos机')selected @endif >pos机</option>
                </select>
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">流水号</label>
            <div class="layui-input-block">
                <input type="text" name="flow" value="{{$info->flow??old('flow')}}"  placeholder="请输入流水号" class="layui-input">
            </div>
        </div>
    </div>
    <div class="layui-col-md6">
        <div class="layui-card">
            <label for="" class="layui-form-label">收款编号</label>
            <div class="layui-input-block">
                <input  type="text" name="identifier" value="{{$info->identifier??old('identifier')}}"  placeholder="自动生成" class="layui-input layui-disabled" readonly style="background-color: #eeeeee">
            </div>
        </div>
        <div class="layui-card">
            <label class="layui-form-label">收款时间</label>
            <div class="layui-input-block">
                <input type="text" name="order_at" id="order_at" value="{{$info->order_at?$info->order_at:(old('order_at')?old('order_at'):date('Y-m-d H:i'))}}" lay-verify="required" placeholder="请选择收款日期" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">收款人(销售)</label>
            <div class="layui-input-block">
                <input type="text" name="order_by"  value="{{$info->order_by??old('order_by')}}"  placeholder="请输入收款人" class="layui-input">
            </div>
        </div>
        <div class="layui-card">
            <label for="" class="layui-form-label">关联学生</label>
            <div class="layui-input-block">
                <select name="student_id" lay-search >
                    <option value="">请选择</option>
                    @foreach($student as $item)
                        <option value="{{$item['id']}}" @if($item['id']==$info->student_id) selected @endif>{{$item['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit"   class="layui-btn" lay-submit="formDemo" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.order')}}" >返 回</a>
    </div>
</div>
