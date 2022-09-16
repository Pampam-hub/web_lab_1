<?php
$numberRegExp = '/^(-?\d+[\.]\d+|-?\d+|-?\d+([\.]\d+)?e[-\+]?\d+)$/';
function validation($param) {
    global $numberRegExp;
    return preg_match($numberRegExp, $param);
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


 if ( $_SERVER["REQUEST_METHOD"] === "GET" ) {
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
        
        
        if ( check_hit($R, $X, $Y) ) {
            $result_hit = 'Попадение)';
        } else {
            $result_hit = 'Промах(';
        }
        $finish_time = number_format(microtime(true) - $start, 7, ".", "")  * 1000;

        exit("
        <tr>
            <td>$R_value</td>
            <td>$X_value</td>
            <td>$Y_value</td>
            <td>$result_hit</td>
            <td>$current_time</td>
            <td>$finish_time</td>
        </tr>
        ");
    } else {
        exit('Некорректный запрос( нужны числа!');
    }
    
    
}