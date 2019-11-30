<?php

namespace App\Http\Controllers\Home;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\WeixinPayController;
use App\Http\Controllers\Api\DemoController;
use Illuminate\Support\Facades\Redis;
use App\Models\RechargeRule;
use App\Models\ChargeLog;

class IndexController extends Controller
{

    //1.支付 ok
    public function index()
    {
        $id = 3;
        $uid = '95';
        $type = 'account';
        if ($type == 'account') {
            $rule = RechargeRule::findOrFail($id)->toArray();//获取充值金额
            $money = isset($rule['money'])?$rule['money']:'';
            if ($money) {
                $infor = array('member_id'=>$uid,'type'=>'card','money'=>$money);
                $res = ChargeLog::create($infor);
                if ($res) {
                    $jsApiParameters = $this->wePay($id, $uid, $money, 'account');
                }
            }
        }
        return view('home.index.index',['jsApiParameters'=>$jsApiParameters]);
    }

    //2.扫码支付 ok
    public function indexOrderNative()
    {
        $uid = '95';
        $body   = '订单id';//购买信息
        $out_trade_no = 'account'.'-'.'3'.'-'.$uid.'-'.time();//商户订单号 String(32)坑一
        $total_fee    = 1;//购买金额  单位为分
        $wxpay = new WeixinPayController();
        $url= $wxpay->getNativeLink($body,$out_trade_no,$total_fee);
        return $url;
    }
    
    //2.申请退款
    public function indexReturn(Request $request)
    {
        $total_fee='0.01';//购买金额  单位为分
        $transaction_id=$request->get('transaction_id');
        $out_trade_no=$request->get('out_trade_no');
        $wxpay=new WeixinPayController();
        $data=$wxpay->wxRefund($transaction_id,$out_trade_no,$total_fee,$total_fee);
        echo json_encode($data);
    }

    //3.订单查询 ok
    public function indexOrderquery(Request $request)
    {
        $out_trade_no=$request->get('out_trade_no');
        $transaction_id=$request->get('transaction_id');
        $wxpay=new WeixinPayController();
        $result=$wxpay->getOrderquery($out_trade_no,$transaction_id);
        return $result;
    }

    //4.退款查询  ok
    public function indexReturquery(Request $request)
    {
        //优先级
        $refund_id=$request->get('refund_id');
        $out_refund_no=$request->get('out_refund_no');
        $transaction_id=$request->get('transaction_id');
        $out_trade_no=$request->get('out_trade_no');
        $wxpay=new WeixinPayController();
        $result=$wxpay->gerRefundQuery($refund_id,$out_refund_no,$transaction_id,$out_trade_no,0);
        return $result;
    }

    //4.关闭订单 ok
    public function indexOrderClose(Request $request)
    {
        //优先级
        $out_trade_no=$request->get('out_trade_no');
        $wxpay=new WeixinPayController();
        $result=$wxpay->getOrderClosr($out_trade_no);
        return $result;
    }

    //5.下载对账单订单 ok
    public function indexOrderDown(Request $request)
    {
        //优先级
        $bill_date=$request->get('bill_date');
        $bill_type=$request->get('bill_type');
        $wxpay=new WeixinPayController();
        $result=$wxpay->getDownloadbill($bill_date,$bill_type);
        return $result;
    }
    
    //wx测试
    public function wePay($oid, $uid, $money, $type){
        $member = DB::table('member')->select('openid')->where('id',$uid)->first();
        $openid       = $member->openid;//用户openid
        $body         = '订单id'.$oid;//购买信息
        $out_trade_no = $type.'-'.$oid.'-'.$uid.'-'.time();//商户订单号 String(32)坑一
        $total_fee    = $money*100;//购买金额  单位为分
        $wxpay = new WeixinPayController();
        $jsApiParameters = $wxpay->getUnifiedOrder($openid,$body,$out_trade_no,$total_fee);
        return $jsApiParameters;
    }



    
}
