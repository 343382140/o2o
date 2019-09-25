<?php
namespace app\common\validate;
use think\Validate;
class Bis extends Validate {
    protected $rule = [
        'name' => 'require|max:25',
        'email' => 'email',
        'logo' => 'require',
        'city_id' => 'require',
        'contractor' => 'require',
        'tel' => 'require',
    ];

    // 场景设置
    protected  $scene = [
        'add' => ['name', 'email', 'logo', 'city_id', 'contractor', 'tel'],
    ];
}