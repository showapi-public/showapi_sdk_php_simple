<?php
	$ch = curl_init();
	$url = "http://route.showapi.com/xxxxx-xxxxx"; //调用地址
	$showapi_appid="xxxx";
	$showapi_sign="xxxxxxxxxxx";
	$typeId="34";//根据情况改变此值
	$filePath = '/1.jpg'; //根据情况改变此值
	
	
	
	
	$data=array(
	    "showapi_appid" => $showapi_appid,
	    "showapi_sign" => $showapi_sign,
	    "image" => '@' . $filePath,
	    "typeId" => $typeId
    );
	//兼容高版本的curl
	if (class_exists('\CURLFile')) {
	    $data['image'] = new \CURLFile(realpath($filePath));
	} else {
	    if (defined('CURLOPT_SAFE_UPLOAD')) {
	        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, FALSE);
	    }
	}
	
	curl_setopt($ch, CURLOPT_URL, $url );
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	
	curl_exec($ch);
	//echo  $response;
	$error = curl_error($ch);
	if($error) throw new Exception('请求发生错误：' . $error);
?>