<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: center;
        padding: 8px;
        border: 1px solid black;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
</head>
<body>
    <table>
        <tr>
            <th>输入的单词</th>
            <th>正确单词</th>
            <th>是否正确</th>
        </tr>
<!-- 收集错误单词 -->
<?
    $servername = "localhost";
    $username = "csmyswe";
    $password = "DmrxyfaExptNcAMn";
    $dbname = "csmyswe";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    //检查连接是否成功
    if (!$conn) {
        echo'<script>alert("数据库通信错误，请联系负责人")</script>';
        die("连接失败: " . mysqli_connect_error());
    }
    session_start();
    if (isset($_SESSION['username_sql'])) {
        $username_sql = $_SESSION['username_sql'];
        $result = mysqli_query($conn,"SELECT * FROM `user` WHERE username='$username_sql'");//查询
        $row = mysqli_fetch_array($result);
        $ID = $row[0];//登陆的用户
    }
    
    session_start();
    $my_values_array = $_SESSION['word'];//全部单词数组
    $arraylength = $_SESSION['numb'];//单词长度// 定义一个空数组，用于存储错误单词及其对应的汉语
    echo '<h3>本次自测错误单词</h3>';
    if (isset($_POST['submit'])) {
        for ($i = 0; $i < $arraylength; $i++) {
            $arr = explode('：', $my_values_array[$i]);
            $second_element = $arr[0];
            $second_element_chines = $arr[1];
            $English = $second_element;
            // echo $_POST['input'.$i];
            
            if($English == $_POST['input'.$i]){
                echo '<tr>';
                echo '<td>'.$second_element.'</td>';
                echo '<td>'.$English.'</td>';
                echo '<td style="color:green">正确</td>';
                echo '</tr>';
            }else{
                echo '<tr>';
                echo '<td>'.$_POST['input'.$i].'</td>';
                echo '<td>'.$English.'</td>';
                echo '<td style="color:red">错误</td>';
                echo '</tr>';
                $errorwords_array[] = array($English => $second_element_chines);
            }
        }
    }
    //存入本地会话
    if (isset($errorwords_array)) {
        session_start();
     $_SESSION['errorwords_array'] = $errorwords_array;
    }

?>
<!-- 读取上次错误单词 -->
<? 
    //读取错误单词
    //判断你是否已登陆
    
    if (isset($_SESSION['username_sql'])) {
        $username_sql = $_SESSION['username_sql'];
        $result = mysqli_query($conn,"SELECT * FROM `user` WHERE username='$username_sql'");//查询
        $row = mysqli_fetch_array($result);
        $jsonword = $row[4];//登陆的用户
        $word_sql = $jsonword;
        //解析json
        $arr = json_decode($word_sql, true);
        
        // 开始创建表格
        echo '<table>';
        echo '<h3>最后测试错误的单词</h3>';
        echo  '<hr>';    
        // 添加表头行
        echo '<tr>';
        echo '<th>单词</th>';
        echo '<th>汉语</th>';
        echo '</tr>';
        
        // 添加数据行
        foreach ($arr as $item) {
            foreach ($item as $key => $value) {
                $decoded_value = mb_convert_encoding(pack("H*", str_replace("u", "", $value)), "UTF-8", "UCS-2BE");
                echo '<tr>';
                echo '<td>' . $key . '</td>';
                echo '<td>' . $decoded_value . '</td>';
                echo '</tr>';
            }
        }
        
        // 结束表格
        echo '</table>';
    }
?>
<!-- 记录错误单词 -->
<?
    //记录错误单词
    //判断是否存在错误单词
    if (isset($errorwords_array)) {
        session_start();
        //判断是否已经登陆
        if (isset($_SESSION['username_sql'])) {
            //将错误单词数组转换成json格式
            $errorwords_json = json_encode($errorwords_array);
            
            // 将错误单词保存到数据库
            $sql = "UPDATE `user` SET `custom` = '$errorwords_json' WHERE `user`.`ID` = '$ID'";
            //判断是否存入成功
            if ($conn->query($sql) === TRUE) {
                echo'<h3>检测到您已登陆并且存在错误单词，已将您的错误单词存入历史记录数据库。</h3>';
            } else {
            echo'<script>alert("写入失败")</script>';
            echo "Error: " . $sql . "<br>" . $conn->error;
            }   

        }else{
            echo'<script>alert("检测到您未登陆，建议您登陆后可享受保存错误单词并显示上次错误单词的功能")</script>';
            echo '<h4>若您未注册，<a href="https://xz-kun-xiang.com:48126/PHP/PHP%E5%86%85%E5%AE%B9%E5%B1%95%E7%A4%BA/%E6%B5%8B%E5%8D%95%E8%AF%8D/register.php">点击这里</a>进行注册</h4>';
        }

    }

?>
    </table>
    <a href="./main.php">重新测试</a>  


  
</body>
</html>
