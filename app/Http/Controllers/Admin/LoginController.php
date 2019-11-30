<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * 登录表单
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
//        $a = bcrypt('jun23');
//        var_dump($a);die;
        $auto = 0;
        if(url()->current() == url()->previous()){
            $auto = 0;
        }
        //var_dump(url()->current() , url()->previous());
        return view('admin.login_register.login')->with(['auto'=>$auto]);
    }

    /**
     * 用于登录的字段
     * @return string
     */
    public function username()
    {
        return 'usercode';
    }

    /**
     * 登录成功后的跳转地址
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectTo()
    {
        return route('admin.layout');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        //return redirect(route('admin.login'));
        return redirect(route('admin.login'))->with(['auto'=>'1']);
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxLogout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'data'  => []
        ];
        return response()->json($data);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

}
