<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <style>
        /* 修改标题的样式 */
        h1 {
            text-align: center;
            font-size: 32px;
            margin-top: 50px;
        }
        
        /* 修改正文的样式 */
        body {
            font-size: 18px;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }
        
        /* 调整表单的位置和宽度 */
        form {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            border-radius: 4px;
        }
        
        /* 设置文本框的样式 */
        input[type="text"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="password"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        /* 设置提交按钮的样式 */
        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
        }
        /* 设置错误提示的样式 */
        #myDiv {
            margin-top: 20px;
            padding: 10px;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }
        .words{
            color: blue;
        }
        h4{
            text-align: center;
        }
    </style>
</head>
<body>
    <div style="width: 100%; overflow: hidden;">
    <marquee behavior="scroll" direction="left">
        <p class="words">公告1.本程序目前处于测试期间，部分功能尚未完善，期待大家的建议;</p>
    </marquee>
    </div>
    <div id="reg">
        <form method="post">
            请输入账号: <input type="text" name="username">
            请输入密码: <input type="password" name="password">
            <input type="submit" value="登陆">
    </form>
    </div>
    <h1>小朱单词测试程序网页版bata</h1>
    <? 
    // 获取用户提交的表单数据
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    $password = $_POST['password'];

    // 读取已注册用户信息
    $users = file_get_contents('users.txt');

    // 将用户信息分割成数组
    $users = explode("\n", $users);

    // 遍历用户信息数组，检查是否匹配
    foreach ($users as $user) {
        $info = explode(':', $user);
        if ($info[0] == $username && $info[1] == $password) {
            echo '<h4>欢迎'.$username.'用户的使用</h4>';
            echo '<script>alert("登陆成功");</script>';
            break;
        }else{
            echo '<script>alert("账号或密码错误或未注册");</script>';
        }
    }        
    }


    // 如果循环完毕还未匹配成功，则登录失败
    
?>

    <?
        error_reporting(E_ERROR);
        ini_set("display_errors","off");
        $url = 'http://43.248.187.3:48139/api/everyday';
    
        // 初始化cURL
        $curl = curl_init($url);
        
        // 设置cURL选项
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        // 执行cURL请求
        $response = curl_exec($curl);
        
        // 关闭cURL资源
        curl_close($curl);
        
        // 将响应转换为PHP数组
        $data = json_decode($response, true);
        
        // 输出响应结果
        if (is_null($data)) {
            echo 'Failed to decode JSON response';
        } else {
            // print_r($data);
            $wordList = $data;
            $data_array = $wordList["data"];//单词数组$data_array 
        }
        // print_r($wordList);
        // echo count($data_array);
        $arraylength = count($data_array);
        // 将关联数组转换为索引数组
        $my_values_array = array_values($data_array);
        // echo $my_values_array[1];
        //分割
        for ($i = 0; $i < $arraylength; $i++) {
            $arr = explode('：', $my_values_array[$i]);
            $second_element = $arr[1];
            $Chinese = $second_element;
            
            echo '<form method="post" id="myForm">';
            echo $Chinese;
            echo '<label for="input' . $i . '"></label>';
            echo '<input type="text" id="input' . $i . '" name="input' . $i . '"><br>';
        }
        echo '<input type="submit" value="提交">';
        echo '<div id="myDiv">';
        
        for ($i = 0; $i < $arraylength; $i++) {
            $arr = explode('：', $my_values_array[$i]);
            $second_element = $arr[0];
            $English = $second_element;
            // echo $_POST['input'.$i];
            if($English == $_POST['input'.$i]){
                echo '正确<br>';
            }else{
                
                echo '错误'.$English.'<br>';
            }
        }
	?>

	<button type="button" onclick="hideContent()">重新练习</button><br>
    <script>
    
    function hideContent() {
      // 获取需要隐藏的元素
      var element = document.getElementById("myDiv");
      
      // 修改元素的样式，使其隐藏
      element.style.display = "none";
    }
    </script>

</body>
</html>
