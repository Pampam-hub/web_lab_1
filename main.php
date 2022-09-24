<?php
$number_reg_exp = '/^([-\+]?\d+[\.]\d+|[-\+]?\d+|[-\+]?\d+([\.]\d+)?e[-\+]?\d+)$/';
session_start();

function validation($param) {
    global $number_reg_exp;
    return preg_match($number_reg_exp, $param);
}

function check_hit($r, $x, $y) {
    $first_quarter = false;
    $second_quarter = false;
    $third_quarter = false;

    if ( $x >= 0 && $x <= $r && $y >=0 && $y <= $r / 2 ) {
        $first_quarter = true;
    }

    if ( $x <= 0 && $y >= 0 && $x * $x + $y * $y <= $r * $r ) {
        $second_quarter = true;
    }

    if ( $x <= 0 && $y <= 0 && $y >= $x - $r ) {
        $third_quarter = true;
    }

    return $first_quarter || $second_quarter || $third_quarter;
}

function check_cookie() {
    if( !isset( $_COOKIE['informed']) ) {
        unset($_SESSION['table_res']);
    }
}

if ( $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['cookie']) ) {

    setcookie('informed', '1');
    exit();

} else if ( $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['table'])) {

    if( isset( $_COOKIE['informed']) && isset($_SESSION['table_res']) ) {
        exit( $_SESSION['table_res'] );
    }

    check_cookie();

} else if ( $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['unset']) ) {

    unset($_SESSION['table_res']);

} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $start = microtime(true);
    
    $R_value = trim($_GET['R']);
    $X_value = trim($_GET['X']);
    $Y_value = trim($_GET['Y']);
    $current_time = date("H:i:s", time() - $_GET['Time'] * 60);

    $result_hit = '';

    if ( validation($R_value) && validation($X_value) && validation($Y_value) ) {
        $R = (float) $R_value;
        $X = (float) $X_value;
        $Y = (float) $Y_value;
        
        if($R < 0) {
            exit('R должно быть неотрицательное!)');
        }
        
        if ( check_hit($R, $X, $Y) ) {
            $result_hit = 'Попадение)';
        } else {
            $result_hit = 'Промах(';
        }
        $finish_time = number_format(microtime(true) - $start, 7, ".", "")  * 1000;

        $res = "
        <tr>
            <td>$R_value</td>
            <td>$X_value</td>
            <td>$Y_value</td>
            <td>$result_hit</td>
            <td>$current_time</td>
            <td>$finish_time</td>
        </tr>
        ";

        if( isset($_SESSION['table_res']) ) {
           $_SESSION['table_res'] .= $res;
        } else {
            $_SESSION['table_res'] = $res;
        }
        exit($res);
    } else {
        exit('Некорректный запрос( необходимо присвоить всем переменным числа! (разделитель - точка)');
    }         
} else {
    exit('Некорректный запрос: не обрабатываем такое(');
}