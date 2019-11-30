<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\SysLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index');
    }

    public function getData(Request $request)
    {
        $list=Db::table('sys_users');
        $keywords = $request->get('title');
        if(!empty($keywords)){
          $list->where(function($query)use($keywords){
            $query->where('name','like',"%{$keywords}%")->orWhere('mobile', 'like', "%{$keywords}%")->orWhere('usercode', 'like', "%{$keywords}%");
          });
        }
        $list  = $list->paginate($request->get('limit',10))->toArray();
        foreach ($list['data'] as $key => $value) {
           $value->userlasttime = $value->userlasttime?date('Y-m-d H:i:s',$value->userlasttime):'';
        }
        // 获取状态分组
        $data=array(
            'code'=>0,
            'msg'=>'',
            'list'=>$list['data'],
            'counts'=>$list['total']
        );
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * 新增
     */
    public function store(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $data['userpass'] = bcrypt($data['userpass']);
        $res = User::create($data);
        if ($res){
            $adminUser = Auth::user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_user,
                'page' => '用户管理新增',
                'type' => SysLog::add,
                'content' => '用户id:'.$res['id']
            ]);
            return redirect()->to(route('admin.user'));
        }
        return redirect()->to(route('admin.user'))->withErrors('系统错误');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit',compact('user'));
    }

    /**
     * 编辑
     */
    public function update(Request $request)
    {
        $data = $request->all();
        unset($data['_token']);
        $info =  User::findOrFail($data['id']);
        if ($data['userpass']){
            $data['userpass'] = bcrypt($data['userpass']);
        }else{
            $data['userpass'] = $info->userpass;
        }
        $res = User::find($data['id'])->update($data);

        if ($res){
            $adminUser = Auth::user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_user,
                'page' => '用户管理编辑',
                'type' => SysLog::edit,
                'content' => '用户id:'.$data['user_id']
            ]);
            return redirect()->to(route('admin.user'))->with(['status'=>'更新用户成功']);
        }
        return redirect()->to(route('admin.user'))->withErrors('系统错误');
    }

    /**
     * 删除
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        $res = User::destroy($ids);
        if ($res){
            $adminUser = Auth::user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_user,
                'page' => '用户管理删除',
                'type' => SysLog::delete,
                'content' => '用户id:'.$ids
            ]);
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }
        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }

    /**
     * 分配角色
     */
    public function role(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $roles = Role::get();
        $hasRoles = $user->roles();
        foreach ($roles as $role){
            $role->own = $user->hasRole($role) ? true : false;
        }
        return view('admin.user.role',compact('roles','user'));
    }

    /**
     * 更新分配角色
     */
    public function assignRole(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $roles = $request->get('roles',[]);
       if ($user->syncRoles($roles)){
            $adminUser = Auth::user()->toArray();
            $this->addSysLog([
                'user_id' => $adminUser['id'],
                'username' => $adminUser['name'],
                'module' => SysLog::manage_user,
                'page' => '用户管理分配角色',
                'type' => SysLog::edit,
                'content' => '用户id:'.$id
            ]);
           return redirect()->to(route('admin.user'))->with(['status'=>'更新用户角色成功']);
       }
        return redirect()->to(route('admin.user'))->withErrors('系统错误');
    }


}
