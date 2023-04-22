<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>单词测试前端</title>
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
                .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        
        .modal-content {
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            padding: 20px;
            background-color: #fff;
            text-align: center;
        }
        
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- ----公告系统---- -->
<?php
// 关闭警告和提示错误的显示 开发时请注释
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('display_errors', 0);
?>

<?php
// 检查是否存在名为“my_cookie”的cookie
if (!isset($_COOKIE['my_cookie'])) {
    echo'<div class="modal">';
    echo'<div class="modal-content">';
  echo'<h1>致访问者</h1>';
  echo'<p>检测到您是首次访问本站我表示非常欢迎，以下是关于本站点的简介：<br>1.本站采用HTML CSS JS PHP 以及数据库编写<br>2.本站需要使用cookie来实现部分功能（例如：首次公告弹出）请您知晓<br>3.本站点前端采用PHP进行数据处理以及生成动态网页HTML JS负责交互 项目作者：朱世祥，编写不易，希望大家支持</p>';
  setcookie('my_cookie', '1.0.0', strtotime('2038-01-01'));
 
}

// 如果cookie存在，检查cookie值是否匹配所需的值
 $cookie_value = $_COOKIE['my_cookie'];
if ($cookie_value !== '1.0.0') {
setcookie('my_cookie', '1.0.0', strtotime('2038-01-01'));
echo'<script>alert("4月21号站点更新日志：1.调整错误单词列表样式，使其更加醒；2.正式启用数据库，单词错误将存入数据库;3.支持上次错误单词显示")</script>';
}

?>
    <button class="close">关闭</button>
  </div>
</div>
<!-- ----公告系统结束---- -->

    <marquee width = "100%" behavior = "scrol1" bgcolor = "pink">
        火狐浏览器用户请注意：由于火狐自带表单记录功能，如果需要关闭可以<a href="https://xz-kun-xiang.com:48143/threads/%E6%B5%8B%E5%8D%95%E8%AF%8D%E7%BD%91%E9%A1%B5%E7%AB%AF%E5%85%B3%E9%97%AD%E7%81%AB%E7%8B%90%E8%87%AA%E5%B8%A6%E8%A1%A8%E5%8D%95%E8%AE%B0%E5%BD%95%E5%8A%9F%E8%83%BD.117/">点击这里</a>查看关闭教程
    </marquee>

    <form action=""></form>
    <div id="reg">
        <form method="post">
            请输入账号: <input type="text" name="username">
            请输入密码: <input type="password" name="password">
            <input type="submit" value="登陆">
    </form>
    </div>
    <h1>单词测试程序网页版bata</h1>
    <!-- ----登陆系统---- -->
    <? 
        // 连接数据库
        $servername = "localhost";
        $username = "csmyswe";
        $password = "DmrxyfaExptNcAMn";
        $dbname = "csmyswe";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        
        //检查连接是否成功
        if (!$conn) {
            echo'<script>alert("数据库通信错误，暂时无法登陆，请联系负责人")</script>';
            die("连接失败: " . mysqli_connect_error());
        }
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $result = mysqli_query($conn,"SELECT * FROM `user` WHERE username='$username'");//查询
            $row = mysqli_fetch_array($result);
            if ($row>0){
                $username_sql = $row[1];
                $password_sql = $row[2];
                $text = $row[3];
                if($username_sql == $username && $password_sql==$password){
                    session_start();
                    $_SESSION['username_sql'] = $username_sql;
                    echo '<h3 style="text-align:center;">欢迎'.$username.'使用</h3>';
                    echo '<h4 style="text-align:center;">'.$text.'</h4>';
                    session_start();
                    $_SESSION['username'] = $username;
                }else{
                    echo'<script>alert("登陆失败：密码错误")</script>';
                }
            } else{
            echo'<script>alert("用户不存在")</script>';
            }
        }
    // 关闭数据库连接
    mysqli_close($conn);
    ?>
    <!-- ----登陆系统结束---- -->
    <!-- ----单词系统---- -->
    <?
        // 请求每日单词接口
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
        
        // 判断是否转换成功
        if (is_null($data)) {
            echo 'Failed to decode JSON response';
        } else {
            // print_r($data);
            $wordList = $data;
            $data_array = $wordList["data"];//将单词存入数组
        }
        $arraylength = count($data_array);
        $new_data_array = array();

        // 随机取值并存入 $new_data_array 数组
        for ($i = 0; $i < $arraylength; $i++) {
            $index = array_rand($data_array); // 随机取出一个索引值
            $new_data_array[] = $data_array[$index]; // 将对应的元素存入新数组
            unset($data_array[$index]); // 将已经取出的元素从原数组中删除
        }
        session_start();
        $_SESSION['word'] = $new_data_array;
        $_SESSION['numb'] = $arraylength;
        for ($i = 0; $i < $arraylength; $i++) {
            $arr = explode('：', $new_data_array[$i]);
            $second_element = $arr[1];
            $Chinese = $second_element;
            // 生成表单
            echo '<form method="post" id="myForm" action="maindemo.php">';
            echo $Chinese;
            echo '<label for="input' . $i . '"></label>';
            echo '<input type="text" id="input' . $i . '" name="input' . $i . '"><br>';
        }
        echo '<input type="submit" name="submit"value="提交">';
        echo '<div id="myDiv">';
	?>
    <!-- ----单词系统结束---- -->
    <!-- 弹窗JS效果 -->
	    <script>
      // 获取弹窗和关闭按钮元素
      var modal = document.querySelector('.modal');
      var closeButton = document.querySelector('.close');
      
      // 点击关闭按钮时隐藏弹窗
      closeButton.addEventListener('click', function() {
        modal.style.display = 'none';
      });
      
      // 在页面加载时显示弹窗
      window.addEventListener('load', function() {
        modal.style.display = 'block';
      });
    </script>
</body>
</html>
