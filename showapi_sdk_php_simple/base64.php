<?php

	
	$url = "http://route.showapi.com/xxxxx-xxxxx"; //调用地址
	$showapi_appid="xxxx";
	$showapi_sign="xxxxxxxxxxxx";
	$typeId="34";		//根据情况改变此值
	$file = "/1.jpg"; 	//根据情况改变此值
	
	
	
	/**
	 * 发送HTTP请求方法
	 * @param  string $url    请求URL
	 * @param  array  $params 请求参数
	 * @param  string $method 请求方法GET/POST
	 * @return array  $data   响应数据
	 */
	function http($url, $params, $method = 'GET',  $multi = false){
		//定义发送头
		$header = array(
		    'Content-Type: application/x-www-form-urlencoded; charset=utf-8'
		);
	    $opts = array(
	            CURLOPT_TIMEOUT        => 30,
	            CURLOPT_RETURNTRANSFER => 1,
	            CURLOPT_SSL_VERIFYPEER => false,
	            CURLOPT_SSL_VERIFYHOST => false,
	            CURLOPT_HTTPHEADER     => $header,
	    );
	    /* 根据请求类型设置特定参数 */
	    switch(strtoupper($method)){
	        case 'GET':
	        	//http_build_query方法已经自带urlencode
	            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);  
	            break;
	        case 'POST':
	            //判断是否传输文件
	            $params = $multi ? $params : http_build_query($params);
	            //var_dump( $params);
	            $opts[CURLOPT_URL] = $url;
	            $opts[CURLOPT_POST] = 1;
	            $opts[CURLOPT_POSTFIELDS] = $params;
	            break;
	        default:
	            throw new Exception('不支持的请求方式！');
	    }
	    /* 初始化并执行curl请求 */
	    $ch = curl_init();
	    curl_setopt_array($ch, $opts);
	    $response  = curl_exec($ch);
	    //echo  $response;
	    $error = curl_error($ch);
    	if($error) throw new Exception('请求发生错误：' . $error);
    	return  $response;
	}
	
	
	/**
	 * 发送HTTP请求方法
	 * @param  string  $file_path  文件路径
	 * @return string  $base64   文件转化为的base64串
	 */
	function base64EncodeImage ($file_path) {
	 	$fp = fopen($file_path,"rb", 0);
    	$content = fread($fp,filesize($file_path)); 
    	fclose($fp); 
    	$base64 = base64_encode($content); 
	  	return $base64;
	}
 
 
	$base64=base64EncodeImage($file);
	$data=array(
	    "showapi_appid" => $showapi_appid,
	    "showapi_sign" => $showapi_sign,
	    "img_base64" => $base64,
	    "typeId" => $typeId,
    );
	//定义返回值接收变量；
	$http_ret = http($url, $data, 'POST' );
	print_r($http_ret)
?>