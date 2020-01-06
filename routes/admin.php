<?php
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 后台公共路由部分
|
*/
Route::group(['namespace'=>'Admin','prefix'=>'admin'],function (){
    //登录、注销
    Route::get('login','LoginController@showLoginForm')->name('admin.loginForm');
    Route::post('login','LoginController@login')->name('admin.login');
    Route::get('logout','LoginController@logout')->name('admin.logout');
    Route::get('ajaxLogout','LoginController@ajaxLogout')->name('admin.ajaxLogout');

});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:tag.manage']], function () {
    //消息管理
    Route::group(['middleware' => 'permission:tag.manage'], function () {
        Route::get('admin/advert', 'MessageController@data')->name('admin.countStore.payConfirm');
        Route::get('admin/countStore', 'MessageController@data')->name('admin.countStore.orderIndex');
        Route::get('admin/countStoreSale', 'MessageController@data')->name('admin.menuCompare');
    });

});


/* 
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| 后台需要授权的路由 admins
|
*/
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'auth'],function (){ 
    //后台布局
    Route::get('/','IndexController@layout')->name('admin.layout');
    //后台首页
    Route::get('/index','IndexController@index')->name('admin.index');
    Route::get('/index1','IndexController@index1')->name('admin.index1');
    Route::get('/index2','IndexController@index2')->name('admin.index2');
    //图标
    Route::get('icons','IndexController@icons')->name('admin.icons');


});
// 人员管理
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['auth']],function (){
    //用户管理
    Route::group(['middleware'=>['permission:system.user']],function (){
        Route::get('user','UserController@index')->name('admin.user');
        Route::get('user/data','UserController@getData')->name('admin.user.data');
        //添加
        Route::get('user/create','UserController@create')->name('admin.user.create')->middleware('permission:system.user.create');
        Route::post('user/store','UserController@store')->name('admin.user.store')->middleware('permission:system.user.create');
        //编辑
        Route::get('user/{id}/edit','UserController@edit')->name('admin.user.edit')->middleware('permission:system.user.edit');
        Route::post('user/{id}/update','UserController@update')->name('admin.user.update')->middleware('permission:system.user.edit');
        //删除
        Route::delete('user/destroy','UserController@destroy')->name('admin.user.destroy')->middleware('permission:system.user.destroy');
        //分配角色
        Route::get('user/{id}/role','UserController@role')->name('admin.user.role')->middleware('permission:system.user.role');
        Route::put('user/{id}/assignRole','UserController@assignRole')->name('admin.user.assignRole')->middleware('permission:system.user.role');
    });
});

//权限角色表格接口
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('data','IndexController@data')->name('admin.data')->middleware('permission:system.role|system.user|system.permission');
});

//系统管理
Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>['auth','permission:system.manage']],function (){
    //角色管理
    Route::group(['middleware'=>'permission:system.role'],function (){
        Route::get('role','RoleController@index')->name('admin.role');
        Route::get('role/data','RoleController@getData')->name('admin.role.data');
        //添加
        Route::get('role/create','RoleController@create')->name('admin.role.create')->middleware('permission:system.role.create');
        Route::post('role/store','RoleController@store')->name('admin.role.store')->middleware('permission:system.role.create');
        //编辑
        Route::get('role/{id}/edit','RoleController@edit')->name('admin.role.edit')->middleware('permission:system.role.edit');
        Route::put('role/{id}/update','RoleController@update')->name('admin.role.update')->middleware('permission:system.role.edit');
        //删除
        Route::delete('role/destroy','RoleController@destroy')->name('admin.role.destroy')->middleware('permission:system.role.destroy');
        //分配权限
        Route::get('role/{id}/permission','RoleController@permission')->name('admin.role.permission')->middleware('permission:system.role.permission');
        Route::put('role/{id}/assignPermission','RoleController@assignPermission')->name('admin.role.assignPermission')->middleware('permission:system.role.permission');
    });
    //权限管理
    Route::group(['middleware'=>'permission:system.permission'],function (){
        Route::get('permission','PermissionController@index')->name('admin.permission');
        //添加
        Route::get('permission/create','PermissionController@create')->name('admin.permission.create')->middleware('permission:system.permission.create');
        Route::post('permission/store','PermissionController@store')->name('admin.permission.store')->middleware('permission:system.permission.create');
        //编辑
        Route::get('permission/{id}/edit','PermissionController@edit')->name('admin.permission.edit')->middleware('permission:system.permission.edit');
        Route::put('permission/{id}/update','PermissionController@update')->name('admin.permission.update')->middleware('permission:system.permission.edit');
        //删除
        Route::delete('permission/destroy','PermissionController@destroy')->name('admin.permission.destroy')->middleware('permission:system.permission.destroy');
    });
    //菜单管理

    Route::group(['middleware'=>'permission:system.menu'],function (){
        Route::get('menu','MenuController@index')->name('admin.menu');
        Route::get('menu/data','MenuController@data')->name('admin.menu.data');
        //添加
        Route::get('menu/create','MenuController@create')->name('admin.menu.create')->middleware('permission:system.menu.create');
        Route::post('menu/store','MenuController@store')->name('admin.menu.store')->middleware('permission:system.menu.create');
        //编辑
        Route::get('menu/{id}/edit','MenuController@edit')->name('admin.menu.edit')->middleware('permission:system.menu.edit');
        Route::put('menu/{id}/update','MenuController@update')->name('admin.menu.update')->middleware('permission:system.menu.edit');
        //删除
        Route::delete('menu/destroy','MenuController@destroy')->name('admin.menu.destroy')->middleware('permission:system.menu.destroy');
    });
});

