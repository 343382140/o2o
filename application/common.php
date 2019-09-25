<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// // 应用公共文件
// function status($status){
// 	if($status ==1){
// 		$str="<span class='label label-success radius'>正常</span>";
// 	}elseif ($status ==0) {
// 		$str="<span class='label label-danger radius'>待处理</span>";
// 	}elseif ($status ==-1){
// 		$str="<span class='label label-danger radius'>已删除</span>";
// 	}else{
// 		$str="<span class='label label-danger radius'>待审</span>";
// 	}
// 	return $str;
// }

//判断分类状态,返回文本
//服务分类发布状态、商户审核
function status($status) {
    if($status == 1) {
        $str = "<span class='label label-success radius'>正常</span>";
    }elseif ($status == 0){
        $str = "<span class='label label-danger radius'>待审</span>";
    }else {
        $str = "<span class='label label-danger radius'>删除</span>";
    }
    return $str;
}

//提现
function statusOutput($status) {
    if($status == 1) {
        $str = "<span class='label label-success radius'>已完成</span>";
    }elseif ($status == 0){
        $str = "<span class='label label-danger radius'>待审</span>";
    }else {
        $str = "<span class='label label-danger radius'>删除</span>";
    }
    return $str;
}

function pay_status($pay_status){
	if($pay_status ==1){
		$str="<span class='label label-success radius'>已支付</span>";
	}elseif ($pay_status ==0) {
		$str="<span class='label label-danger radius'>未支付</span>";
	}elseif ($pay_status ==-1){
		$str="<span class='label label-danger radius'>已删除</span>";
	}else{
		$str="<span class='label label-danger radius'>待审核</span>";
	}
	return $str;
}

function user_status($user_status){
	if ($user_status == 1) {
		$str="<span class='label label-success radiu'>已启用</span>";
	}elseif($user_status == 0){
		$str="<span class='label label-defaunt radius'>已停用</span>";
	}elseif($user_status == -1){
		$str="<span class='label label-danger radius'>已删除</span>";
	}else{
		$str="<span class='label label-danger radius'>待审核</span>";
	}
	return $str;
}

/*
int type 0 get 1 post
 */
function doCurl($url,$type=0,$data=[]){
	$ch =curl_init(); //初始化
	//设置选项
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);

	if($type==1){
		//post
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}

	//执行并获取内容
	$output=curl_exec($ch);
	//释放curl句柄
	curl_close($ch);
	return $output;
}
//商户入驻申请文案
function bisRegister($status){

	if ($status == 1) {
		$str="入驻申请成功";
	}elseif($status == 0){
		$str="待审核，审核后平台方会发送邮件通知，请关注邮件";
	}elseif($status == 2){
		$str="非常抱歉，您提交的材料不符合条件，请重新提交";
	}else{
		$str="该申请已被删除";
	}
	return $str;
}
/*
	通用的分页样式
 */
function pagination($obj){
	if (!$obj) {
		return '';
	}
	//优化的方案
	$params=request()->param();
	return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o">'.$obj->appends($params)->render().'</div>';
}

function getSeCityName($path){
	if (empty($path)) {
		return '';
	}
	if (preg_match('/,/',$path)) {
		$cityPath = explode(',', $path);
		$cityId=$cityPath[1];
	}else{
		$cityId=$path;
	}

	$city=model('City')->get($cityId);
	return $city->name;
}

function getSeCategoryName($path){
	if (empty($path)) {
		return '';
	}
	if (preg_match('/,/',$path)) {
		$cityPath = explode(',', $path);
		$cityId=$cityPath[1];
	}else{
		$cityId=$path;
	}

	$city=model('City')->get($cityId);
	return $city->name;
}

function countLocation($ids){
	if (!$ids) {
		return 1;
	}

	if (preg_match('/,/',$ids)) {
		$arr = explode(',', $ids);
		return count($arr);
	}else{
		return 1;
	}
}

//设置订单号
function setOrderSn(){
	list($t1,$t2) = explode(' ',microtime());
	//dump(microtime());exit;
	//echo $t1."<br />";
	//echo $t2."<br />";exit;
	$t3=explode('.', $t1*10000);
	return $t2.$t3[0].(rand(10000,99999));
}

//获取商家名称
function getBisName($id){
	$bis=model('Bis')->get($id);
	return $bis->name;
}

//bis-订单
function statusOrders($status) {
    if($status == 1) {
        $str = "<span class='label label-success radius'>已付款</span>";
    }elseif ($status == 0){
        $str = "<span class='label label-danger radius'>待付款</span>";
    }else if ($status == 2){
        $str = "<span class='label label-danger radius'>已完成</span>";
    }else{
    	$str="<span class='label label-danger radius'>已删除</span>";
    }
    return $str;
}

function statusCoupons($status) {
    if($status == 1) {
        $str = "<span class='label label-danger radius'>已使用</span>";
    }elseif ($status == 0){
        $str = "<span class='label label-success radius'>未使用</span>";
    }else if ($status == 2){
        $str = "<span class='label label-default radius'>已过期</span>";
    }
    return $str;
}