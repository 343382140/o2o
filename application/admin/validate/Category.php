<?php
namespace app\admin\validate;
use think\Validate;
class Category extends Validate
{
    protected $rule = [
        ['name','require|max:10','分类名不能为空|分类名长度不能超过10'],
        ['parent_id','number'],
        ['id','number'],
        ['status','number|in:-1,0,1','状态必须是数字|状态不合法'],
        ['listorder','number'],
    ];
    protected $scene = [
        'add' => ['name', 'parent_id','id'],
        'list_order' => ['id', 'listorder'],
        'status' => ['id', 'status'],
    ];
}
