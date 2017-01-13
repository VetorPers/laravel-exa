<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\Config;
use JWTAuth;
use Symfony\Component\HttpFoundation\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class BaseController extends Controller
{
    use Helpers;

    /****
     * BaseController constructor.
     */
    public function __construct()
    {

    }

    //根据token获取用户信息
    public function user()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return JWTAuth::parseToken()->toUser();
    }

    //上传图片,取得图片地址
    public function getImage($file)
    {
        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();

            $extension = $file->getClientOriginalExtension();

            $newName = md5(date('ymdhis') . $clientName) . "." . $extension; //生成文件名

            $path = $file->move('uploads/', $newName); //将图片移到服务器文件夹

//            $path = addcslashes($path, '/');
            return $path;
        }
    }

    /**
     * 检测并设置图片
     * @param string $img 图片数据路径
     * @return string
     */
    public static function setImg($img)
    {
        if (strstr($img, 'http')) {
            return $img;
        }
        return is_file(Config::get('constants.PUBLIC_PATH') . $img) ? 'http://' . $_SERVER['HTTP_HOST'] . '/' . $img : '';
    }
}