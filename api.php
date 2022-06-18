<?php

$params = $_POST["params"];
$params = json_decode($params);

$URLTemplate = $params->URLTemplate;
$RecordID = $params->RecordID;

$result = genDoc($URLTemplate, $RecordID);
$result = json_encode($result);
echo $result;

/********************************************************
*
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
    $strs = explode(" ", json_decode($result)->resultdata);

    $sxe = new SimpleXMLElement('https://sycret.ru/service/apigendoc/forma_025u.xml', 0, true);

    $sxeW = $sxe->children('w', true)->body->children('wx', true)->sect->children('ns1', true)->use->children('w', true);
    $sxeT0 = $sxeW->tbl[4]->tr->tc[1]->p->children('ns1', true)->use->text[0]->children('w', true)->r->t;
    $sxeT1 = $sxeW->tbl[4]->tr->tc[1]->p->children('ns1', true)->use->text[1]->children('w', true)->r->t;
    $sxeT2 = $sxeW->tbl[4]->tr->tc[1]->p->children('ns1', true)->use->text[2]->children('w', true)->r->t;

    $sxeT0[0] = $strs[0];
    $sxeT1[0] = $strs[1];
    $sxeT2[0] = $strs[2];

    $xml = $sxe->asXML();

    $today = date("Y-m-d H-i-s");

    if (!file_exists("generate")) 
        mkdir("generate");

    file_put_contents("generate/".$today.".doc", $xml);
    //file_put_contents("generate/".$today.".pdf", $a);

    $result = array(
        "URLWord" => "/".$today.".doc",
        "URLPDF" => "/".$today.".pdf"
    );

    return $result;

}