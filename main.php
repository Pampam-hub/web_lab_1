<?php
$numberRegExp = '/^(-?\d+\.\d+|-?\d*|-?\d+(\.\d+)?e[-\+]?\d+)$/';

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

    $R_value = trim($_GET['R']);
    $X_value = trim($_GET['X']);
    $Y_value = trim($_GET['Y']);

    $validaition_error = '';
    $result_hit = '';

    if ( validation($R_value) && validation($X_value) && validation($Y_value) ) {
        $R_value = (float) $R_value;
        $X_value = (float) $X_value;
        $Y_value = (float) $Y_value;

        if ( check_hit($R_value, $X_value, $Y_value) ) {
            $result_hit = 'Попадение)';
        } else {
            $result_hit = 'Промах(';
        }
        exit("
        <tr>
            <td>$R_value</td>
            <td>$X_value</td>
            <td>$Y_value</td>
            <td>$result_hit</td>
            <td>Время</td>
            <td>Время исполнения</td>
        </tr>
        ");
    } else {
        exit("Некорректный запрос( нужны числа!");
    }
    
    
}