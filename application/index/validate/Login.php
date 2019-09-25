<?php
/**
 * Created by PhpStorm.
 * User: xiaoqiang
 * Date: 2017/5/22
 * Time: 上午9:59
 */
namespace app\index\validate;
use think\Validate;
class Login extends Validate
{
    protected $rule = [
        ['username','require','请输入用户名'],
        ['password','require','请输入密码'],
        //['verify_code','require','请输入验证码'],
    ];
    protected $scene = [
        'login' => ['username','password','verify_code'],
    ];
}
