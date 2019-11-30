<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/24
 * Time: 14:04
 */

namespace App\Logic;
use App\Models\MealType;
use App\Models\SysArea;

class CommonLogic
{
    /**
     *  门店数据记录
     * @param $data
     * @return array
     */
    public function getStore($data){
        $store_arr = [];
        $city = [];
        $cityRet  = SysArea::query()->where('level','2')->pluck('content','id')->toArray();
        $areaRet  = SysArea::query()->where('level','3')->pluck('content','id')->toArray();

        foreach ($data as $va) {
            $city[$va['store']['city']][$va['store']['area']][] = $va['store']['title'];
        }
        foreach ($city as $k=>$va) {
            $store_html = "【{$cityRet[$k]}】&nbsp;&nbsp;";
            foreach ($va as $kk=>$v) {
                $store_html .= "[{$areaRet[$kk]}]&nbsp;&nbsp;";
                foreach ($v as $v1) {
                    $store_html .= $v1.",&nbsp;&nbsp;";
                }
            }
            $store_arr[] = $store_html;
        }

        return $store_arr;
    }


    /**
     *  餐品数据记录
     * @param $data
     * @return array
     */
    public function getMeal($data){
        $info = [];
        $meal_arr = [];
        foreach ($data as $val){
            $info[$val['meal']['type']][] = array_get($val,'meal');
        }
        $mealType = MealType::query()->pluck('title','id')->toArray();
        foreach ($info as $k=>$va) {
            $meal_html = "【{$mealType[$k]}】&nbsp;&nbsp;";
            foreach ($va as $kk=>$v) {
                $meal_html .= $v['title'].",&nbsp;&nbsp;";
            }
            $meal_arr[] = $meal_html;
        }

        return $meal_arr;
    }

}