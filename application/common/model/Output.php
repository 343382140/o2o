<?php


namespace app\common\model;

use think\Model;
class Output extends Model
{
    public function destroyOutputHistory($id) {
        $data = [
            'id' => $id,
        ];
        return $this->where($data)->delete();
    }
}