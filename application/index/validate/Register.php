<?php
namespace app\index\validate;
use think\Validate;
class Register extends Validate
{
    protected $rule = [
        ['username','require|max:10','用户名不能为空|用户名长度不能超过11'],
        ['email','require|email','邮箱不能为空|邮箱格式不正确'],
        ['password','require|min:8|max:16','密码不能为空','密码最少为8位','密码不可超过16位'],
        ['re_password','require','请输入确认密码'],
        ['verify_code','require','请输入验证码'],
    ];
    protected $scene = [
        'register' => ['username', 'email','password','re_password','verify_code'],
    ];
}
