<?php
	
	$url = "http://route.showapi.com/xxxxx-xxxxx"; //调用地址
	$METHOD = "POST";				//或者GET。根据情况选择
	$showapi_appid="xxx";
	$showapi_sign="xxxxxxxxxxxxxxxx";
	$text="这是一段测试的文本";   	//根据情况改变此值
	$num="3";						//根据情况改变此值
	

	/**
	 * 发送HTTP请求方法
	 * @param  string $url    请求URL
	 * @param  array  $params 请求参数
	 * @param  string $method 请求方法GET/POST
	 * @return array  $data   响应数据
	 */
	function http($url, $params, $method = 'POST' ){
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
	    //http_build_query方法已经自带urlencode
	    $params =  http_build_query($params);
	    switch(strtoupper($method)){
	        case 'GET':
	            $opts[CURLOPT_URL] = $url . '?' . $params;  
	            break;
	        case 'POST':
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
	    echo  $response;
	    $error = curl_error($ch);
    	if($error) throw new Exception('请求发生错误：' . $error);
    	return  $response;
	}
	
	//定义传递的参数数组，里面的值不要做urlencode
	$data=array(
	    "showapi_appid" => $showapi_appid,
	    "showapi_sign" => $showapi_sign,
	    "text" =>$text,
	    "num" => $num
    );
	//定义返回值接收变量；
	$httpstr = http($url, $data, 'POST' );
?>