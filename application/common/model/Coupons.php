<?php


namespace app\common\model;

use think\Model;
class Coupons extends Model
{
    public function saveCoupons($data) {
        return $this->save($data);
    }
}