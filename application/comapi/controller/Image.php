<?php
namespace app\comapi\controller;
use think\Controller;
use think\File;
use think\Request;
class Image extends Controller
{
    public function upload() {
        $file = Request::instance()->file('file');
        // 指定目录用于保存上传的图片($info-状态信息)
        $info = $file->move('upload');
        if($info && $info->getPathname()) {
            return show(1, 'success', '/'.$info->getPathname());
        }
        return show(0, 'upload error');
    }
}