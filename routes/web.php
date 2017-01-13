<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
$api = app('Dingo\Api\Routing\Router');

Route::get('/', function () {
    return view('welcome');
});

Route::get('test1','TestController@index');
Route::get('aa',function(){
   return view('aa');
});
Route::post('upload', 'UploadController@create');

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes

    Route::get('test', function () {
        return view('test');
    });

    Route::resource('admin/posts', 'Admin\\PostsController');
});

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Http\Controllers\Api\v1', 'middleware' => ['member.change', 'cors']], function ($api) {
        $api->post('user/login', 'AuthController@authenticate');  //登录授权
        $api->post('user/register', 'AuthController@register');  //注册

        $api->group(['middleware' => 'jwt.auth'], function ($api) {

            //刷新token
            $api->post('user/refresh', 'AuthController@refreshToken');
            $api->get('tests', 'TestsController@index');
            //请求方式：
            //http://localhost:8000/api/tests?token=xxxxxx  (从登陆或注册那里获取,目前只能用get)
            $api->get('tests/{id}', 'TestsController@show');
            $api->get('user/me', 'AuthController@AuthenticatedUser'); //获取用户信息

        });
    });
});


