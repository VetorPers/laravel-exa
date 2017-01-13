<?php
namespace App\Http\Controllers\Api\v1;

use App\Client;
use App\Http\Controllers\Api\Transformers\TestsTransformer;
use App\Http\Controllers\Api\Transformers\UserTransformer;
use App\Member;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use JWTAuth;

//use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends BaseController
{
    /**
     * The authentication guard that should be used.
     *
     * @var string
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @api {post} /user/login 登录(login)
     * @apiDescription 登录(login)
     * @apiGroup Auth
     * @apiPermission none
     * @apiParam {String} phone     电话
     * @apiParam {String} password  密码
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         token: eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL21vYmlsZS5kZWZhcmEuY29tXC9hdXRoXC90b2tlbiIsImlhdCI6IjE0NDU0MjY0MTAiLCJleHAiOiIxNDQ1NjQyNDIxIiwibmJmIjoiMTQ0NTQyNjQyMSIsImp0aSI6Ijk3OTRjMTljYTk1NTdkNDQyYzBiMzk0ZjI2N2QzMTMxIn0.9UPMTxo3_PudxTWldsf4ag0PHq1rK8yO9e5vqdwRZLY
     *     }
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 404 Not Found 用户没有找到
     *     {
     *       "error": "UserNotFound"
     *     }
     *
     *       HTTP/1.1 412 用户信息不完整
     *     {
     *       'status_code'=>412,
     *       'message'=>'User information is not complete'
     *     }
     */
    public function authenticate(Request $request)
    {
        $payload = [
            'account' => $request->get('account'),
            'password' => $request->get('password')
        ];

        try {
            if (!$token = JWTAuth::attempt($payload)) {
                return response()->json(['error' => 'token_not_provided'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => '不能创建token'], 500);
        }

        $inf = DB::table('member')->where('mem_phone', $request->get('phone'))->first();
        if (!$inf->mem_name){
            throw new PreconditionFailedHttpException('User information is not complete.');
        }

        return response()->json(compact('token'));
    }

    /**
     * @api {post} /user/refresh 刷新token(refresh token)
     * @apiDescription 刷新token(refresh token)
     * @apiGroup Auth
     * @apiPermission JWT
     * @apiVersion 0.1.0
     * @apiHeader {String} Authorization 用户旧的jwt-token, value已Bearer开头
     * @apiHeaderExample {json} Header-Example:
     *     {
     *       "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL21vYmlsZS5kZWZhcmEuY29tXC9hdXRoXC90b2tlbiIsImlhdCI6IjE0NDU0MjY0MTAiLCJleHAiOiIxNDQ1NjQyNDIxIiwibmJmIjoiMTQ0NTQyNjQyMSIsImp0aSI6Ijk3OTRjMTljYTk1NTdkNDQyYzBiMzk0ZjI2N2QzMTMxIn0.9UPMTxo3_PudxTWldsf4ag0PHq1rK8yO9e5vqdwRZLY"
     *     }
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         token: 9UPMTxo3_PudxTWldsf4ag0PHq1rK8yO9e5vqdwRZLY.eyJzdWIiOjEsImlzcyI6Imh0dHA6XC9cL21vYmlsZS5kZWZhcmEuY29tXC9hdXRoXC90b2tlbiIsImlhdCI6IjE0NDU0MjY0MTAiLCJleHAiOiIxNDQ1NjQyNDIxIiwibmJmIjoiMTQ0NTQyNjQyMSIsImp0aSI6Ijk3OTRjMTljYTk1NTdkNDQyYzBiMzk0ZjI2N2QzMTMxIn0.eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
     *     }
     */
    public function refreshToken()
    {
        $token = \Auth::refresh();

        return $this->response->array(compact('token'));
    }

    /**
     * @api {post} /user/register 注册(register)
     * @apiDescription 注册(register)
     * @apiGroup Auth
     * @apiPermission none
     * @apiParam {String} code     验证码
     * @apiParam {String} phone     电话
     * @apiParam {String} password  密码
     * @apiParam {String} repassword  重复密码
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *      "phone":"13350002222"
     *     }
     * @apiErrorExample {json} Error-Response:
     *     HTTP/1.1 406 用户已注册
     *     {
     *       'status_code'=>406,
     *       'message'=>'User is registered'
     *     }
     *
     *     HTTP/1.1 412 验证码错误
     *     {
     *       'status_code'=>412,
     *       'message'=>'Verification code error'
     *     }
     *
     *     HTTP/1.1 412 两次输入的密码不一致
     *     {
     *       'status_code'=>412,
     *       'message'=>'Password error'
     *     }
     */
    public function register(Request $request)
    {
        $newUser = [
            'name' => $request->get('name'),
            'account' => $request->get('account'),
            'password' => bcrypt($request->get('password'))
        ];
        $user = Member::create($newUser);
        $token = JWTAuth::fromUser($user);
        return $token;
    }



    /**
     * @api {get} /user/me 个人信息(info)
     * @apiDescription 个人信息
     * @apiGroup Auth
     * @apiPermission JWT
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *
     *   {
     *      "id": 4,
     *      "mem_name": null,
     *      "mem_phone": "13350006666",
     *      "mem_sex": 1,
     *      "mem_IDnum": null,
     *      "mem_edu": null,
     *      "mem_school": null,
     *      "mem_grade": null,
     *      "mem_pic": null,
     *      "mem_birth": null,
     *      "mem_status": 1,
     *      "mem_is_online": 0,
     *      "mem_role": 1,
     *      "created_at": null,
     *      "updated_at": null
     *   }
     */
    public function AuthenticatedUser()
    {
//        try {
//            if (!$user = JWTAuth::parseToken()->authenticate()) {
//                return response()->json(['user_not_found'], 404);
//            }
//        } catch (TokenExpiredException $e) {
//            return response()->json(['token_expired'], $e->getStatusCode());
//        } catch (TokenInvalidException $e) {
//            return response()->json(['token_invalid'], $e->getStatusCode());
//        } catch (JWTException $e) {
//            return response()->json(['token_absent'], $e->getStatusCode());
//        }

        $user = $this->user();
        if ($user['mem_pic']) $user['mem_pic'] = $this->getImage($user['mem_pic']);
        // the token is valid and we have found the user via the sub claim
        return response()->json($user);
    }


}