<?php

$params = $_POST["params"];
$params = json_decode($params);

$URLTemplate = $params->URLTemplate;
$RecordID = $params->RecordID;

$result = genDoc($URLTemplate, $RecordID);
$result = json_encode($result);
echo $result;

/********************************************************
*  Функции
*********************************************************/

function getApiGenDoc(){

    $url = 'https://sycret.ru/service/apigendoc/apigendoc';
    $params = array(
        //"use" => 'surname', // Закомментировал, так как этот параметр ни на что не влияет
        "text" => '_',
        // "recordid" => '30' // Закомментировал по той же причине
    );
    $result = file_get_contents($url, false, stream_context_create(array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => http_build_query($params)
        )
    )));

    return $result;

}

function genDoc($URLTemplate, $RecordID){

    $result = getApiGenDoc();
    $resultdata = explode(" ", json_decode($result)->resultdata);

    $simpleXMLElement = new SimpleXMLElement('https://sycret.ru/service/apigendoc/forma_025u.xml', 0, true);

    $useElement = $simpleXMLElement->children('w', true)->body->children('wx', true)
    ->sect->children('ns1', true)->use->children('w', true)
    ->tbl[4]->tr->tc[1]->p->children('ns1', true)->use;
    $surname = $useElement->text[0]->children('w', true)->r->t;
    $name = $useElement->text[1]->children('w', true)->r->t;
    $secondname = $useElement->text[2]->children('w', true)->r->t;

    $surname[0] = $resultdata[0];
    $name[0] = $resultdata[1];
    $secondname[0] = $resultdata[2];

    $xml = $sxe->asXML();

    $today = date("Y-m-d H-i-s");

    if (!file_exists("generate")) 
        mkdir("generate");

    file_put_contents("generate/".$today.".doc", $xml);
    //file_put_contents("generate/".$today.".pdf", $xml);

    $result = array(
        "URLWord" => "/".$today.".doc",
        "URLPDF" => "/".$today.".pdf"
    );

    return $result;

}