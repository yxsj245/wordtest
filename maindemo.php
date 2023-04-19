<?
        session_start();
        $my_values_array = $_SESSION['word'];
        $arraylength = $_SESSION['numb'];
        if (isset($_POST['input0'])) {
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
    }
?>
