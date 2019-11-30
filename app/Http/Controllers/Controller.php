<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Message;
use App\Models\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\SysLog;
use App\Models\Store;
use App\Models\SysArea;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 处理权限分类
     */
    public function tree($list=[], $pk='id', $pid = 'parent_id', $child = '_child', $root = 0)
    {
        if (empty($list)){
            $list = Permission::get()->toArray();
        }
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }


    /** 操作日志  sys_log
    *
    *   $param = [
        'user_id'=>'操作用户 id',
        'user_id'=>'操作用户 username',
        'module'=>'模块 (string)',
        'page'=>'页面 (string)',
        'type'=>'操作类型 copy\add\edit\delete\export\import(string)',
        'content'=>'操作内容 需要知道对应id (string)'  ,
        ]
    */
    public function addSysLog($param)
    {

// sys_log表
        $arr = [
            'user_id'=>$param['user_id'],
            'username'=>$param['username'],
            'module'=>$param['module'],
            'type'=>$param['type'],
            'page'=>$param['page'],
            'content'=>$param['content'],
        ];

        $r = SysLog::create($arr);

         // $r = \DB::insert("insert into sys_log (user_id,username,type,module,content,created_at) values (?,?,?,?,?,?)", $arr);

         if($r){
            return true;
         }else{
            return true;
         }
    }

    /**
     * 发送系统消息
     *
     * 控制器中使用：$this->sendSysMessage($order_id, Message::audit_msg|print_msg|refund_msg);
     *
     * @param int $order_id 订单ID
     * @param int $type audit_msg(用户下单=>审核消息)|print_msg(审核通过=>打印消息)|refund_msg(申请退款=>退款消息)
     * @throws \Exception
     */
    public function sendSysMessage($order_id, $type)
    {
        if (!empty($order_id) && array_key_exists($type, Message::$type)) {
            // 封装数据
            $msg = Message::$type[$type];
            $time = Carbon::now();
            $item = [
                'title' => $msg['title'],
                'content' => $msg['content'],
                'accept_uuid' => '',
                'order_id' => $order_id,
                'flag' => $type,
                'created_at' => $time,
                'updated_at' => $time,
            ];

            // 获取该订单所属门店的员工
            $users = User::with(['stores.orders' => function ($query) use ($order_id) {
                $query->where('id', $order_id);
            }])->select('id')->get();
            // 筛选出有审核权限的员工
            $data = [];
            foreach ($users as $user) {
                if ($user->hasAnyPermission($msg['permission'])) {
                    $item['accept_uuid'] = $user->id;
                    $data[] = $item;
                }
            }

            // 批量插入
            if ($data) {
                Message::query()->insert($data);
            }
        }
    }

    /**
     * 简化版操作日志(2018-12-18)
     *
     * @param  $module(1订单管理；2人员管理；3门店管理；4餐品管理；5优惠管理；6标签管理；7会员管理；
     *                 8发票管理；9评价管理；10统计管理；11系统管理；12备餐管理；13备餐出餐记录；14厨显管理)
     * @param  $type(1导入；2导出；3复制；4添加；5修改；6删除；8更新；100其他)
     * @return $page(所修改的页面)
     * @return $content(详细内容)
     */
    public function addLog($module,$type,$page,$content){
        $user = Auth::user();
        $arr = [
            'user_id'=>$user['id'],
            'username'=>$user['name'],
            'module'=>$module,
            'type'=>$type,
            'page'=>$page,
            'content'=>$content,
        ];

        $r = SysLog::create($arr);
        if($r){
            return true;
        }else{
            return false;
        }
    }


            /**
     * 模拟post进行url请求
     * @param string $url
     * @param array $post_data
     */
    function request_post($url = '', $post_data = array(),$action='member') {
        if (empty($url) || empty($post_data)) {
            return false;
        }  
        
        $postUrl = $url;  
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式

        if($action == 'order')
        {
            $key = "c6db19c046048f4d7eec6e4215b6ebba";
            $post = json_encode($post_data);  
            $sign = md5($post.$key);
            $header = array('Content-Type:application/json; charset=utf-8','sign:'.$sign);
            
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($post_data) );
        }else{

            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        }

        // curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        
        return $data;
    }

    /** 
    * 取汉字的第一个字的首字母 
    * @param type $str 
    * @return string|null 
    */  
    public function _getFirstCharter($str){  
        if(empty($str)){return '';}  
        $fchar=ord($str{0});  
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});  
        $s1=iconv('UTF-8','gb2312',$str);  
        $s2=iconv('gb2312','UTF-8',$s1);  
        $s=$s2==$str?$s1:$str;  
        $asc=ord($s{0})*256+ord($s{1})-65536;  
        if($asc>=-20319&&$asc<=-20284) return 'A';  
        if($asc>=-20283&&$asc<=-19776) return 'B';  
        if($asc>=-19775&&$asc<=-19219) return 'C';  
        if($asc>=-19218&&$asc<=-18711) return 'D';  
        if($asc>=-18710&&$asc<=-18527) return 'E';  
        if($asc>=-18526&&$asc<=-18240) return 'F';  
        if($asc>=-18239&&$asc<=-17923) return 'G';  
        if($asc>=-17922&&$asc<=-17418) return 'H';  
        if($asc>=-17417&&$asc<=-16475) return 'J';  
        if($asc>=-16474&&$asc<=-16213) return 'K';  
        if($asc>=-16212&&$asc<=-15641) return 'L';  
        if($asc>=-15640&&$asc<=-15166) return 'M';  
        if($asc>=-15165&&$asc<=-14923) return 'N';  
        if($asc>=-14922&&$asc<=-14915) return 'O';  
        if($asc>=-14914&&$asc<=-14631) return 'P';  
        if($asc>=-14630&&$asc<=-14150) return 'Q';  
        if($asc>=-14149&&$asc<=-14091) return 'R';  
        if($asc>=-14090&&$asc<=-13319) return 'S';  
        if($asc>=-13318&&$asc<=-12839) return 'T';  
        if($asc>=-12838&&$asc<=-12557) return 'W';  
        if($asc>=-12556&&$asc<=-11848) return 'X';  
        if($asc>=-11847&&$asc<=-11056) return 'Y';  
        if($asc>=-11055&&$asc<=-10247) return 'Z';  
        return '*';  
    }

    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    function object_to_array($obj) {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->object_to_array($v);
            }
        }
        return $obj;
    }


    /**
     * 判断字符串结尾
     * @param object $obj 对象
     * @return array
     */
    public function stringEndWith($haystack, $needle) {
        $length = strlen($needle);
        if($length == 0) {
            return true;
        }
        return (substr($haystack, -$length) === $needle);
    }

    /**
     * 拼接餐品分组参数
     * @param $meal_id 餐品id
     * @param $category_id 备餐分类id
     * @param $relation_type 分类类型 1套餐2单品
     * @param $canteen_split 套餐-堂食&非堂食是否分开备餐
     * @param $child_category 备餐子分类id
     * @param $merge 是否合并备餐
     * @param $canteen 订单是否堂食
     */
    function get_merge_group($meal_id, $category_id, $relation_type, $canteen_split, $child_category, $merge, $canteen, $is_gift) {

        $is_gift = 0;//赠送餐品跟普通餐品备餐
        //合并分组
        if ($merge == 2 || $relation_type==2) {//分开备餐
            $merge_array[] = intval($meal_id);
        }else {//合并备餐
            $merge_array[] = 0;
        }
        $merge_array[] = intval($category_id);
        $merge_array[] = intval($relation_type);
        $merge_array[] = intval($merge);
        $merge_array[] = intval($canteen_split);
        $merge_array[] = intval($canteen);
        $merge_array[] = intval($child_category);
        $merge_array[] = intval($is_gift);

        return implode('_', $merge_array);
    }


    /**
     * 拼接备餐分类分组参数
     * @param $category_id 备餐分类id
     * @param $relation_type 分类类型 1套餐2单品
     * @param $canteen_split 套餐-堂食&非堂食是否分开备餐
     * @param $child_category 备餐子分类id
     * @param $merge 是否合并备餐
     * @param $canteen 订单是否堂食
     */
    function get_category_group($category_id, $relation_type, $canteen_split, $child_category, $merge, $canteen) {

        $merge_array[] = '';
        $merge_array[] = intval($category_id);
        $merge_array[] = intval($relation_type);
        $merge_array[] = intval($merge);
        $merge_array[] = intval($canteen_split);
        $merge_array[] = intval($canteen);
        $merge_array[] = intval($child_category);
        $merge_array[] = 0;

        return implode('_', $merge_array);
    }

    /**
     * 拼接餐品备餐名称
     * @param $meal_title 餐品名称
     * @param $category_name 备餐分类名称
     * @param $child_category_name 备餐子分类名称
     * @param $relation_type 分类类型 1套餐2单品
     * @param $merge 是否合并备餐
     * @param $canteen_split 套餐-堂食&非堂食是否分开备餐
     * @param $canteen 订单是否堂食
     */
    function get_merge_meal_name($meal_title, $category_name, $child_category_name, $relation_type, $merge, $canteen_split, $canteen) {
        
        $prepare_name = $meal_title;
        //备餐名称
        if ($relation_type == 1) {//套餐
            if ($merge == 2) {//分开备餐：显示餐品+套餐包含类型名称
                $prepare_name = $prepare_name.$child_category_name;
            }else {//合并备餐：显示分类+套餐包含名称
                $prepare_name = $category_name.$child_category_name;
            }
        }else {//单品
            $prepare_name = $category_name.$prepare_name;//分开备餐：显示餐品+套餐包含类型名称
        }

        if ($canteen_split > 0) {//分开备餐
            if ($canteen) {
                $prepare_name = $prepare_name.'(堂食)';  
            }else {
                $prepare_name = $prepare_name.'(非堂食)'; 
            }
        }

        return $prepare_name;
    }

    /**
     * 时间差显示转换
     * @param $different
     */
    function get_different_name($different) {
        $different = abs($different);
        if ($different > 0) {
            $days = intval(abs($different)/(60*60*24)); //剩余天数
            if ($days > 0) {
                return $days.'天';
            }
            $hours = intval(abs($different)/(60*60)); //剩余小时
            if ($hours > 0) {
                return $hours.'小时';
            }
            $minus = intval(abs($different)/60); //剩余描述
            if ($minus > 0) {
                return $minus.'分钟';
            }
            $seconds = intval(abs($different)%60);//剩余秒
            return $seconds.'秒';
        }else {
            return '0秒';
        }

        return $prepare_name;
    }

    //省市区处理用于编辑展示选中项
    public function addressHandleSelection($id, $have_store=null){
        $store = Store::select("province", "city", "area", "title")->findOrFail($id)->toArray();
        if($store['province']){
            $province = SysArea::findOrFail($store['province'])->toArray();
            $stores['province'] = $province['aid'];
        }
        if($store['city']){
            $city = SysArea::findOrFail($store['city'])->toArray();
            $stores['city'] = $city['aid'];
        }
        if($store['area']){
            $area = SysArea::findOrFail($store['area'])->toArray();
            $stores['area'] = $area['aid'];
        }
        $idIn = Store::getUserStoreProvince();
        $provinces = SysArea::query()->select("id","aid","content")->where([['parent_id','=',0],['status','=',1]])->whereIn('id',$idIn['province'])->get()->toArray();
        $cities = SysArea::query()->select("id","aid","content")->where('parent_id',$stores['province'])->whereIn('id',$idIn['city'])->where('status',1)->get()->toArray();
        $areas = SysArea::query()->select("id","aid","content")->where('parent_id',$stores['city'])->whereIn('id',$idIn['area'])->where('status',1)->get()->toArray();

        if ($have_store) {
            //有权限的门店
            $sort = Store::select('id', 'title')->whereIn('id', $have_store)->where([['status','=',1],['type','=',1],['area','=',$store['area']]])->get();   
        }else {
            $sort = Store::select('id', 'title')->where([['status','=',1],['type','=',1],['area','=',$store['area']]])->get();   
        }
        $sortary = array();
        foreach ($sort as $key => $value) {
            $sortary[$value->id] = $value->title;
        }

        return['provinces'=>$provinces,'cities'=>$cities,'areas'=>$areas,'stores'=>$stores,'sortary'=>$sortary];
    }
}
