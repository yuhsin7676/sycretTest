<?php

function genDocTest(){

    define("BASE_URL", ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . "://" . $_SERVER['HTTP_HOST']);

    $url = BASE_URL . '/gendoc';
    $params = array(
        "URLTemplate"=> "https://sycret.ru/service/apigendoc/forma_025u.xml",
        "RecordID"=> 30
    );
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'GET',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));
    $result = json_decode($result);
    
    $today = date("Y-m-d H-i-s");
    
    if($result == false)
        echo "К сожалению, тест не пройден!";
    else if($result->URLWord == "/".$today.".doc" && $result->URLPDF === "/".$today.".pdf")
        echo "Тест пройден";
    else
        echo "К сожалению, тест не пройден!";

}

