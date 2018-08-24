<?php

//하늘상태 코드
function sky_code($code){
    switch($code){
        case (2>=$code && 0<=$code):
            return "맑음";
        break;
        case (5>=$code && 3<=$code):
            return "구름 조금";
        break;
        case (8>=$code && 6<=$code):
            return "구름 많음";
        break;
        case (10>=$code && 9<=$code):
            return "흐림";
        break;
    }
}

//강수형태 코드
function rn1_code($code){
    switch($code){
        case (0==$code && is_null($code)):
            return "0.1mm 미만";
        break;
        case (1>$code && 0<$code):
            return "0.1mm 이상 1mm 미만";
        break;
        case (4>=$code && 1<=$code):
            return "1 mm 이상 5 mm 미만";
        break;
        case (9>=$code && 5<=$code):
            return "5 mm 이상 10 mm 미만";
        break;
        case (19>=$code && 10<=$code):
            return "10 mm 이상 20 mm 미만";
        break;
        case (39>=$code && 20<=$code):
            return "20 mm 이상 40 mm 미만";
        break;
        case (69>=$code && 40<=$code):
            return "40 mm 이상 70 mm 미만";
        break;
        case (70<=$code):
            return "70 mm 이상";
        break;
    }
}

//낙뢰 코드
function lgt_code($code){
    switch($code){
        case 0:
            return "없음";
        break;
        case 1:
            return "낮음";
        break;
        case 2:
            return "보통";
        break;
        case 3:
            return "높음";
        break;
    }
}

function pty_code($code){
    switch($code){
        case 0:
            return "없음";
        break;
        case 1:
            return "비";
        break;
        case 2:
            return "비/눈";   //비와 눈이 함께 오는 것을 말함
        break;
        case 3:
            return "눈";
        break;
    }
}

//동서바람성분
function uuu_code($code){
    if($code < 0){
        $code *= -1;
        return "서 $code m/s";
    }else if($code > 0){
        return "동 $code m/s";
    }else if($code == 0){
        return "0 m/s";
    }
}

//남서 바람성분
function vvv_code($code){
    if($code < 0){
        $code *= -1;
        return "남 $code m/s";
    }else if($code > 0){
        return "북 $code m/s";
    }else if($code == 0){
        return "0 m/s";
    }
}

//풍향 코드
function vec_code($code){
    switch($code){
        case (($code >= 0 && $code < 11.25) || ($code >= 348.75 && $code < 360)):
            return "N";
        break;
        case ($code >= 11.25 && $code < 33.75):
            return "NNE";
        break;
        case ($code >= 33.75 && $code < 56.25):
            return "NE";
        break;
        case ($code >= 56.25 && $code < 78.75):
            return "ENE";
        break;
        case ($code >= 78.75 && $code < 101.25):
            return "E";
        break;
        case ($code >= 101.25 && $code < 123.75):
            return "ESE";
        break;
        case ($code >= 123.75 && $code < 146.25):
            return "SE";
        break;
        case ($code >= 146.25 && $code <= 168.75):
            return "SSE";
        break;
        case ($code >= 168.75 && $code <= 191.25):
            return "S";
        break;
        case ($code >= 191.25 && $code <= 213.75):
            return "SSW";
        break;
        case ($code >= 213.75 && $code <= 236.25):
            return "SW";
        break;
        case ($code >= 236.25 && $code <= 258.75):
            return "WSW";
        break;
        case ($code >= 258.75 && $code <= 281.25):
            return "W";
        break;
        case ($code >= 281.25 && $code <= 303.75):
            return "WNW";
        break;
        case ($code >= 303.75 && $code <= 326.25):
            return "NW";
        break;
        case ($code >= 326.25 && $code <= 348.75):
            return "NNW";
        break;
    }
}

//풍속 코드
function wsd_code($code){
    switch($code){
        case ($code < 4):
            return "4m/s 미만";
        break;
        case ($code >= 4 && $code < 9):
            return "4m/s 이상 9m/s 미만";
        break;
        case ($code >= 9 && $code < 14):
            return "9m/s 이상 14m/s 미만";
        break;
        case ($code >= 14):
            return "14m/s 이상";
        break;
    }
}
?>