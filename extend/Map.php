<?php
/*
百度地图相关业务封装
*/
class Map{
	/*
	根据地址来获取经纬度
	*@param $address
	*@return array
	*/
	public static function getLngLat($address){
		if (!$address) {
			return '';
		}
		//http://api.map.baidu.com/geocoder/v2/?address=北京市海淀区上地十街10号&output=json&ak=您的ak&callback=showLocation //GET请求
		$data = [
			'address' => $address,
			'ak' => config('map.ak'),
			'output' => 'json',
		];
		$url =config('map.baidu_map_url').config('map.geocoder').'?'.http_build_query($data);
		//1 file_get_contents($url);
		//2 curl 
		$result=doCurl($url);
		//print_r($result);exit;
		if ($result) {
			return json_decode($result,true);
		}else{
			return [];
		}
		return $result;
	}
	//http://api.map.baidu.com/staticimage/v2
	//根据经纬度或者地址来获取百度地图staticimage
	public static function staticimage($center){
		if (!$center) {
			return '';
		}
		$data = [
			'ak' => config('map.ak'),
			'width' => config('map.width'),
			'height' => config('map.height'),
			'center' => $center,
			'maekers' =>$center,
		];
		$url =config('map.baidu_map_url').config('map.staticimage').'?'.http_build_query($data);
		//1 file_get_contents($url);
		//2 curl 
		$result=doCurl($url);
		//print_r($result);exit;
		return $result;
	}
}