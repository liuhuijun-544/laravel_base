<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\SysLog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        $data = $request->only(['name','display_name','range']);
        if ($role = Role::create($data)){
            // sys_log表
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id'=>$adminUser['id'],
                'username'=>$adminUser['name'],
                'module'=>SysLog::manage_role,
                'page'=>'角色管理',
                'type'=>SysLog::add,
                'content'=>'添加角色：' . $role->id,
            ]);
            return redirect()->to(route('admin.role'))->with(['status'=>'添加角色成功']);
        }
        return redirect()->to(route('admin.role'))->withErrors('系统错误');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $data = $request->only(['name','display_name','range']);
        if ($role->update($data)){
            // sys_log表
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id'=>$adminUser['id'],
                'username'=>$adminUser['name'],
                'module'=>SysLog::manage_role,
                'page'=>'角色管理',
                'type'=>SysLog::edit,
                'content'=>'编辑角色：' . $role->id,
            ]);
            return redirect()->to(route('admin.role'))->with(['status'=>'更新角色成功']);
        }
        return redirect()->to(route('admin.role'))->withErrors('系统错误');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }

        // 如果角色已经关联有启用的用户，删除提示：“有关联用户，不能删除”
        $users = DB::table('sys_model_has_roles')->whereIn('role_id', $ids)->pluck('model_id')->toArray();
        $count = User::query()->whereIn('id', $users)->count();
        if ($count > 0) {
            return response()->json(['code' => 1, 'msg' => '有关联用户，不能删除']);
        }

        if (Role::destroy($ids)){
            // sys_log表
            $adminUser = $request->user()->toArray();
            $this->addSysLog([
                'user_id'=>$adminUser['id'],
                'username'=>$adminUser['name'],
                'module'=>SysLog::manage_role,
                'page'=>'角色管理',
                'type'=>SysLog::delete,
                'content'=>'删除角色：' . join(',', $ids),
            ]);
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }

    /**
     * 分配权限
     */
    public function permission(Request $request,$id)
    {
        set_time_limit(0);
        $role = Role::findOrFail($id);
        $permissions = $this->tree();
        foreach ($permissions as $key1 => $item1){
            $permissions[$key1]['own'] = $role->hasPermissionTo($item1['id']) ? 'checked' : false ;
            if (isset($item1['_child'])){
                foreach ($item1['_child'] as $key2 => $item2){
                    $permissions[$key1]['_child'][$key2]['own'] = $role->hasPermissionTo($item2['id']) ? 'checked' : false ;
                    if (isset($item2['_child'])){
                        foreach ($item2['_child'] as $key3 => $item3){
                            $permissions[$key1]['_child'][$key2]['_child'][$key3]['own'] = $role->hasPermissionTo($item3['id']) ? 'checked' : false ;
                        }
                    }
                }
            }

        }
        return view('admin.role.permission',compact('role','permissions'));
    }

    /**
     * 存储权限
     */
    public function assignPermission(Request $request,$id)
    {
        set_time_limit(0);
        $role = Role::findOrFail($id);
        $permissions = $request->get('permissions');

        // sys_log表
        $adminUser = $request->user()->toArray();
        $logData = [
            'user_id'=>$adminUser['id'],
            'username'=>$adminUser['name'],
            'module'=>SysLog::manage_role,
            'page'=>'角色管理',
            'type'=>SysLog::edit,
            'content'=>'编辑角色权限，角色：' . $id,
        ];
        if (empty($permissions)){
            $role->permissions()->detach();
            $this->addSysLog($logData);
            return redirect()->to(route('admin.role'))->with(['status'=>'已更新角色权限']);
        }
        $role->syncPermissions($permissions);
        $this->addSysLog($logData);
        return redirect()->to(route('admin.role'))->with(['status'=>'已更新角色权限']);
    }

}
