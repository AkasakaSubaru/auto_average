<!DOCTYPE html>
<html>
    <head>
        <title>結果</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="layout.css">
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    </head>
    <body>
        <h1 class="center">結果</h1>
        <?php
        $error = true;
        $log = 0;
        $number_list = $_POST['number_list'];
        $number_list_str = $number_list;       //入力された数値の文字列化
        echo mb_convert_kana($number_list_str,"arn");
        $result_array = array();        //数値の格納用arrayリスト
        $result_array_int = array();
        $sum = 0;
        $result = 0;
        $number_count = strlen($number_list_str);
        function Comparison_color($average,$value){     //平均値との比較の色分け
            if($average < $value){
                $return = "bottom";
            }else if($average > $value){
                $return = "up";
            }else{
                $return = "normal";
            }
            return $return;
        }
        function Comparsion_str($average,$value){
            if($average < $value){
                $return = '<i class="fas fa-chevron-up"></i>';
            }else if($average > $value){
                $return = '<i class="fas fa-chevron-down"></i>';
            }else{
                $return = '<i class="fas fa-minus"></i>';
            }
            return $return;
        }
        if(!strpos($number_list_str,",")){
        ?>
        <p>値が一つしか入力されていません。二つ以上の値を入力して下さい</p>
        <?php
        }else{
            for($int = 0;$int <= $number_count;$int++){          //文字列ぶんの繰り返し
                $value = substr($number_list_str,$int,1);       //intの数に当たる文字の格納
                if($value == ","){      //もし、intに当たる文字にコンマが含まれていたら
                    if(empty($log)){
                        $push = substr($number_list_str,0,$int);
                    }else{
                        $push = substr($number_list_str,$log+1,$int-$log-1);
                    }
                    if($push >= 1000000){
                        echo "<p>値が大きすぎます。処理を中止します</p>";
                        $error = false;
                        break;
                    }
                    array_push($result_array,$push);
                    $log = $int;        //コンマの位置の記録
                }
                if($int == $number_count){
                    array_push($result_array,substr($number_list_str,$log+1,$number_count-$log));
                }
            }
            if($error){
                for($int = 0;$int < count($result_array);$int++){       //配列内の全ての値をint型に変更する
                    $value = $result_array[$int];
                    array_push($result_array_int,(int)$value);
                }
                for($int = 0;$int < count($result_array_int);$int++){
                    $sum += $result_array_int[$int];
                }
                $result = $sum / count($result_array_int);
                $result = round($result,2);
            }
        }
        if($error){
            echo '<p class="center">結果は<span class="result">'.$result.'</span>です</p>';
            echo '<p class="center sub-title">詳しい結果</p>';
        ?>
        <table border="1" align="center">
            <tr>
                <th style="padding-left: 10px;padding-right: 10px;">値</th><th>平均値の比較</th>
            </tr>
            <?php
            $num = 1;
            foreach($result_array_int as $value){
                echo "<tr>";
                $str = Comparsion_str($result,$value);
                echo "<td>{$value}</td><td><span class='".Comparison_color($result,$value)."'>{$str}</td>";
                echo "</tr>";
                $num++;
            }
        }
            ?>
        </table>
    </body>
</html>