<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SysLog;
use Excel;
use Illuminate\Http\Request;

class SysLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sysLog.index');
    }

    public function data(Request $request)
    {
        $params = $request->all();
        $res = $this->getSearchData($params);
        foreach ($res['data'] as &$va) {
            if (isset(SysLog::$optModuleName[$va['module']]) && isset(SysLog::$optTypeName[$va['type']])) {
                // 操作模块
                $va['module'] = SysLog::$optModuleName[$va['module']];
                // 操作类型
                $va['type'] = SysLog::$optTypeName[$va['type']];
            }
        }
        // 获取状态分组
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    // 导出
    public function export(Request $request)
    {
        $params = $request->get('params');
        $params = json_decode($params, true);
        $res = $this->getSearchData($params, true);

        ini_set('memory_limit', '500M');
        set_time_limit(0);//设置超时限制为0分钟
        $cellData[0] = ['ID', '操作人', '操作模块', '操作类型', '被操作者', '操作时间'];
        foreach ($res as $va) {
            if (isset(SysLog::$optModuleName[$va['module']]) && isset(SysLog::$optTypeName[$va['type']])) {
                // 操作模块
                $va['module'] = SysLog::$optModuleName[$va['module']];
                // 操作类型
                $va['type'] = SysLog::$optTypeName[$va['type']];
            }

            // 整理数据
            $cellData[] = [$va['id'], $va['username'], $va['module'], $va['type'], $va['content'], $va['created_at']];
        }

        // sys_log表
        $adminUser = $request->user()->toArray();
        $this->addSysLog([
            'user_id' => $adminUser['id'],
            'username' => $adminUser['name'],
            'module' => SysLog::system_manage,
            'page' => '操作日志',
            'type' => SysLog::export,
            'content' => '导出',
        ]);

        Excel::create('操作日志', function ($excel) use ($cellData) {
            $excel->sheet('extend_statement', function ($sheet) use ($cellData) {
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    // 获取查询的model
    private function getSearchData($params, $isExport = false)
    {
        // 排序字段和方式
        $order_field = array_get($params, 'order_field', 'created_at');
        $order_type = array_get($params, 'order_type', 'desc');

        $model = SysLog::query();
        if (!empty($params['module'])) {
            $model = $model->where('module', $params['module']);
        }
        if (!empty($params['optPage'])) {
            $model = $model->where('page', 'like', '%' . $params['optPage'] . '%');
        }
        if (!empty($params['type'])) {
            $model = $model->where('type', $params['type']);
        }
        if (!empty($params['username'])) {
            $model = $model->where('username', 'like', '%' . $params['username'] . '%');
        }
        if (!empty($params['content'])) {
            $model = $model->where('content', 'like', '%' . $params['content'] . '%');
        }
        if (isset($params['time_start']) && isset($params['time_end'])) {
            $model = $model->whereBetween('created_at', array($params['time_start'], $params['time_end'] . ' 23:59:59'));
        }
        $model = $model->orderBy($order_field, $order_type);
        if ($isExport) {
            $res = $model->get()->toArray();
        } else {
            $res = $model->paginate(array_get($params, 'limit', 30))->toArray();
        }

        return $res;
    }
}