//配置管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth', 'permission:config.manage']], function () {
    //站点配置
    Route::group(['middleware' => 'permission:config.site'], function () {
        Route::get('site', 'SiteController@index')->name('admin.site');
        Route::put('site', 'SiteController@update')->name('admin.site.update')->middleware('permission:config.site.update');
    });


}); 

//人员管理
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth']], function () {
    //客户
    Route::group(['middleware' => 'permission:system.customer'], function () {
        Route::get('customer','CustomerController@index')->name('admin.customer');
        Route::get('customer/data','CustomerController@getData')->name('admin.customer.data');
        Route::get('customer/add','CustomerController@add')->name('admin.customer.add');
        Route::post('customer/save','CustomerController@save')->name('admin.customer.save');
        Route::get('customer/{id}/edit','CustomerController@edit')->name('admin.customer.edit');
        Route::post('customer/{id}/update','CustomerController@update')->name('admin.customer.update');
        Route::get('customer/export','CustomerController@export')->name('admin.customer.export');
        Route::get('customer/{id}/show','CustomerController@show')->name('admin.customer.show');
        Route::get('customer/importExcel','CustomerController@importExcel')->name('admin.customer.importExcel');
        Route::get('customer/exportExcel','CustomerController@exportExcel')->name('admin.customer.exportExcel');
        Route::post('customer/import','CustomerController@import')->name('admin.customer.import');
        Route::get('customer/getChannelDetail','CustomerController@getChannelDetail')->name('admin.customer.getChannelDetail');
        Route::get('customer/turn','CustomerController@turn')->name('admin.customer.turn');
        Route::get('customer/turn_student','CustomerController@turn_student')->name('admin.customer.turn_student');
    });

    Route::get('student/data','StudentController@getData')->name('admin.student.data');

    //学员
    Route::group(['middleware' => 'permission:system.student'], function () {
        Route::get('student','StudentController@index')->name('admin.student');
        Route::get('student/{id}/edit','StudentController@edit')->name('admin.student.edit');
        Route::post('student/{id}/update','StudentController@update')->name('admin.student.update');
        Route::get('student/{id}/del','StudentController@del')->name('admin.student.del');
        Route::get('student/getTeacher','StudentController@getTeacher')->name('admin.student.getTeacher');
        Route::get('student/{id}/show','StudentController@show')->name('admin.student.show');
    });

    //班级
    Route::group(['middleware' => 'permission:system.course'], function () {
        Route::get('course','CourseController@index')->name('admin.course');
        Route::get('course/data','CourseController@getData')->name('admin.course.data');
        Route::get('course/add','CourseController@add')->name('admin.course.add');
        Route::get('course/week_add','CourseController@week_add')->name('admin.course.week_add');
        Route::post('course/save','CourseController@save')->name('admin.course.save');
        Route::get('course/{id}/edit','CourseController@edit')->name('admin.course.edit');
        Route::post('course/{id}/update','CourseController@update')->name('admin.course.update');
        Route::get('course/{id}/show','CourseController@show')->name('admin.course.show');
        Route::get('course/show_student','CourseController@show_student')->name('admin.course.show_student');
        Route::get('course/addStudent','CourseController@addStudent')->name('admin.course.addStudent');
        Route::get('course/saveStudent','CourseController@saveStudent')->name('admin.course.saveStudent');
        Route::get('course/delStudent','CourseController@delStudent')->name('admin.course.delStudent');
        Route::get('course/export','CourseController@export')->name('admin.course.export');
    });

    //教室
    Route::group(['middleware' => 'permission:system.classroom'], function () {
        Route::get('classroom','ClassroomController@index')->name('admin.classroom');
        Route::get('classroom/data','ClassroomController@getData')->name('admin.classroom.data');
        Route::get('classroom/add','ClassroomController@add')->name('admin.classroom.add');
        Route::post('classroom/save','ClassroomController@save')->name('admin.classroom.save');
        Route::get('classroom/{id}/edit','ClassroomController@edit')->name('admin.classroom.edit');
        Route::post('classroom/{id}/update','ClassroomController@update')->name('admin.classroom.update');
        Route::get('classroom/{id}/del','ClassroomController@del')->name('admin.classroom.del');
        Route::get('classroom/{id}/show','ClassroomController@show')->name('admin.classroom.show');
    });

    //课程安排
    Route::group(['middleware' => 'permission:admin.classroom.addPlan'], function () {
        Route::get('classroom/addPlan','ClassroomController@addPlan')->name('admin.classroom.addPlan');
        Route::post('classroom/savePlan','ClassroomController@savePlan')->name('admin.classroom.savePlan');
        Route::get('classroom/detail_add','ClassroomController@detail_add')->name('admin.classroom.detail_add');
        Route::get('classroom/{id}/editPlan','ClassroomController@editPlan')->name('admin.classroom.editPlan');
        Route::post('classroom/{id}/updatePlan','ClassroomController@updatePlan')->name('admin.classroom.updatePlan');
    });

    //订单管理
    Route::group(['middleware' => 'permission:admin.order'], function () {
        Route::get('order','OrderController@index')->name('admin.order');
        Route::get('order/data','OrderController@getData')->name('admin.order.data');
        Route::get('order/add','OrderController@add')->name('admin.order.add');
        Route::post('order/save','OrderController@save')->name('admin.order.save');
        Route::get('order/{id}/edit','OrderController@edit')->name('admin.order.edit');
        Route::post('order/{id}/update','OrderController@update')->name('admin.order.update');
        Route::get('order/{id}/show','OrderController@show')->name('admin.order.show');
        Route::get('order/refund','OrderController@refund')->name('admin.order.refund');
        Route::get('order/export','OrderController@export')->name('admin.order.export');
    });
});


