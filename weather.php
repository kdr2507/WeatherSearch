<?php
include '/weather_code.php';
header("Content-Type: text/html; charset=utf-8");

$latitude   = $_POST["latitude"];     //위도 좌표
$longitude  = $_POST["longitude"];   //경도 좌표
$language   = $_POST["language"];    //언어

get_weather_info($latitude, $longitude, $language);
exit(0);

function get_weather_info($latitude, $longitude, $language)
{
    $now_date = date("Ymd");
    $now_time = date("Hi");
    
    $ch       = curl_init();

    curl_setopt($ch, CURLOPT_URL, "api.openweathermap.org/data/2.5/forecast?APPID=APIKEY$latitude&lon=$longitude&lang=$language");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Accept: application/json",
    ));

    $response   = curl_exec($ch);
    curl_close($ch);
    
    $result     = json_decode($response);
    $list       = $result->list;
    
    
    echo "<tr>";
    echo "<td>Date</td>";
    echo "<td>Weather</td>";
    echo "<td>Description</td>";
    echo "<td>Wind</td>";
    echo "<td>Temp</td>";
    echo "<td>Humidity</td>";
    echo "</tr>"; 
    
    foreach($list as $key => $lists){
        $date   = explode(" ", $lists->dt_txt);
        $day    = $date[0];
        $time   = $date[1];
        
        $weather        = $lists->weather[0]->main;
        $description    = $lists->weather[0]->description;
        $windSpeed      = $lists->wind->speed;                      //풍속
        $windDeg        = vec_code($lists->wind->deg);              //풍향
        $temp           = round((($lists->main->temp)-272.15), 1);  //온도 (켈빈 -> 섭씨))
        $humidity       = $lists->main->humidity;                   //습도
        
        echo "<tr>";
            echo "<td>";
            if($key == 0 || $time == "00:00:00"){
                echo "$day";
            }else{
                echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
            }
            echo " $time</td>";
            echo "<td>$weather</td>";
            echo "<td>$description</td>";
            echo "<td>$windDeg $windSpeed m/s</td>";
            echo "<td>$temp °C</td>";
            echo "<td>$humidity %</td>";
        echo "</tr>";
    }
}

?>
